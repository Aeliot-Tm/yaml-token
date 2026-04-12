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

namespace Aeliot\YamlToken\Node;

/**
 * Flow mapping - superset: object of fields and values (c-flow-mapping :140).
 * Contains: "{" + KeyValueCoupleNode[] + "}".
 */
class FlowMappingNode extends AbstractNode
{
}
