<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider provideExamples
     */
    public function testBuild(string $input, string $expected)
    {
        $parser = new Parser();
        $ast = $parser->parse($input);
        $this->assertTrue(is_array($ast));
        $representation = $this->getRepresentation($ast);
        $this->assertEquals($expected, $representation);
    }


    public function provideExamples()
    {
        return [
            ['(max {a} {b})', '(max {a} {b})'],
            ['{-1.55}', '{-1.55}'],
            ['(+ {a} {b} {c})', '(+ {a} {b} {c})'],
            ['{a} + {b} + {c}', '(+ (+ {a} {b}) {c})'],
            ['({a} + {b}) * {c}', '(* (+ {a} {b}) {c})'],
            ['{a} + {b}', '(+ {a} {b})'],
            ['(max (max {a} {b} {c}) {d} {e})', '(max (max {a} {b} {c}) {d} {e})']
        ];
    }

    private function getRepresentation(array $root): string
    {
        $representation = '';
        if(isset($root['operation'])) {
            $representation = '(' . $root['operation']->getId();
        }
        foreach ($root['items'] as $item) {
            if(is_array($item)) {
                $representation .= ' '.$this->getRepresentation($item);
            } else {
                $representation .= ' {' . $item->getId() . '}';
            }
        }
        if(isset($root['operation'])) {
            $representation .= ')';
        }

        return trim($representation);
    }

}
