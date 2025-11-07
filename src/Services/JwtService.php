<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class JwtService
{

    private string $key;
    private const string ALGORITHM = 'HS256';

    public function __construct()
    {
        $this->key = $_ENV['JWT_KEY'];
    }

    /**
     * @param array $payload
     * @return string
     */
    public function encode(array $payload, int $exp = 3600): string
    {
        $payload = [
            'iat' => time(),
            'exp' => time() + $exp,
            'data' => $payload
        ];

        return JWT::encode($payload, $this->key, self::ALGORITHM);
    }

    /**
     * @param string $jwt
     * @return array
     */
    public function decode(string $jwt): array
    {
        return (array) JWT::decode($jwt, new Key($this->key, self::ALGORITHM))->data;
    }

}