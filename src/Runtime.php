<?php
declare(strict_types=1);

namespace Pilulka\DSL;

class Runtime
{
    /**
     * @var array
     */
    private $operations;

    /**
     * @var OperationLoaderInterface
     */
    private $operationLoader;

    public function __construct(
        array $operations = [],
        OperationLoaderInterface $operationLoader = null
    )
    {
        $this->operations = $operations;
        $this->operationLoader = $operationLoader;
    }

    public function execute(string $input, array $context = [])
    {
        $parser = new Parser(array_keys($this->operations));
        $ast = $parser->parse($input);
        $actionTree = new ActionTree($this->operations, $this->operationLoader);
        return $actionTree->execute($ast, $context);
    }

}