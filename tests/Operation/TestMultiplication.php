<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

use PHPUnit\Framework\TestCase;

class TestMultiplication extends TestCase
{

    public function testExecute(): void
    {
        $multiplication = new Multiplication();
        $this->assertSame('21.0000', $multiplication->execute(["", "21.0000"]));
    }

}