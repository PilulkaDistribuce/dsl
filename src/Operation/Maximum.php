<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;


class Maximum implements OperationInterface
{

    public function execute(array $inputs)
    {
        return max($inputs);
    }

}