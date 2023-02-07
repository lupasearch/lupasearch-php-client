<?php

declare(strict_types=1);

namespace LupaSearch\Api;

use LupaSearch\Api\Data\SearchQueries\QueriesInterface;
use LupaSearch\Api\Data\SearchQueries\SearchQueryInterface;
use LupaSearch\Exceptions\ApiException;
use LupaSearch\Exceptions\NotFoundException;
use LupaSearch\Factories\QueriesFactory;
use LupaSearch\Factories\QueriesFactoryInterface;
use LupaSearch\Factories\QueryConfigurationFactory;
use LupaSearch\Factories\SearchQueryFactory;
use LupaSearch\Factories\SearchQueryFactoryInterface;
use LupaSearch\LupaClientInterface;
use LupaSearch\Utils\JsonUtils;
use Throwable;

class SearchQueriesApi
{
    /**
     * @var LupaClientInterface
     */
    private $client;
    /**
     * @var SearchQueryFactoryInterface
     */
    private $searchQueryFactory;
    /**
     * @var QueriesFactoryInterface|null
     */
    private $queriesFactory;

    public function __construct(LupaClientInterface $client, SearchQueryFactoryInterface $searchQueryFactory = null, QueriesFactoryInterface $queriesFactory = null)
    {
        $this->client = $client;
        $this->searchQueryFactory = $searchQueryFactory ?: new SearchQueryFactory();
        $this->queriesFactory = $queriesFactory ?: new QueriesFactory();
    }

    /**
     * @throws ApiException
     */
    public function getSearchQueries(string $indexId): ?QueriesInterface
    {
        try {
            $response = $this->client->send(LupaClientInterface::METHOD_GET, "/indices/$indexId/queries", true);
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return null;
        }

        return $this->queriesFactory->create($response);
    }

    /**
     * @throws ApiException
     */
    public function createSearchQuery(string $indexId, SearchQueryInterface $searchQuery): ?SearchQueryInterface
    {
        try {
            $response = $this->client->send(
                LupaClientInterface::METHOD_POST,
                "/indices/$indexId/queries",
                true,
                JsonUtils::jsonEncode($searchQuery)
            );
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return null;
        }

        return $this->searchQueryFactory->create($response);
    }

    /**
     * @throws ApiException
     */
    public function getSearchQuery(string $indexId, string $searchQueryId): ?SearchQueryInterface
    {
        try {
            $response = $this->client->send(
                LupaClientInterface::METHOD_GET,
                "/indices/$indexId/queries/$searchQueryId",
                true
            );
        } catch (NotFoundException $exception) {
            return null;
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return null;
        }

        return $this->searchQueryFactory->create($response);
    }

    /**
     * @throws ApiException
     */
    public function updateSearchQuery(string $indexId, SearchQueryInterface $searchQuery): ?SearchQueryInterface
    {
        try {
            $response = $this->client->send(
                LupaClientInterface::METHOD_PUT,
                "/indices/$indexId/queries/" . $searchQuery->getId(),
                true,
                JsonUtils::jsonEncode($searchQuery)
            );
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return null;
        }

        return $this->searchQueryFactory->create($response);
    }

    /**
     * @throws ApiException
     */
    public function deleteSearchQuery(string $indexId, string $searchQueryId): void
    {
        try {
            $this->client->send(LupaClientInterface::METHOD_DELETE, "/indices/$indexId/queries/$searchQueryId", true);
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return;
        }
    }

    /**
     * @throws ApiException
     */
    public function testSearchQuery(string $indexId, SearchQueryInterface $searchQuery, array $publicQuery): array
    {
        try {
            return $this->client->send(
                LupaClientInterface::METHOD_POST,
                "/indices/$indexId/queries/test",
                true,
                JsonUtils::jsonEncode(['searchQuery' => $searchQuery, 'publicQuery' => $publicQuery])
            );
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return [];
        }
    }

    /**
     * @throws ApiException
     */
    public function testEventStorage(string $indexId, array $httpBody): array
    {
        try {
            return $this->client->send(
                LupaClientInterface::METHOD_POST,
                "/indices/$indexId/events/test",
                true,
                JsonUtils::jsonEncode($httpBody)
            );
        } catch (ApiException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            return [];
        }
    }
}
