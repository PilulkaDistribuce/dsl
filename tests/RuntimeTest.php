<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use PHPUnit\Framework\TestCase;
use Pilulka\DSL\Operation\TestOperation;

class RuntimeTest extends TestCase
{

    public function testRun()
    {
        $runtime = new Runtime([
            'test' => TestOperation::class
        ]);
        $this->assertEquals(
            'TEST',
            $runtime->execute('(test {a})', ['a' => 1])
        );
    }

    public function test__construct()
    {
        $this->assertInstanceOf(
            Runtime::class,
            new Runtime()
        );
    }
}
