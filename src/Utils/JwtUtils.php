<?php

declare(strict_types=1);

namespace LupaSearch\Utils;

use GuzzleHttp\Utils;

class JwtUtils
{
    public static function isJwtTokenValid(?string $jwtToken): bool
    {
        if (false === strpos($jwtToken, '.')) {
            return false;
        }

        [, $payload] = explode('.', $jwtToken);
        $payload = Utils::jsonDecode(base64_decode($payload), true);

        return isset($payload['exp']) && time() < $payload['exp'];
    }
}
