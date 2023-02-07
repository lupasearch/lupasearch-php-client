<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\Queries;
use LupaSearch\Api\Data\SearchQueries\QueriesInterface;

class QueriesFactory implements QueriesFactoryInterface
{
    /**
     * @var SearchQueryFactory|SearchQueryFactoryInterface
     */
    private $searchQueryFactory;

    public function __construct(SearchQueryFactoryInterface $searchQueryFactory = null)
    {
        $this->searchQueryFactory = $searchQueryFactory ?: new SearchQueryFactory();
    }

    public function create(array $data): QueriesInterface
    {
        $queries = new Queries();
        $queries->setCurrentPage((int)($data['currentPage'] ?? 0));
        $queries->setLastPage((int)($data['lastPage'] ?? 0));
        $queries->setTotal((int)($data['total'] ?? 0));
        $queries->setPerPage((int)($data['perPage'] ?? 0));

        $searchQueries = [];

        foreach ($data['data'] ?? [] as $searchQueryConfigurationData) {
            $searchQueries[] = $this->searchQueryFactory->create($searchQueryConfigurationData);
        }

        $queries->setData($searchQueries);

        return $queries;
    }
}
