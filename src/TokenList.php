<?php
declare(strict_types=1);

namespace Pilulka\DSL;

class TokenList
{
    /**
     * @var array
     */
    private $tokens;

    /**
     * TokenList constructor.
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * @return \Generator | Token[]
     */
    public function iterate()
    {
        foreach ($this->tokens as $token) {
            yield new Token($token);
        }
    }

}