<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{

    /**
     * @dataProvider lexerExamplesProvider
     * @param string $input
     * @param array $expected
     */
    public function testTokenize(string $input, array $expected)
    {
        $tokenizer = new Tokenizer();
        $tokens = $tokenizer->tokenize($input);
        $this->assertEquals($expected, $tokens);
    }

    public function lexerExamplesProvider(): array
    {
        return [
            [
                'input' => '{"Hello world!"}',
                'expected' => [
                    ['type' => Token::TEXT, 'id' => 'Hello world!'],
                ],
            ],
            [
                'input' => '(max {a} {b})',
                'expected' => [
                    ['type' => Token::OPEN_BRACKET],
                    ['type' => Token::OPERATION, 'id' => 'max'],
                    ['type' => Token::VARIABLE, 'id' => 'a'],
                    ['type' => Token::VARIABLE, 'id' => 'b'],
                    ['type' => Token::CLOSE_BRACKET],
                ],
            ],
            [
                'input' => '{-1.55}',
                'expected' => [
                    ['type' => Token::NUMBER, 'id' => '-1.55'],
                ],
            ],
            [
                'input' => '({a} + {b}) * {-2.1}',
                'expected' => [
                    ['type' => Token::OPEN_BRACKET],
                    ['type' => Token::VARIABLE, 'id' => 'a'],
                    ['type' => Token::OPERATION, 'id' => '+'],
                    ['type' => Token::VARIABLE, 'id' => 'b'],
                    ['type' => Token::CLOSE_BRACKET],
                    ['type' => Token::OPERATION, 'id' => '*'],
                    ['type' => Token::NUMBER, 'id' => '-2.1'],
                ],
            ],
            [
                'input' => '{České slovo 193} * {Příliš žluťoučký kůň úpěl ďábelské ódy}',
                'expected' => [
                    ['type' => Token::VARIABLE, 'id' => 'České slovo 193'],
                    ['type' => Token::OPERATION, 'id' => '*'],
                    ['type' => Token::VARIABLE, 'id' => 'Příliš žluťoučký kůň úpěl ďábelské ódy'],
                ],
            ],
            [
                'input' => '({a} + {b})/({c} - {d})',
                'expected' => [
                    ['type' => Token::OPEN_BRACKET],
                    ['type' => Token::VARIABLE, 'id' => 'a'],
                    ['type' => Token::OPERATION, 'id' => '+'],
                    ['type' => Token::VARIABLE, 'id' => 'b'],
                    ['type' => Token::CLOSE_BRACKET],
                    ['type' => Token::OPERATION, 'id' => '/'],
                    ['type' => Token::OPEN_BRACKET],
                    ['type' => Token::VARIABLE, 'id' => 'c'],
                    ['type' => Token::OPERATION, 'id' => '-'],
                    ['type' => Token::VARIABLE, 'id' => 'd'],
                    ['type' => Token::CLOSE_BRACKET],
                ],
            ],
        ];
    }

}
