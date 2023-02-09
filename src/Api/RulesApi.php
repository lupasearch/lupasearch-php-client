<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

class RulesApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getSearchQueryRules(string $indexId, string $searchQueryId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/queries/$searchQueryId/rules",
            true
        );
    }

    public function createSearchQueryRule(string $indexId, string $searchQueryId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/$indexId/queries/$searchQueryId/rules",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function getSearchQueryRule(string $indexId, string $searchQueryId, string $ruleId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/queries/$searchQueryId/rules/$ruleId",
            true
        );
    }

    public function updateSearchQueryRule(
        string $indexId,
        string $searchQueryId,
        string $ruleId,
        array $httpBody
    ): array {
        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            "/indices/$indexId/queries/$searchQueryId/rules/$ruleId",
            true,
            JsonUtils::jsonEncode($httpBody)
        );
    }

    public function deleteSearchQueryRule(string $indexId, string $searchQueryId, string $ruleId): void
    {
        $this->client->send(
            LupaClientInterface::METHOD_DELETE,
            "/indices/$indexId/queries/$searchQueryId/rules/$ruleId",
            true
        );
    }
}
