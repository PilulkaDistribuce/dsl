<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use Pilulka\DSL\Operation\Addition;
use Pilulka\DSL\Operation\Division;
use Pilulka\DSL\Operation\Maximum;
use Pilulka\DSL\Operation\Minimum;
use Pilulka\DSL\Operation\Multiplication;
use Pilulka\DSL\Operation\OperationInterface;
use Pilulka\DSL\Operation\Representation;
use Pilulka\DSL\Operation\Subtraction;
use Webmozart\Assert\Assert;

class ActionTree
{

    private $operations = [
        '+' => Addition::class,
        '-' => Subtraction::class,
        '*' => Multiplication::class,
        '/' => Division::class,
        'max' => Maximum::class,
        'min' => Minimum::class,
    ];
    /**
     * @var OperationLoaderInterface
     */
    private $operationLoader;

    public function __construct(
        array $operations = [],
        OperationLoaderInterface $operationLoader = null
    )
    {
        $this->operations += $operations;
        if(!isset($operationLoader)) {
            $operationLoader = new SimpleOperationLoader();
        }
        $this->operationLoader = $operationLoader;
    }


    public function execute(array $ast, array $context)
    {
        return $this->evaluate($ast, $context);
    }

    private function evaluate(array $root, array $context)
    {
        $operation = $this->dispatchOperation($root['operation']);
        $inputs = [];
        foreach ($root['items'] as $item) {
            if (is_array($item)) {
                $inputs[] = $this->evaluate($item, $context);
            }
            if ($item instanceof Token) {
                if ($item->getType() == Token::VARIABLE) {
                    $inputs[] = $context[$item->getId()];
                }
                if ($item->getType() == Token::NUMBER) {
                    $inputs[] = (float)$item->getId();
                }
                if ($item->getType() == Token::TEXT) {
                    $inputs[] = (string)$item->getId();
                }
            }
        }

        return $operation->execute($inputs);
    }

    private function dispatchOperation(Token $token = null): OperationInterface
    {
        if (!isset($token)) {
            return new Representation();
        }
        if(!array_key_exists($token->getId(), $this->operations)) {
            throw new \InvalidArgumentException(
                "Operation `{$token->getId()}` is not implemented or registered."
            );
        }
        $className = $this->operations[$token->getId()];
        return new $className;
    }

}
