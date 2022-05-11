<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

class PublicQueryApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function search(string $queryKey, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/query/$queryKey",
            false,
            JsonUtils::jsonEncode($httpBody)
        );
    }
}
