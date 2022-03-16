<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

class SearchQueriesApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function getSearchQueries(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH . "/indices/$indexId/queries",
            true
        );
    }

    public function createSearchQuery(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/queries",
            true,
            json_encode($httpBody)
        );
    }

    public function getSearchQuery(
        string $indexId,
        string $searchQueryId
    ): array {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/queries/$searchQueryId",
            true
        );
    }

    public function updateSearchQuery(
        string $indexId,
        string $searchQueryId,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_PUT,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/queries/$searchQueryId",
            true,
            json_encode($httpBody)
        );
    }

    public function deleteSearchQuery(
        string $indexId,
        string $searchQueryId
    ): array {
        return $this->client->send(
            LupaClient::METHOD_DELETE,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/queries/$searchQueryId",
            true
        );
    }
}
