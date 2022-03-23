<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

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
            LupaClientInterface::API_BASE_PATH . "/query/$queryKey",
            false,
            Utils::jsonEncode($httpBody)
        );
    }
}
