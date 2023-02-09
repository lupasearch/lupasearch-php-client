<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;

use function http_build_query;

class TasksApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getTasks(string $indexId, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/indices/$indexId/tasks" . ($query ? "?$query" : ''),
            true
        );
    }
}
