<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

class SynonymsApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function getSynonyms(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH . "/indices/$indexId/synonyms",
            true
        );
    }

    public function createSynonyms(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/synonyms",
            true,
            json_encode($httpBody)
        );
    }

    public function deleteSynonyms(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/synonyms/batchDelete",
            true,
            json_encode($httpBody)
        );
    }
}
