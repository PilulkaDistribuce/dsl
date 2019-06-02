<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Minimum implements OperationInterface
{

    public function execute(array $inputs)
    {
        return min($inputs);
    }

}
