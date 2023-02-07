<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\SearchQuery;
use LupaSearch\Api\Data\SearchQueries\SearchQueryInterface;

class SearchQueryFactory implements SearchQueryFactoryInterface
{
    /**
     * @var QueryConfigurationFactoryInterface
     */
    private $queryConfigurationFactory;

    public function __construct(QueryConfigurationFactoryInterface $queryConfigurationFactory = null)
    {
        $this->queryConfigurationFactory = $queryConfigurationFactory ?: new QueryConfigurationFactory();
    }

    public function create(array $data): SearchQueryInterface
    {
        $searchQuery = new SearchQuery();
        $searchQuery->setId($data['id'] ?? '0');
        $searchQuery->setDescription($data['description'] ?? '');
        $searchQuery->setConfiguration($this->queryConfigurationFactory->create($data['configuration'] ?? []));
        $searchQuery->setDebugMode((bool)($data['debugMode'] ?? false));
        $searchQuery->setQueryKey($data['queryKey'] ?? '');
        $searchQuery->setCreatedByUser($data['createdBy'] ?? '');
        $searchQuery->setCreatedAt($data['createdAt'] ?? '');
        $searchQuery->setUpdatedAt($data['updatedAt'] ?? '');

        return $searchQuery;
    }
}
