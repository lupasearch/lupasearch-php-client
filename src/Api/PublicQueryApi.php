<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

use function http_build_query;

class PublicQueryApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function search(string $queryKey, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/query/$queryKey",
            false,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function getFacets(string $queryKey, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/query/$queryKey/facets",
            false,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    /**
     * @param string $queryKey Unique search query key
     * @param array{
     *     searchText?: string,
     *     selectFields?: string[],
     *     filters?: array<string, mixed>,
     *     exclusionFilters?: array<string, mixed>,
     *     offset?: int,
     *     limit?: int,
     *     sort?: array<array<string, string>|array<string, string>>,
     *     sessionId?: string,
     *     userId?: string,
     *     trackTerm?: bool,
     *     analyticsMetadata?: array<string, mixed>,
     *     modifiers?: array<string, mixed>,
     * } $httpBody
     * @return array{relatedQueries: list<array{
     *     topItems: list<array<string, mixed>>,
     *     total: int,
     *     query: string,
     *     facetKey?: string,
     *     filterValue?: string,
     *     type: string,
     *     action: string,
     * }>}
     */
    public function getRelatedQueries(string $queryKey, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/query/$queryKey/related",
            false,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function getSearch(string $queryKey, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(LupaClientInterface::METHOD_GET, "/query/$queryKey" . ($query ? "?$query" : ''));
    }
}
