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

enum NodeVisitorSignal
{
    /**
     * If {@see NodeVisitorInterface::enterNode()} returns this value, children of the current node
     * are not traversed. {@see NodeVisitorInterface::leaveNode()} is still invoked for the current node.
     */
    case DontTraverseChildren;

    /**
     * If {@see NodeVisitorInterface::enterNode()} or {@see NodeVisitorInterface::leaveNode()}
     * returns this value, traversal is aborted. {@see NodeVisitorInterface::afterTraverse()}
     * is still invoked for visitors that received {@see NodeVisitorInterface::beforeTraverse()}.
     */
    case StopTraversal;
}
