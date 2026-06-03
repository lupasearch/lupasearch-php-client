<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\LupaClientInterface;

use function http_build_query;

class AnalyticsApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;

    public function __construct(LupaClientInterface $client)
    {
        $this->client = $client;
    }

    public function getSearchStatistics(string $groupType, array $queryParams = []): array
    {
        $query = http_build_query($queryParams);

        return $this->client->send(
            LupaClientInterface::METHOD_GET,
            "/analytics/searches/$groupType" . ($query ? "?$query" : ''),
            true
        );
    }
}
