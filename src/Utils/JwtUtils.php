<?php

namespace LupaSearch\Utils;

class JwtUtils
{
    public static function isJwtTokenValid(?string $jwtToken): bool
    {
        if (!$jwtToken) {
            return false;
        }

        [, $payload] = explode(".", $jwtToken);
        $payload = json_decode(base64_decode($payload), true);

        return isset($payload["exp"]) && time() < $payload["exp"];
    }
}
