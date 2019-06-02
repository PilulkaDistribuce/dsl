<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Representation implements OperationInterface
{

    public function execute(array $inputs)
    {
        if (count($inputs) !== 1) {
            throw new \InvalidArgumentException(
                "Single representation is possible only for one token."
            );
        }
        return $inputs[0];
    }

}
