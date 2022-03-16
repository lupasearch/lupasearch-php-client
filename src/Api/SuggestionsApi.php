<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

class SuggestionsApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function generateSuggestions(string $indexId): array
    {
        return $this->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/suggestions/generate",
            true
        );
    }
}
