#!/usr/bin/env python3
"""
Import goccy/go-yaml YAML test suite inputs into tests/fixture/go_yaml/.

Upstream layout (under var/external_fixtures/go-yaml/testdata/yaml-test-suite/):
  <case-directory>/in.yaml

Project layout (same relative path under each bucket):
  tests/fixture/go_yaml/<case-directory>/in.yaml
  tests/fixture/go_yaml_extra/<case-directory>/in.yaml  (when yamllint rejects)

Lexer/parser snapshots mirror that path (e.g. .../in.yaml -> .../in.php).
"""
from __future__ import annotations

import argparse
import hashlib
import shutil
import subprocess
from dataclasses import dataclass
from pathlib import Path
from shutil import which


ROOT = Path(__file__).resolve().parents[2]
SOURCE_ROOT = (ROOT / "var" / "external_fixtures" / "go-yaml" / "testdata" / "yaml-test-suite").resolve()
FIXTURE_ROOT = ROOT / "tests" / "fixture"
GO_YAML_DIR = FIXTURE_ROOT / "go_yaml"
GO_YAML_EXTRA_DIR = FIXTURE_ROOT / "go_yaml_extra"
YAMLLINT_CONFIG = ROOT / ".infra" / "scripts" / "yamllint.yaml"
UPSTREAM_CASE_FILE = "in.yaml"


@dataclass(frozen=True)
class ImportResult:
    source: Path
    dest: Path
    bucket: str
    yamllint_ok: bool
    created: bool
    skipped_reason: str = ""


def _sha256_hex(data: bytes) -> str:
    return hashlib.sha256(data).hexdigest()


def _run(cmd: list[str]) -> subprocess.CompletedProcess[str]:
    return subprocess.run(cmd, cwd=str(ROOT), text=True, capture_output=True)


def _exec_php_cli(cmd: list[str]) -> subprocess.CompletedProcess[str]:
    """
    Run a command in the environment that has PHP + composer + yamllint.

    - On host: use `docker compose exec -T php-cli ...`
    - Inside container: run command directly (docker binary is unavailable).
    """
    if which("docker") is None:
        return _run(cmd)
    return _run(["docker", "compose", "exec", "-T", "php-cli", *cmd])


def _rel_under_yaml_test_suite(path: Path) -> str:
    return path.relative_to(SOURCE_ROOT).as_posix()


def _list_sources() -> list[Path]:
    if not SOURCE_ROOT.exists():
        return []
    paths = sorted(
        (p for p in SOURCE_ROOT.rglob(UPSTREAM_CASE_FILE) if p.is_file() and p.name == UPSTREAM_CASE_FILE),
        key=_rel_under_yaml_test_suite,
    )
    return paths


def _dest_paths_for_source(source: Path) -> tuple[Path, Path]:
    rel = source.relative_to(SOURCE_ROOT)
    return GO_YAML_DIR / rel, GO_YAML_EXTRA_DIR / rel


def _scan_project_fixture_content() -> dict[str, Path]:
    """Map SHA-256 (hex) of file bytes -> first fixture path (relative to ROOT)."""
    by_hash: dict[str, Path] = {}
    if not FIXTURE_ROOT.is_dir():
        return by_hash
    for p in FIXTURE_ROOT.rglob("*.yaml"):
        if not p.is_file():
            continue
        h = _sha256_hex(p.read_bytes())
        by_hash.setdefault(h, p)
    return by_hash


def _ensure_parent(path: Path, dry_run: bool) -> None:
    if dry_run:
        return
    path.parent.mkdir(parents=True, exist_ok=True)


def _yamllint(path: Path) -> subprocess.CompletedProcess[str]:
    return _exec_php_cli(["yamllint", "-c", str(YAMLLINT_CONFIG), str(path)])


def _composer_test_all() -> subprocess.CompletedProcess[str]:
    return _exec_php_cli(["composer", "test-all"])


def _generate_expectations(rel_under_tests_fixture: str) -> subprocess.CompletedProcess[str] | None:
    """
    Write lexer + parser snapshots under tests/lexer_expectations and
    tests/parser_expectations for a single fixture (path relative to tests/fixture/).
    """
    rel = rel_under_tests_fixture.replace("\\", "/")
    for script in (
        "bin/dev/generate-lexer-expectations.php",
        "bin/dev/generate-parser-expectations.php",
    ):
        proc = _exec_php_cli(["php", script, "--force", f"--only={rel}"])
        if proc.returncode != 0:
            return proc
    return None


def _first_case_dir_name(source: Path) -> str:
    return source.relative_to(SOURCE_ROOT).parts[0]


