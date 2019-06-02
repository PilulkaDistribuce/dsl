<?php
declare(strict_types=1);

namespace Pilulka\DSL;

class Parser
{

    /**
     * @var Tokenizer
     */
    private $tokenizer;

    public function __construct(array $operations = [])
    {
        $this->tokenizer = new Tokenizer($operations);
    }

    public function parse(string $input)
    {
        return $this->createAST(
            (new TokenList($this->tokenizer->tokenize($input)))
                ->iterate()
        );
    }


    private function createAST(\Generator $tokens): array
    {
        $res = [
            'operation' => null,
            'items' => []
        ];
        while ($tokens->valid()) {
            /** @var Token $token */
            $token = $tokens->current();
            $tokens->next();

            if ($token->getType() == Token::OPERATION) {
                if ($res['operation'] !== null) {
                    $res = [
                        'operation' => $token,
                        'items' => [$res],
                    ];
                } else {
                    $res['operation'] = $token;
                }
            }

            if ($token->getType() == Token::OPEN_BRACKET) {
                if ($res['operation'] !== null) {
                    $res['items'][] = $this->createAST($tokens);
                }
            }

            if ($token->getId() !== null && $token->getType() !== Token::OPERATION) {
                $res['items'][] = $token;
            }
        }
        return $res;
    }

}