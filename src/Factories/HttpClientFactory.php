<?php

declare(strict_types=1);

namespace LupaSearch\Factories;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class HttpClientFactory implements HttpClientFactoryInterface
{
    public function create(array $config = []): ClientInterface
    {
        return new Client($config);
    }
}
