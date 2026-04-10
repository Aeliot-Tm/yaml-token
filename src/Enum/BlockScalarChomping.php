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

namespace Aeliot\YamlToken\Enum;

/**
 * Block scalar chomping from the header line (YAML 1.2+): clip is default when no +/- is present.
 */
enum BlockScalarChomping
{
    case Clip;
    case Keep;
    case Strip;
}
