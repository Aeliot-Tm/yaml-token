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

namespace Aeliot\YamlToken\Parser\Helper;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\FoldedBlockScalarNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\MergeIndicatorNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\SingleQuotedScalarNode;
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\YamlDirectiveVersionNode;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Token\Token;

final readonly class NodeFactory
{
    public function __construct(private ErrorHelper $errorHelper)
    {
    }

    public function createScalarNode(Token $token): ScalarNode
    {
        return match ($token->type) {
            TokenType::DOUBLE_QUOTED_SCALAR => new DoubleQuotedScalarNode($token),
            TokenType::FOLDED_BLOCK_SCALAR => new FoldedBlockScalarNode($token),
            TokenType::LITERAL_BLOCK_SCALAR => new LiteralBlockScalarNode($token),
            TokenType::PLAIN_SCALAR => new PlainScalarNode($token),
            TokenType::SINGLE_QUOTED_SCALAR => new SingleQuotedScalarNode($token),
            default => throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected scalar token, got %s', $token->type->value), $token)),
        };
    }

    /**
     * Wraps layout/indicator tokens collected by {@see \Aeliot\YamlToken\Parser\SubParser\Consumer::collectTypes()}
     * and {@see \Aeliot\YamlToken\Parser\SubParser\Consumer::collectUntil()} with their corresponding nodes.
     * Only token types that those collectors can deliver are listed here; structural tokens
     * (anchors, tags, block scalar indicators) are wrapped at their dedicated parsing call sites
     * and never reach this method.
     */
    public function createSimpleNode(Token $token): Node
    {
        return match ($token->type) {
            TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR => new BlockScalarChompingIndicatorNode($token),
            TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR => new BlockScalarIndentationIndicatorNode($token),
            TokenType::COMMENT => new CommentNode($token),
            TokenType::DIRECTIVE_YAML_INDICATOR => new YamlDirectiveIndicatorNode($token),
            TokenType::DIRECTIVE_YAML_VERSION => new YamlDirectiveVersionNode($token),
            TokenType::DIRECTIVE_TAG_HANDLE => new TagDirectiveHandleNode($token),
            TokenType::DIRECTIVE_TAG_INDICATOR => new TagDirectiveIndicatorNode($token),
            TokenType::DIRECTIVE_TAG_PREFIX => new TagDirectivePrefixNode($token),
            TokenType::FLOW_ENTRY => new FlowEntryNode($token),
            TokenType::FLOW_MAPPING_END => new FlowMappingEndNode($token),
            TokenType::FLOW_MAPPING_START => new FlowMappingStartNode($token),
            TokenType::FLOW_SEQUENCE_END => new FlowSequenceEndNode($token),
            TokenType::FLOW_SEQUENCE_START => new FlowSequenceStartNode($token),
            TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
            TokenType::LITERAL_BLOCK_SCALAR_INDICATOR => new BlockScalarIndicatorNode($token),
            TokenType::INDENTATION => new IndentationNode($token),
            TokenType::MERGE_INDICATOR => new MergeIndicatorNode($token),
            TokenType::NEWLINE => new NewLineNode($token),
            TokenType::SEQUENCE_ENTRY => new SequenceEntryNode($token),
            TokenType::VALUE_INDICATOR => new ValueIndicatorNode($token),
            TokenType::WHITESPACE => new WhitespaceNode($token),
            default => throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Not configured node for token type: %s', $token->type->value), $token)),
        };
    }
}
