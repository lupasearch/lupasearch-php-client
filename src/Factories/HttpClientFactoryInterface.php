<?php

namespace LupaSearch\Factories;

use GuzzleHttp\ClientInterface;

interface HttpClientFactoryInterface
{
    public function create(array $config = []): ClientInterface;
}
