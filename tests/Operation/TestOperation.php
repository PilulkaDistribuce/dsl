<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class TestOperation implements OperationInterface
{

    public function execute(array $inputs)
    {
        return 'TEST';
    }

}