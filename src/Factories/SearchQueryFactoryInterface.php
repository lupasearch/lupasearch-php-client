<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\SearchQueryInterface;

interface SearchQueryFactoryInterface
{
    /**
     * @param mixed[] $data
     * @return SearchQueryInterface
     */
    public function create(array $data): SearchQueryInterface;
}