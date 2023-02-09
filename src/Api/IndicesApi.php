<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

use function http_build_query;

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
            "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function getIndices(string $organizationSlug, string $projectSlug): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/organizations/$organizationSlug/projects/$projectSlug/indices",
            true
        );
    }

    public function getIndex(string $indexId): array
    {
        return $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId", true);
    }

    public function updateIndex(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            "/indices/$indexId",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function deleteIndex(string $indexId): void
    {
        $this->client->send(LupaClientInterface::METHOD_DELETE, "/indices/$indexId", true);
    }

    public function setIndexStatus(string $indexId, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            "/indices/$indexId/status" . ($query ? "?{$query}" : ''),
            true
        );
    }

    public function reindex(string $indexId): array
    {
        return $this->client->send(LupaClientInterface::METHOD_POST, "/indices/$indexId/reindex", true);
    }

    public function deleteTemporaryIndex(string $indexId): void
    {
        $this->client->send(LupaClientInterface::METHOD_DELETE, "/indices/$indexId/temporary", true);
    }
}
