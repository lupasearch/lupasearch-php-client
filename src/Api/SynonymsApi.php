<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

class SynonymsApi
{
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
            Utils::jsonEncode($httpBody)
        );
    }

    public function deleteSynonyms(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/synonyms/batchDelete",
            true,
            Utils::jsonEncode($httpBody)
        );
    }
}
