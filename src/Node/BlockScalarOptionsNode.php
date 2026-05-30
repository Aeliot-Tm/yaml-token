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

use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;

class BlockScalarOptionsNode extends AbstractNode
{
    private ?ChompingIndicatorNode $chompingIndicator = null;
    private ?IndentationIndicatorNode $indentationIndicator = null;
    private ?BlockScalarIndicatorNode $typeIndicator = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof ChompingIndicatorNode) {
            if (null !== $this->chompingIndicator) {
                throw new UnexpectedStateException('Attempt to set block scalar chomping indicator twice');
            }
            $this->chompingIndicator = $child;
        } elseif ($child instanceof IndentationIndicatorNode) {
            if (null !== $this->indentationIndicator) {
                throw new UnexpectedStateException('Attempt to set block scalar indentation indicator twice');
            }
            $this->indentationIndicator = $child;
        } elseif ($child instanceof BlockScalarIndicatorNode) {
            if (null !== $this->typeIndicator) {
                throw new UnexpectedStateException('Attempt to set block scalar type indicator twice');
            }
            $this->typeIndicator = $child;
        }

        parent::addChild($child);
    }

    public function getChompingIndicator(): ?ChompingIndicatorNode
    {
        return $this->chompingIndicator;
    }

    public function getIndentationIndicator(): ?IndentationIndicatorNode
    {
        return $this->indentationIndicator;
    }

    public function getTypeIndicator(): ?BlockScalarIndicatorNode
    {
        return $this->typeIndicator;
    }

    public function isFolded(): bool
    {
        return $this->typeIndicator?->getToken()?->type?->isFoldedBlockScalarIndicator();
    }

    public function isLiteral(): bool
    {
        return $this->typeIndicator?->getToken()?->type?->isLiteralBlockScalarIndicator();
    }

    public function removeChild(Node $child): void
    {
        if ($this->chompingIndicator === $child) {
            $this->chompingIndicator = null;
        } elseif ($this->indentationIndicator === $child) {
            $this->indentationIndicator = null;
        } elseif ($this->typeIndicator === $child) {
            $this->typeIndicator = null;
        }

        parent::removeChild($child);
    }
}
