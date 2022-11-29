<?php

namespace LupaSearch\Api\Data\SearchQueries;

interface SuggestionQueryConfigurationInterface extends QueryConfigurationInterface
{
    public function getDocumentQueryKey(): string;

    public function setDocumentQueryKey(string $documentQueryKey): self;

    /**
     * @return OrderedMapInterface[]
     */
    public function getFacets(): array;

    /**
     * @param OrderedMapInterface[] $facets
     */
    public function setFacets(array $facets): self;
}