<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

class Multiplication implements OperationInterface
{

    public function execute(array $inputs)
    {
        $res = null;
        foreach ($inputs as $item) {
            if(is_numeric($item)) {
                if (!isset($res)) {
                    $res = $item;
                } else {
                    $res *= $item;
                }
            }
        }
        return $res;
    }

}
