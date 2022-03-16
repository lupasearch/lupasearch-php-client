<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;
use GuzzleHttp\Psr7\Query;

class IndicesApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function createIndex(
        string $organizationSlug,
        string $projectSlug,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true,
            json_encode($httpBody)
        );
    }

    public function getIndices(
        string $organizationSlug,
        string $projectSlug
    ): array {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH .
                "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true
        );
    }

    public function getIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH . "/indices/$indexId",
            true
        );
    }

    public function updateIndex(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_PUT,
            LupaClient::API_BASE_PATH . "/indices/$indexId",
            true,
            json_encode($httpBody)
        );
    }

    public function deleteIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_DELETE,
            LupaClient::API_BASE_PATH . "/indices/$indexId",
            true
        );
    }

    public function setIndexStatus(
        string $indexId,
        array $queryParams = []
    ): array {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClient::METHOD_PUT,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/status" .
                ($query ? "?{$query}" : ''),
            true
        );
    }

    public function reindex(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/reindex",
            true
        );
    }

    public function deleteTemporaryIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClient::METHOD_DELETE,
            LupaClient::API_BASE_PATH . "/indices/$indexId/temporary",
            true
        );
    }
}
