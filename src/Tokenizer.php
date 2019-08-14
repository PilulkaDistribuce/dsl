<?php
declare(strict_types=1);

namespace Pilulka\DSL;

class Tokenizer
{

    const OPERATIONS = [
        '\+|\-|\*|\/', // arithmetic operations
        'max',
        'min',
    ];

    /**
     * @var array
     */
    private $operations;

    public function __construct(array $operations = [])
    {
        $this->operations = array_merge(self::OPERATIONS, $operations);
    }

    public function tokenize($input): array
    {
        $tokens = [];
        $success = preg_match_all($this->getPattern(), $input, $matches);
        if ($success) {
            foreach ($matches[0] as $key => $match) {
                $token = [];
                $typeName = Token::TEXT;
                foreach ($this->getTypes() as $type) {
                    if ($matches[$type][$key] !== '') {
                        $typeName = $type;
                        break;
                    }
                }
                $token['type'] = $typeName;
                if (in_array($typeName, $this->getTypeWithId())) {
                    $token['id'] = $matches[$typeName][$key];
                }
                $tokens[] = $token;
            }
        }
        return $tokens;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return [
            Token::OPEN_BRACKET,
            Token::CLOSE_BRACKET,
            Token::VARIABLE,
            Token::OPERATION,
            Token::NUMBER,
            Token::TEXT,
        ];
    }

    /**
     * @return array
     */
    public function getTypeWithId(): array
    {
        return [
            Token::VARIABLE,
            Token::OPERATION,
            Token::NUMBER,
            Token::TEXT,
        ];
    }

    /**
     * @return array
     */
    public function getRegExps(): array
    {
        return [
            '(?<' . Token::OPEN_BRACKET . '>[\(]{1})',
            '(?<' . Token::CLOSE_BRACKET . '>[\)]{1})',
            '{(?<' . Token::VARIABLE . '>[á-žÁ-Ž \w\:]+)}',
            '(?<' . Token::OPERATION . '>' . $this->getOperations() . ')',
            '{(?<' . Token::NUMBER . '>[+-]{0,1}[0-9]+\.[0-9]+)}',
            '{"(?<' . Token::TEXT . '>.*?)"}',
        ];
    }

    public function getPattern(): string
    {
        return '~' . implode('|', $this->getRegExps()) . '~';
    }

    /**
     * @return string
     */
    private function getOperations(): string
    {
        return implode('|', $this->operations);
    }

}