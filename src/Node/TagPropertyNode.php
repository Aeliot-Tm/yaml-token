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

use Aeliot\YamlToken\Enum\TokenType;

final class TagPropertyNode extends AbstractNode
{
    private ?TagNode $handle = null;
    private ?TagBodyNode $body = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof TagNode) {
            $this->handle = $child;
        }

        if ($child instanceof TagBodyNode) {
            $this->body = $child;
        }

        parent::addChild($child);
    }

    public function getBody(): ?string
    {
        return $this->body?->getBody();
    }

    public function getBodyNode(): ?TagBodyNode
    {
        return $this->body;
    }

    public function getHandle(): ?TagNode
    {
        return $this->handle;
    }

    public function isNonSpecific(): bool
    {
        return TokenType::TAG_NON_SPECIFIC === $this->handle?->getToken()?->type;
    }
}
