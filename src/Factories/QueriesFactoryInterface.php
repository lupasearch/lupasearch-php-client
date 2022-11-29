<?php

namespace LupaSearch\Factories;

use LupaSearch\Api\Data\SearchQueries\QueriesInterface;

interface QueriesFactoryInterface
{
    /**
     * @param mixed[] $data
     */
    public function create(array $data): QueriesInterface;
}