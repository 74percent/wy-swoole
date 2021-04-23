<?php

namespace App\Library;

use App\Library\InterfaceAbstract\SingleInterface;
use Firebase\JWT\JWT as JWTJWT;

class JWT implements SingleInterface
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $iss = '74percent.github.com';
    private $aud = '74percent.github.com';
    private $key;

    public function __construct()
    {
        $this->key = getenv('JWT_KEY');
    }

    public function encode(int $uid)
    {
        $time = time();
        $payload = array(
            "iss" => $this->iss,
            "aud" => $this->aud,
            "iat" => $time,
            "nbf" => $time,
            "exp" => $time + 3600 * 24 * 365,
            "uid" => $uid,
        );

        return JWTJWT::encode($payload, $this->key);
    }

    public function decode(string $token)
    {
        return JWTJWT::decode($token, $this->key, array('HS256'));
    }
}
