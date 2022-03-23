<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;

class SuggestionsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function generateSuggestions(string $indexId): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/indices/$indexId/suggestions/generate",
            true
        );
    }
}
