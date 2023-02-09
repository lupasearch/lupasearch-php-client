<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

use function http_build_query;

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

    public function getSearch(string $queryKey, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(LupaClientInterface::METHOD_GET, "/query/$queryKey" . ($query ? "?$query" : ''));
    }
}
