<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

use function json_encode;

class MappingApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function createMapping(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/{$indexId}/mapping",
            true,
            json_encode($httpBody)
        );
    }

    public function updateMapping(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_PUT,
            LupaClient::API_BASE_PATH . "/indices/{$indexId}/mapping",
            true,
            json_encode($httpBody)
        );
    }
}
