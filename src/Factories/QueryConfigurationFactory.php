<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\OrderedMap;
use LupaSearch\Api\Data\SearchQueries\OrderedMapInterface;
use LupaSearch\Api\Data\SearchQueries\QueryConfigurationInterface;
use LupaSearch\Api\Data\SearchQueries\SearchQueryConfiguration;
use LupaSearch\Api\Data\SearchQueries\SearchQueryConfigurationInterface;
use LupaSearch\Api\Data\SearchQueries\SuggestionQueryConfiguration;
use LupaSearch\Api\Data\SearchQueries\SuggestionQueryConfigurationInterface;

class QueryConfigurationFactory implements QueryConfigurationFactoryInterface
{
    public function create(array $data): QueryConfigurationInterface
    {
        $isSearchConfiguration = isset($data['queryFields']);

        return $isSearchConfiguration ? $this->createSearchQueryConfigurationFromData(
            $data
        ) : $this->createSuggestionQueryConfigurationFromData($data);
    }

    public function createSuggestionQueryConfiguration(): SuggestionQueryConfigurationInterface
    {
        return $this->createSuggestionQueryConfigurationFromData([]);
    }

    public function createSearchQueryConfiguration(): SearchQueryConfigurationInterface
    {
        return $this->createSearchQueryConfigurationFromData([]);
    }

    private function createSuggestionQueryConfigurationFromData(array $data): SuggestionQueryConfiguration
    {
        $suggestionQueryConfiguration = new SuggestionQueryConfiguration();
        $suggestionQueryConfiguration->setLimit((int)($data['limit'] ?? 0));

        $facets = [];
        foreach ($data['facets']['facets'] ?? [] as $value) {
            $facets[] = $this->createOrderMap($value);
        }
        $suggestionQueryConfiguration->setFacets($facets);

        $suggestionQueryConfiguration->setDocumentQueryKey($data['facets']['documentQueryKey'] ?? '');

        return $suggestionQueryConfiguration;
    }

    private function createSearchQueryConfigurationFromData(array $data): SearchQueryConfiguration
    {
        $searchQueryConfiguration = new SearchQueryConfiguration();
        $searchQueryConfiguration->setQueryFields($this->createOrderMap($data['queryFields'] ?? []));
        $searchQueryConfiguration->setMatch($data['match'] ?? '');
        $searchQueryConfiguration->setBoostPhrase($this->createOrderMap($data['boostPhrase'] ?? []));
        $searchQueryConfiguration->setBoost($this->createOrderMap($data['boost'] ?? []));
        $searchQueryConfiguration->setDidYouMean($this->createOrderMap($data['didYouMean'] ?? []));
        $searchQueryConfiguration->setSimilarQueries($this->createOrderMap($data['similarQueries'] ?? []));
        $searchQueryConfiguration->setSelectFields($data['selectFields'] ?? []);
        $searchQueryConfiguration->setSelectableFields($data['selectableFields'] ?? []);
        $searchQueryConfiguration->setFilters($this->createOrderMap($data['filters'] ?? []));
        $searchQueryConfiguration->setFilterableFields($data['filterableFields'] ?? []);
        $searchQueryConfiguration->setOffset((int)($data['offset'] ?? 0));
        $searchQueryConfiguration->setLimit((int)($data['limit'] ?? 0));

        $sort = [];
        foreach ($data['sort'] ?? [] as $value) {
            $sort[] = $this->createOrderMap($value);
        }
        $searchQueryConfiguration->setSort($sort);

        $facets = [];
        foreach ($data['facets'] ?? [] as $value) {
            $facets[] = $this->createOrderMap($value);
        }
        $searchQueryConfiguration->setFacets($facets);

        $searchQueryConfiguration->setStatisticalBoost($this->createOrderMap($data['statisticalBoost'] ?? []));
        $searchQueryConfiguration->setPersonalization($this->createOrderMap($data['personalization'] ?? []));
        $searchQueryConfiguration->setCollapse($this->createOrderMap($data['collapse'] ?? []));
        $searchQueryConfiguration->setExactTotalCount($data['exactTotalCount'] ?? false);
        $searchQueryConfiguration->setMustIncludeIds($data['mustIncludeIds'] ?? []);
        $searchQueryConfiguration->setMustExcludeIds($data['mustExcludeIds'] ?? []);

        return $searchQueryConfiguration;
    }

    private function createOrderMap(array $data): OrderedMapInterface
    {
        $map = new OrderedMap();

        foreach ($data as $name => $value) {
            $value = !is_array($value) ? $value : $this->createOrderMap($value);

            $map->add($name, $value);
        }

        return $map;
    }
}