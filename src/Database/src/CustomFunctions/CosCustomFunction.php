<?php

declare(strict_types=1);

namespace Database\CustomFunctions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class CosCustomFunction extends FunctionNode
{
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'COS(' . $sqlWalker->walkSimpleArithmeticExpression(
            /** @phpstan-ignore-next-line */
            $this->simpleArithmeticExpression
        ) . ')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        /** @phpstan-ignore-next-line */
        $this->simpleArithmeticExpression = $parser->SimpleArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
