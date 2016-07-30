<?php

use App\JWT\Token;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use Lcobucci\JWT\ValidationData;

class TokenTest extends UnitTestCase
{
    public function test_signer() {
        $this->assertEquals(Token::getSigner(), new Sha512());
    }

    public function test_clear(){
        Token::clear();
        $this->assertEquals(Token::getToken(),null);
    }

    public function test_create() {
        Token::create(1);
        $this->assertEquals(Token::getToken()->getClaim('uid'),1);
    }

    public function test_set_token_from_string() {
        Token::create(1);
        Token::setTokenFromString((string) Token::getToken());

        $this->assertEquals(Token::getToken()->getClaim('uid'),1);
    }

    public function test_token_is_valid() {
        Token::create(1);
        Token::setTokenFromString((string) Token::getToken());
        $this->assertEquals(Token::isValid(),true);
    }

    public function test_token_is_invalid() {
        Token::create(1);
        Token::setTokenFromString("eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6ImRmNTUzZjMxY2UwMWVlOTJjMzk5OGI2NjE5NDM2MzBmIn0.eyJpc3MiOiIxIiwiYXVkIjoiMSIsImp0aSI6ImRmNTUzZjMxY2UwMWVlOTJjMzk5OGI2NjE5NDM2MzBmIiwiaWF0IjoxNDY5ODM0MzY5LCJleHAiOjE0Njk4MzQzNzAsInVpZCI6MTZ9.pNuYmcGtWgmXxcEfPlTe7OIpEM4bBPCSURmOr-ED0f0");
        $this->assertEquals(Token::isValid(),false);
    }

    public function test_token_is_expired() {
        Token::create(1,-2);
        $this->assertEquals(Token::isValid(),false);
    }
}