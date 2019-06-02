<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Division implements OperationInterface
{

    public function execute(array $inputs)
    {
        $res = null;
        foreach ($inputs as $input) {
            if(!isset($res)) {
                $res = $input;
            } else {
                if($input === 0) {
                    throw new \InvalidArgumentException(
                        "Division by zero."
                    );
                }
                $res /= $input;
            }
        }

        return $res;
    }


}