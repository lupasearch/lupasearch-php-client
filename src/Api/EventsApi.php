<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;

class EventsApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function sendEvent(array $httpBody): array
    {
        return $this->client->send(
            LupaClient::METHOD_POST,
            LupaClient::API_BASE_PATH . '/events',
            false,
            json_encode($httpBody)
        );
    }
}
