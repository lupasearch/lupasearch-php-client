<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

use function json_encode;

class DocumentsApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function importDocuments(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/documents",
            true,
            json_encode($httpBody)
        );
    }

    public function replaceAllDocuments(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . "/indices/$indexId/replaceAllDocuments",
            true,
            json_encode($httpBody)
        );
    }
}
