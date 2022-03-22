<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

use function json_encode;

class CustomSuggestionsApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function getCustomSuggestions(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH . "/indices/$indexId/customSuggestions",
            true
        );
    }

    public function createCustomSuggestions(
        string $indexId,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/customSuggestions",
            true,
            json_encode($httpBody)
        );
    }

    public function deleteCustomSuggestions(
        string $indexId,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/customSuggestions/batchDelete",
            true,
            json_encode($httpBody)
        );
    }
}
