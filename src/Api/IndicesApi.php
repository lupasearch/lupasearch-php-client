<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use GuzzleHttp\Psr7\Query;
use LupaSearch\LupaClientInterface;

class IndicesApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function createIndex(string $organizationSlug, string $projectSlug, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function getIndices(string $organizationSlug, string $projectSlug): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            LupaClientInterface::API_BASE_PATH . "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true
        );
    }

    public function getIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId",
            true
        );
    }

    public function updateIndex(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function deleteIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_DELETE,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId",
            true
        );
    }

    public function setIndexStatus(string $indexId, array $queryParams = []): array
    {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/status" . ($query ? "?{$query}" : ''),
            true
        );
    }

    public function reindex(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/reindex",
            true
        );
    }

    public function deleteTemporaryIndex(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_DELETE,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/temporary",
            true
        );
    }
}
