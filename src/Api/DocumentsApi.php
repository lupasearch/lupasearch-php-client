<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\Exceptions\BadResponseException;
use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

use function http_build_query;

class DocumentsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws BadResponseException
     */
    public function getCount(string $indexId): int
    {
        $response = $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId/documents/count", true);

        if (!isset($response['count'])) {
            throw new BadResponseException('Response: ' . var_export($response, true));
        }

        return (int) $response['count'];
    }

    public function getAll(string $indexId, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/documents/all" . ($query ? "?$query" : ''),
            true
        );
    }

    public function getDocuments(string $indexId, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/documents" . ($query ? "?$query" : ''),
            true
        );
    }

    public function importDocuments(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/documents",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function updateDocuments(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_PATCH,
            "/indices/$indexId/documents",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function replaceAllDocuments(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/documents/replaceAll",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function batchDelete(string $indexId, array $httpBody): void
    {
        $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/documents/batchDelete",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }
}
