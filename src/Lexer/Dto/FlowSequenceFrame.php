<?php

declare(strict_types=1);

/*
 * This file is part of the YAML Token project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\YamlToken\Lexer\Dto;

/**
 * Lexer state frame for an open flow sequence {@code [...]} (reserved for future per-sequence lexer state).
 */
final readonly class FlowSequenceFrame implements FlowCollectionFrameInterface
{
}
