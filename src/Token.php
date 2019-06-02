<?php
declare(strict_types=1);

namespace Pilulka\DSL;

class Token
{

    const OPEN_BRACKET = 'open_bracket';
    const CLOSE_BRACKET = 'close_bracket';
    const OPERATION = 'operation';
    const VARIABLE = 'variable';
    const NUMBER = 'number';
    const TEXT = 'text';

    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getType(): string
    {
        return $this->config['type'];
    }

    public function getId(): ?string
    {
        return $this->config['id'] ?? null;
    }

}
