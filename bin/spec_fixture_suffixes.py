#!/usr/bin/env python3
from __future__ import annotations

import argparse
import re
import subprocess
import urllib.request
from dataclasses import dataclass
from html import unescape
from pathlib import Path
from typing import Iterable
import hashlib
import tempfile


ROOT = Path(__file__).resolve().parents[1]
FIXTURE_ROOT = ROOT / "tests" / "fixture" / "spec"


SPEC_URLS: dict[str, str] = {
    "1.0": "https://yaml.org/spec/1.0/",
    "1.1": "https://yaml.org/spec/1.1/",
    "1.2.0": "https://yaml.org/spec/1.2.0/",
    "1.2.1": "https://yaml.org/spec/1.2.1/",
    "1.2.2": "https://yaml.org/spec/1.2.2/",
}


@dataclass(frozen=True)
class SpecHeading:
    number: str
    title: str


def _download(url: str) -> str:
    cache_dir = Path(tempfile.gettempdir()) / "yaml-token-spec-cache"
    cache_dir.mkdir(parents=True, exist_ok=True)
    key = hashlib.sha256(url.encode("utf-8")).hexdigest()[:16]
    cache_path = cache_dir / f"{key}.html"
    if cache_path.exists():
        return cache_path.read_text(encoding="utf-8", errors="replace")

    req = urllib.request.Request(url, headers={"User-Agent": "yaml-token-fixture-mapper/1.0"})
    with urllib.request.urlopen(req, timeout=30) as resp:
        html = resp.read().decode("utf-8", "replace")
    cache_path.write_text(html, encoding="utf-8")
    return html


def _extract_headings_122(html: str) -> list[SpecHeading]:
    headings: list[SpecHeading] = []
    for m in re.finditer(r"<h[1-6][^>]*>\s*([0-9]+(?:\.[0-9]+)*)\.\s*([^<]+)</h[1-6]>", html, re.I):
        headings.append(
            SpecHeading(
                number=m.group(1).strip(),
                title=unescape(m.group(2)).strip(),
            )
        )
    return headings


def _extract_headings_docbook_toc(html: str) -> list[SpecHeading]:
    headings: list[SpecHeading] = []
    for m in re.finditer(r'<a\s+href="#[^"]+">\s*([0-9]+(?:\.[0-9]+)*)\.\s*([^<]+)</a>', html, re.I):
        h = SpecHeading(number=m.group(1).strip(), title=unescape(m.group(2)).strip())
        # Avoid runaway duplicates from repeated nav fragments.
        if headings and headings[-1] == h:
            continue
        headings.append(h)
    return headings


def get_spec_headings(version: str) -> list[SpecHeading]:
    url = SPEC_URLS[version]
    html = _download(url)
    if version == "1.2.2":
        hs = _extract_headings_122(html)
        if hs:
            return hs
    hs = _extract_headings_docbook_toc(html)
    if not hs:
        raise RuntimeError(f"Failed to extract headings for {version} from {url}")
    return hs


def _index_titles(headings: list[SpecHeading]) -> dict[str, str]:
    """
    Map normalized heading titles to section numbers.
    """
    out: dict[str, str] = {}
    for h in headings:
        key = re.sub(r"\s+", " ", h.title.strip().lower())
        out[key] = h.number
    return out


def _section_by_title(version: str, title_index: dict[str, str], title: str) -> str:
    key = re.sub(r"\s+", " ", title.strip().lower())
    if key not in title_index:
        raise RuntimeError(f"[{version}] Missing spec heading title: {title!r}")
    return title_index[key]


def _strip_existing_suffix(stem: str) -> str:
    """
    Our filenames are <base>_<section>.yaml. Convert back to <base>.
    This is intentionally conservative: only strips a trailing _<digits(.digits)*>.
    """
    return re.sub(r"_[0-9]+(?:\.[0-9]+)*$", "", stem)


