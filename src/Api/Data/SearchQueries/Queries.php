<?php

declare(strict_types=1);

namespace LupaSearch\Api\Data\SearchQueries;

class Queries implements QueriesInterface
{
    /**
     * @var int
     */
    private $currentPage = 1;

    /**
     * @var int
     */
    private $lastPage = 1;

    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var int
     */
    private $perPage = 10;

    /**
     * @var SearchQueryInterface[]
     */
    private $data = [];

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): QueriesInterface
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function setLastPage(int $lastPage): QueriesInterface
    {
        $this->lastPage = $lastPage;
        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): QueriesInterface
    {
        $this->total = $total;
        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage): QueriesInterface
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): QueriesInterface
    {
        $this->data = $data;
        return $this;
    }
}