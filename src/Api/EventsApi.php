<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;

class EventsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendEvent(array $httpBody): void
    {
        $this->client->send(LupaClientInterface::METHOD_POST, '/events', false, JsonUtils::jsonEncode($httpBody));
    }
}
