<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\Exceptions\BadResponseException;
use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;
use Throwable;

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
        try {
            $response = $this->client->send(
                LupaClientInterface::METHOD_GET,
                "/indices/$indexId/documents/count",
                true
            );
        } catch (Throwable $exception) {
            throw new BadResponseException($exception->getMessage(), $exception->getCode(), $exception);
        }

        if (!isset($response['count'])) {
            throw new BadResponseException('Response: ' . var_export($response, true));
        }

        return (int)$response['count'];
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
