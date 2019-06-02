<?php
declare(strict_types=1);

namespace Pilulka\DSL;

use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{

    public function test__construct()
    {
        $this->assertInstanceOf(
            Token::class,
            new Token([])
        );
    }

    public function testGetType()
    {
        $token = new Token([
            'type' => Token::OPERATION,
        ]);
        $this->assertEquals(
          Token::OPERATION,
          $token->getType()
        );
    }

    public function testGetId()
    {
        $varA = 'valiableA';
        $token = new Token([
            'id' => $varA,
            'type' => Token::OPERATION,
        ]);
        $this->assertEquals(
            $varA,
            $token->getId()
        );
    }

    public function testGetIdOnNull()
    {
        $token = new Token([
            'type' => Token::OPERATION,
        ]);
        $this->assertEquals(
            null,
            $token->getId()
        );
    }


}
