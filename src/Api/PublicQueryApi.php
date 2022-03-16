<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

class PublicQueryApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function search(string $queryKey, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/query/$queryKey",
            false,
            json_encode($httpBody)
        );
    }
}