def import_one(
    source: Path,
    *,
    dry_run: bool,
    content_by_hash: dict[str, Path],
) -> ImportResult:
    dest_go, dest_extra = _dest_paths_for_source(source)
    source_bytes = source.read_bytes()
    source_hash = _sha256_hex(source_bytes)

    if dest_go.exists():
        return ImportResult(
            source=source,
            dest=dest_go,
            bucket="go_yaml",
            yamllint_ok=True,
            created=False,
            skipped_reason="destination_already_exists_go_yaml",
        )
    if dest_extra.exists():
        return ImportResult(
            source=source,
            dest=dest_extra,
            bucket="go_yaml_extra",
            yamllint_ok=False,
            created=False,
            skipped_reason="destination_already_exists_go_yaml_extra",
        )

    existing = content_by_hash.get(source_hash)
    if existing is not None:
        return ImportResult(
            source=source,
            dest=dest_go,
            bucket="go_yaml",
            yamllint_ok=True,
            created=False,
            skipped_reason=f"content_already_in_project:{existing.relative_to(ROOT)}",
        )

    _ensure_parent(dest_go, dry_run=dry_run)
    if dry_run:
        return ImportResult(
            source=source,
            dest=dest_go,
            bucket="go_yaml",
            yamllint_ok=True,
            created=True,
            skipped_reason="dry_run_no_copy_no_lint",
        )

    shutil.copyfile(source, dest_go)
    content_by_hash.setdefault(source_hash, dest_go)

    lint = _yamllint(dest_go)
    yamllint_ok = lint.returncode == 0
    if yamllint_ok:
        return ImportResult(source=source, dest=dest_go, bucket="go_yaml", yamllint_ok=True, created=True)

    _ensure_parent(dest_extra, dry_run=dry_run)
    if dest_extra.exists():
        dest_go.unlink()
        content_by_hash.pop(source_hash, None)
        return ImportResult(
            source=source,
            dest=dest_extra,
            bucket="go_yaml_extra",
            yamllint_ok=False,
            created=False,
            skipped_reason="go_yaml_extra_destination_race",
        )

    dest_go.rename(dest_extra)
    content_by_hash[source_hash] = dest_extra
    return ImportResult(source=source, dest=dest_extra, bucket="go_yaml_extra", yamllint_ok=False, created=True)

def main() -> int:
    ap = argparse.ArgumentParser(
        description=(
            f"Copy {UPSTREAM_CASE_FILE} files from yaml-test-suite into tests/fixture/go_yaml/ "
            f"(or go_yaml_extra/ if yamllint fails), preserving <case-dir>/{UPSTREAM_CASE_FILE} paths."
        ),
    )
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument("--limit", type=int, default=0, metavar="N", help="Import at most N files (after filters).")
    ap.add_argument("--offset", type=int, default=0, metavar="N", help="Skip the first N sources (after offset).")
    ap.add_argument(
        "--from-path",
        default="",
        metavar="REL",
        help=(
            "Only import sources whose path relative to yaml-test-suite is "
            "lexicographically >= REL (e.g. blank-lines or blank-lines/in.yaml)."
        ),
    )
    ap.add_argument(
        "--suite-filter",
        choices=["all", "edge", "spec"],
        default="all",
        help="edge: exclude case dirs named spec-example-*; spec: only those case dirs.",
    )
    args = ap.parse_args()
    if args.offset < 0:
        ap.error("--offset must be non-negative")

    sources = _list_sources()
    if args.from_path:
        key = args.from_path.strip().replace("\\", "/").lstrip("./")
        sources = [p for p in sources if _rel_under_yaml_test_suite(p) >= key]

    if args.suite_filter == "edge":
        sources = [p for p in sources if not _first_case_dir_name(p).startswith("spec-example-")]
    elif args.suite_filter == "spec":
        sources = [p for p in sources if _first_case_dir_name(p).startswith("spec-example-")]

    if args.offset > 0:
        sources = sources[args.offset :]
    if args.limit > 0:
        sources = sources[: args.limit]

    content_by_hash = _scan_project_fixture_content()

    for src in sources:
        upstream_rel = _rel_under_yaml_test_suite(src)
        result = import_one(src, dry_run=args.dry_run, content_by_hash=content_by_hash)
        print(f"[import] {upstream_rel} -> {result.dest.relative_to(ROOT)} (bucket={result.bucket}, created={result.created}, yamllint_ok={result.yamllint_ok})")
        if result.skipped_reason:
            print(f"[info] {upstream_rel}: {result.skipped_reason}")

        if args.dry_run:
            continue

        if result.created:
            rel_fixture = str(result.dest.relative_to(FIXTURE_ROOT)).replace("\\", "/")
            print(f"[expectations] --only={rel_fixture}")
            gen_err = _generate_expectations(rel_fixture)
            if gen_err is not None:
                print(gen_err.stdout)
                print(gen_err.stderr)
                print(f"[stop] expectation generation failed for --only={rel_fixture}")
                return gen_err.returncode

            proc = _composer_test_all()
            if proc.returncode != 0:
                print(proc.stdout)
                print(proc.stderr)
                print(f"[stop] composer test-all failed after importing: {result.dest.relative_to(ROOT)}")
                return proc.returncode

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
