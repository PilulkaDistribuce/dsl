<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Representation implements OperationInterface
{

    public function execute(array $inputs)
    {
        return $inputs[0];
    }

}
