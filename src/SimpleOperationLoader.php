<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use Pilulka\DSL\Operation\OperationInterface;

class SimpleOperationLoader implements OperationLoaderInterface
{

    public function load(string $operationClass): OperationInterface
    {
        return new $operationClass;
    }
}