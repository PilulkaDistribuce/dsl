<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use Pilulka\DSL\Operation\OperationInterface;

interface OperationLoaderInterface
{

    public function load(string $operationClass): OperationInterface;

}