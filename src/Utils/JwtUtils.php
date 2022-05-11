<?php

declare(strict_types=1);

namespace LupaSearch\Utils;

use LupaSearch\Utils\JsonUtils;

class JwtUtils
{
    public static function isJwtTokenValid(?string $jwtToken): bool
    {
        if (!$jwtToken || false === strpos($jwtToken, '.')) {
            return false;
        }

        [, $payload] = explode('.', $jwtToken);
        $payload = JsonUtils::jsonDecode(base64_decode($payload), true);

        return isset($payload['exp']) && time() < $payload['exp'];
    }
}
