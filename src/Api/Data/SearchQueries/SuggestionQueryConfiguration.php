<?php

declare(strict_types=1);

namespace LupaSearch\Api\Data\SearchQueries;

class SuggestionQueryConfiguration implements SuggestionQueryConfigurationInterface
{
    /**
     * @var int
     */
    private $limit = 0;

    /**
     * @var string
     */
    private $documentQueryKey = '';

    /**
     * @var OrderedMapInterface[]
     */
    private $facets = [];

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): QueryConfigurationInterface
    {
        $this->limit = $limit;

        return $this;
    }

    public function getDocumentQueryKey(): string
    {
        return $this->documentQueryKey;
    }

    public function setDocumentQueryKey(string $documentQueryKey): SuggestionQueryConfigurationInterface
    {
        $this->documentQueryKey = $documentQueryKey;

        return $this;
    }

    public function getFacets(): array
    {
        return $this->facets;
    }

    public function setFacets(array $facets): SuggestionQueryConfigurationInterface
    {
        $this->facets = $facets;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'limit' => $this->limit
        ];

        if ($this->facets && $this->documentQueryKey) {
            $data['facets'] = [
                'documentQueryKey' => $this->documentQueryKey,
                'facets' => $this->facets
            ];
        }

        return $data;
    }
}
