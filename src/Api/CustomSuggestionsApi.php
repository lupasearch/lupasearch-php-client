<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

class CustomSuggestionsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCustomSuggestions(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/customSuggestions",
            true
        );
    }

    public function createCustomSuggestions(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/customSuggestions",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function deleteCustomSuggestions(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/customSuggestions/batchDelete",
            true,
            Utils::jsonEncode($httpBody)
        );
    }
}
