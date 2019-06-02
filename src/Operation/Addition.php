<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Addition implements OperationInterface
{

    public function execute(array $inputs)
    {
        return array_sum($inputs);
    }

}
