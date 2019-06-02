<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Subtraction implements OperationInterface
{

    public function execute(array $inputs)
    {
        $minuend = null;
        foreach ($inputs as $input) {
            if(!isset($minuend)) {
                $minuend = $input;
            } else {
                $minuend -= $input;
            }
        }
        return $minuend;
    }

}
