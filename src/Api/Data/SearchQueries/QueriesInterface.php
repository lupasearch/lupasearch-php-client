<?php

namespace LupaSearch\Api\Data\SearchQueries;

interface QueriesInterface
{
    public function getCurrentPage(): int;

    public function setCurrentPage(int $currentPage): self;

    public function getLastPage(): int;

    public function setLastPage(int $lastPage): self;

    public function getTotal(): int;

    public function setTotal(int $total): self;

    public function getPerPage(): int;

    public function setPerPage(int $perPage): self;

    /**
     * @return SearchQueryInterface[]
     */
    public function getData(): array;

    /**
     * @param SearchQueryInterface[] $data
     */
    public function setData(array $data): self;
}