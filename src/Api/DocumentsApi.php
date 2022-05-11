<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

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
            "/indices/$indexId/replaceAllDocuments",
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
