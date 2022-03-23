<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

class SearchQueriesApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getSearchQueries(string $indexId): array
    {
        return $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId/queries", true);
    }

    public function createSearchQuery(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/queries",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function getSearchQuery(string $indexId, string $searchQueryId): array
    {
        return $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId/queries/$searchQueryId", true);
    }

    public function updateSearchQuery(string $indexId, string $searchQueryId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            "/indices/$indexId/queries/$searchQueryId",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function deleteSearchQuery(string $indexId, string $searchQueryId): void
    {
        $this->client->send(LupaClientInterface::METHOD_DELETE, "/indices/$indexId/queries/$searchQueryId", true);
    }
}
