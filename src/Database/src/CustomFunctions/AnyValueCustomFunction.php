<?php

declare(strict_types=1);

namespace Database\CustomFunctions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class AnyValueCustomFunction extends FunctionNode
{
    public function getSql(SqlWalker $sqlWalker)
    {
        /** @phpstan-ignore-next-line */
        return 'ANY_VALUE(' . $this->value->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        /** @phpstan-ignore-next-line */
        $this->value = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
