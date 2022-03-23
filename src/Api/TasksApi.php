<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use GuzzleHttp\Psr7\Query;
use LupaSearch\LupaClientInterface;

class TasksApi
{
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getTasks(string $indexId, array $queryParams = []): array
    {
        $query = Query::build($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/tasks" . ($query ? "?{$query}" : ''),
            true
        );
    }
}
