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

    public function createMapping(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_POST,
            LupaClientInterface::API_BASE_PATH . "/indices/{$indexId}/mapping",
            true,
            Utils::jsonEncode($httpBody)
        );
    }

    public function updateMapping(string $indexId, array $httpBody): array
    {
        return $this->client->send(
            LupaClientInterface::METHOD_PUT,
            LupaClientInterface::API_BASE_PATH . "/indices/{$indexId}/mapping",
            true,
            Utils::jsonEncode($httpBody)
        );
    }
}
