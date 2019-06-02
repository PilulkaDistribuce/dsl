<?php
declare(strict_types=1);

namespace Pilulka\DSL\Operation;

interface OperationInterface
{

    public function execute(array $inputs);

}