def choose_primary_section(version: str, filename_base: str, title_index: dict[str, str]) -> str:
    """
    Choose the primary section for suffixing based on the YAML spec structure.
    This avoids fuzzy matching against headings and instead maps each fixture
    to the most directly defining titled section where possible.
    """
    # Common: comments & document stream markers
    if filename_base.startswith("comment-"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Throwaway comments")
        return _section_by_title(version, title_index, "Comments")

    if filename_base in ("document-start", "document-end", "multi-document", "bare-document"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Document")
        if version in ("1.1",):
            return _section_by_title(version, title_index, "Documents")
        # 1.2.x
        return _section_by_title(version, title_index, "Documents")

    # Directives
    if filename_base.startswith("directive"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Directive")
        return _section_by_title(version, title_index, "Directives")

    # Anchors, aliases, tags
    if filename_base == "anchor-alias":
        if version == "1.0":
            return _section_by_title(version, title_index, "Anchor")
        if version == "1.1":
            return _section_by_title(version, title_index, "Anchors and Aliases")
        return _section_by_title(version, title_index, "Anchors and Aliases")

    if filename_base.startswith("tag-"):
        # Prefer the most directly defining tag section per version
        if version == "1.0":
            return _section_by_title(version, title_index, "Tag")
        if version == "1.1":
            return _section_by_title(version, title_index, "Node Tags")
        return _section_by_title(version, title_index, "Node Tags")

    # Collections
    if filename_base in ("block-sequence",):
        if version == "1.0":
            return _section_by_title(version, title_index, "Sequence")
        if version == "1.1":
            return _section_by_title(version, title_index, "Block Sequences")
        return _section_by_title(version, title_index, "Block Sequences")

    if filename_base in ("block-mapping",):
        if version == "1.0":
            return _section_by_title(version, title_index, "Mapping")
        if version == "1.1":
            return _section_by_title(version, title_index, "Block Mappings")
        return _section_by_title(version, title_index, "Block Mappings")

    if filename_base in ("flow-sequence",):
        if version == "1.0":
            return _section_by_title(version, title_index, "Sequence")
        if version == "1.1":
            return _section_by_title(version, title_index, "Flow Sequences")
        return _section_by_title(version, title_index, "Flow Sequences")

    if filename_base in ("flow-mapping",):
        if version == "1.0":
            return _section_by_title(version, title_index, "Mapping")
        if version == "1.1":
            return _section_by_title(version, title_index, "Flow Mappings")
        return _section_by_title(version, title_index, "Flow Mappings")

    if filename_base in (
        "trailing-comma",
        "flow-empty-key",
        "flow-omitted-value",
        "single-pair-flow",
        "explicit-flow-pair",
        "implicit-key",
        "complex-key",
        "compact-nested",
        "sequence-entry-types",
        "value-key",
        "merge-key",
    ):
        # These are all mapping/sequence grammar edge-cases; map them to mapping/sequence sections.
        if version == "1.0":
            return _section_by_title(version, title_index, "Mapping")
        if version == "1.1":
            return _section_by_title(version, title_index, "Flow Mappings")
        # 1.2.x
        if filename_base in ("trailing-comma",):
            return _section_by_title(version, title_index, "Flow Sequences")
        return _section_by_title(version, title_index, "Flow Mappings")

    # Scalar styles
    if filename_base.startswith("single-quoted"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Single Quoted")
        if version == "1.1":
            return _section_by_title(version, title_index, "Single Quoted")
        return _section_by_title(version, title_index, "Single-Quoted Style")

    if filename_base.startswith("double-quoted"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Double Quoted")
        if version == "1.1":
            return _section_by_title(version, title_index, "Double Quoted")
        return _section_by_title(version, title_index, "Double-Quoted Style")

    if filename_base.startswith("plain-") or filename_base == "plain-scalar":
        if version == "1.0":
            return _section_by_title(version, title_index, "Plain")
        if version == "1.1":
            return _section_by_title(version, title_index, "Plain")
        return _section_by_title(version, title_index, "Plain Style")

    if filename_base.startswith("literal-"):
        if version == "1.0":
            return _section_by_title(version, title_index, "Literal")
        if version == "1.1":
            return _section_by_title(version, title_index, "Literal")
        return _section_by_title(version, title_index, "Literal Style")

    if filename_base.startswith("folded-") or filename_base == "folded-block":
        if version == "1.0":
            return _section_by_title(version, title_index, "Folded")
        if version == "1.1":
            return _section_by_title(version, title_index, "Folded")
        return _section_by_title(version, title_index, "Folded Style")

    if filename_base in ("indent-indicator",):
        if version == "1.0":
            return _section_by_title(version, title_index, "Explicit Indentation")
        return _section_by_title(version, title_index, "Block Indentation Indicator")

    if filename_base in ("caret-escape",):
        # YAML 1.0-only escape sequence lives under the escaping rules.
        if version == "1.0":
            return _section_by_title(version, title_index, "Escaping")
        raise RuntimeError(f"[{version}] caret-escape should not exist in this version")

    if filename_base in ("block-scalar-tab",):
        # Tabs in indentation is discussed in indentation rules; map to indentation section.
        if version == "1.0":
            return _section_by_title(version, title_index, "Indentation")
        return _section_by_title(version, title_index, "Indentation Spaces")

    # Types / implicit tag resolution examples
    if filename_base in ("null", "boolean", "integer", "float", "float-special", "timestamp", "sexagesimal", "empty-scalar", "empty-scalar-multiple", "empty-scalar-blank-before-continuation"):
        if version in ("1.2.0", "1.2.1", "1.2.2"):
            # Use Core Schema as the most central (covers bool/int/float/null).
            return _section_by_title(version, title_index, "Core Schema")
        # 1.0 / 1.1: these examples are introduced in Tags preview.
        return _section_by_title(version, title_index, "Tags")

    raise RuntimeError(f"[{version}] No mapping rule for fixture '{filename_base}'")


def list_fixture_bases(version: str) -> list[str]:
    p = FIXTURE_ROOT / version
    return [_strip_existing_suffix(f.stem) for f in sorted(p.glob("*.yaml"))]


def build_mapping(version: str) -> dict[str, str]:
    headings = get_spec_headings(version)
    title_index = _index_titles(headings)
    bases = sorted(set(list_fixture_bases(version)))
    return {base: choose_primary_section(version, base, title_index) for base in bases}


def _git_mv(src: Path, dst: Path, dry_run: bool) -> None:
    if dry_run:
        print(f"DRY git mv {src} -> {dst}")
        return
    subprocess.check_call(["git", "mv", str(src), str(dst)], cwd=str(ROOT))


def apply_renames(version: str, mapping: dict[str, str], dry_run: bool) -> dict[str, str]:
    renames: dict[str, str] = {}
    for base, section in sorted(mapping.items()):
        # Old name may already include an older section suffix; locate it by glob.
        candidates = sorted((FIXTURE_ROOT / version).glob(f"{base}_*.yaml"))
        if not candidates:
            # also allow pre-suffixed-less (shouldn't happen now, but keeps script usable)
            candidates = sorted((FIXTURE_ROOT / version).glob(f"{base}.yaml"))
        if len(candidates) != 1:
            raise RuntimeError(f"[{version}] Expected exactly one candidate for {base}, got {len(candidates)}: {candidates}")
        old = candidates[0]
        new_base = f"{base}_{section}"
        new = FIXTURE_ROOT / version / f"{new_base}.yaml"
        renames[base] = new_base

        if old.name == new.name:
            continue
        if not old.exists():
            raise RuntimeError(f"Missing fixture file: {old}")
        if new.exists():
            raise RuntimeError(f"Rename collision: {new} already exists")
        _git_mv(old, new, dry_run=dry_run)
    return renames


def iter_php_files() -> Iterable[Path]:
    yield from (ROOT / "tests").rglob("*.php")


def update_references(version: str, renames: dict[str, str], dry_run: bool) -> int:
    changed_files = 0
    for php in iter_php_files():
        content = php.read_text(encoding="utf-8")
        new_content = content
        for base, new_base in renames.items():
            # Replace both the unsuffixed legacy ref and any previously-suffixed ref.
            new_ref = f"/fixture/spec/{version}/{new_base}.yaml"

            old_ref_unsuffixed = f"/fixture/spec/{version}/{base}.yaml"
            new_content = new_content.replace(old_ref_unsuffixed, new_ref)

            # Already-suffixed: /fixture/spec/<version>/<base>_<something>.yaml
            # We only rewrite if the suffix matches the <digits(.digits)*> pattern.
            old_ref_pattern = re.compile(
                rf"(/fixture/spec/{re.escape(version)}/{re.escape(base)})_[0-9]+(?:\.[0-9]+)*\.yaml"
            )
            new_content = old_ref_pattern.sub(rf"{new_ref}", new_content)
        if new_content != content:
            if dry_run:
                print(f"DRY update {php}")
            else:
                php.write_text(new_content, encoding="utf-8")
                changed_files += 1
    return changed_files


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--dry-run", action="store_true")
    ap.add_argument(
        "--versions",
        nargs="*",
        default=["1.0", "1.1", "1.2.0", "1.2.1", "1.2.2"],
    )
    args = ap.parse_args()

    # Enforce identical naming across 1.2.x by computing mapping from 1.2.2 only and reusing it.
    mappings: dict[str, dict[str, str]] = {}
    want_12x = any(v in args.versions for v in ("1.2.0", "1.2.1", "1.2.2"))
    if want_12x:
        m122 = build_mapping("1.2.2")
        mappings["1.2.0"] = m122
        mappings["1.2.1"] = m122
        mappings["1.2.2"] = m122

    for v in args.versions:
        if v in mappings:
            continue
        mappings[v] = build_mapping(v)

    all_renames: dict[str, dict[str, str]] = {}
    for v in args.versions:
        all_renames[v] = apply_renames(v, mappings[v], dry_run=args.dry_run)

    for v in args.versions:
        update_references(v, all_renames[v], dry_run=args.dry_run)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())

