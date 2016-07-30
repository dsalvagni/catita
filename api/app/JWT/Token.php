<?php

namespace App\JWT;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha512;
use Lcobucci\JWT\ValidationData;

class Token
{
    private static $token;

    public static function getSigner()
    {
        return new Sha512();
    }

    public static function clear() {
        self::$token = null;
    }

    public static function create($uid, $expiration = 3600)
    {
        $signer = self::getSigner();

        self::$token = (new Builder())->setIssuer(env('TOKEN_ISSUER') || 'http://localhost:8000')
            ->setAudience(env('TOKEN_AUDIENCE') || 'http://localhost:8000')
            ->setId(env('APP_KEY'), true)
            ->setIssuedAt(time())
            ->setExpiration(time() + $expiration)
            ->set('uid', $uid)
            ->sign($signer, env('APP_KEY'))
            ->getToken();

        return self::$token;
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function setTokenFromString($token)
    {
        self::$token = (new Parser())->parse((string)$token);
    }

    public static function isValid()
    {
        $signer = self::getSigner();
        $token = self::getToken();

        $data = new ValidationData();
        $data->setIssuer(env('TOKEN_ISSUER') || 'http://localhost:8000');
        $data->setAudience(env('TOKEN_AUDIENCE') || 'http://localhost:8000');
        $data->setId(env('APP_KEY'));

        return self::getToken()->verify($signer, env('APP_KEY')) && $token->validate($data);
    }

}