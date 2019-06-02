<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use PHPUnit\Framework\TestCase;

class ActionTreeTest extends TestCase
{

    /**
     * @param string $input
     * @param array $context
     * @param $expectedResult
     * @dataProvider provideTestData
     */
    public function testExecute(string $input, array $context,  $expectedResult)
    {
        $parser = new Parser();
        $ast = $parser->parse($input);
        $actionTree = new ActionTree();
        $result = $actionTree->execute($ast, $context);
        $this->assertEquals($expectedResult, $result);
    }

    public function provideTestData(): array
    {
        return [
            ['{"ahoj"}', [], 'ahoj'],
            ['(min {a} {b} {c})', ['a' => 49, 'b' => -7, 'c' => 0], -7],
            ['(max {a} {b} {c})', ['a' => 49, 'b' => -7, 'c' => 0], 49],
            ['({a} - {b}) / {b}', ['a' => 49, 'b' => -7,], -8],
            ['{a} / {b}', ['a' => 49, 'b' => -7,], -7],
            ['{a} * {b}', ['a' => 7, 'b' => -7,], -49],
            ['({a} + {b}) - {c}', ['a' => 5, 'b' => 2, 'c' => 20], -13],
            ['{a} - {b}', ['a' => 5, 'b' => 2], 3],
            ['{a} + {b}', ['a' => 1, 'b' => 4], 5],
            ['{a} + {b} + {c}', ['a' => 1, 'b' => 4, 'c' => 2], 7],
            ['{-3.14}', [], -3.14],
            ['{A3}', ['A3' => 'Text representation'], 'Text representation'],
        ];
    }

}
