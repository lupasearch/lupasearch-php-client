<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

class MappingApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function createMapping(string $indexId, array $httpBody): void
    {
        $this->client->send(
            LupaClientInterface::METHOD_POST,
            "/indices/{$indexId}/mapping",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function updateMapping(string $indexId, array $httpBody): void
    {
        $this->client->send(
            LupaClientInterface::METHOD_PUT,
            "/indices/{$indexId}/mapping",
            true,
            Utils::jsonEncode($httpBody)
        );
    }
}
