<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Utils;
use LupaSearch\LupaClientInterface;

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
        $this->client->send(LupaClientInterface::METHOD_POST, '/events', false, Utils::jsonEncode($httpBody));
    }
}
