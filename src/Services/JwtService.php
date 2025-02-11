<?php

namespace Pteroca\PterodactylAddon\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secret;

    public function __construct()
    {
        $this->secret = env('PTEROCA_SSO_SECRET');
    }

    public function decodeToken(?string $token): ?object
    {
        if (empty($token)) {
            return null;
        }

        try {
            return JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (\Exception $exception) {
            return null;
        }
    }
}
