<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

class SynonymsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getSynonyms(string $indexId): array
    {
        return $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId/synonyms", true);
    }

    public function createSynonyms(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/synonyms",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function deleteSynonyms(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/synonyms/batchDelete",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }
}
