<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\QueryConfigurationInterface;
use LupaSearch\Api\Data\SearchQueries\SearchQueryConfigurationInterface;
use LupaSearch\Api\Data\SearchQueries\SuggestionQueryConfigurationInterface;

interface QueryConfigurationFactoryInterface
{
    /**
     * @param mixed[] $data
     * @return QueryConfigurationInterface<SearchQueryConfigurationInterface|SuggestionQueryConfigurationInterface>
     */
    public function create(array $data): QueryConfigurationInterface;

    public function createSuggestionQueryConfiguration(): SuggestionQueryConfigurationInterface;

    public function createSearchQueryConfiguration(): SearchQueryConfigurationInterface;
}