<?php

namespace LupaSearch\Api;

use LupaSearch\LupaClient;
use GuzzleHttp\Psr7\Query;

class TasksApi
{
    private $client;

    public function __construct(LupaClient $client)
    {
        $this->client = $client;
    }

    public function getTasks(string $indexId, array $queryParams = []): array
    {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClient::METHOD_GET,
            LupaClient::API_BASE_PATH .
                "/indices/$indexId/tasks" .
                ($query ? "?{$query}" : ''),
            true
        );
    }
}
