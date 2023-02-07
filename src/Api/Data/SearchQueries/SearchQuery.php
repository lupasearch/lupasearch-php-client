<?php

declare(strict_types=1);

namespace LupaSearch\Api\Data\SearchQueries;

class SearchQuery implements SearchQueryInterface
{
    /**
     * @var string
     */
    private $id = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var QueryConfigurationInterface<SearchQueryConfigurationInterface|SuggestionQueryConfigurationInterface>
     */
    private $configuration;

    /**
     * @var bool
     */
    private $debugMode = false;

    /**
     * @var string
     */
    private $queryKey = '';

    /**
     * @var string
     */
    private $createdByUser = '';

    /**
     * @var string
     */
    private $createdAt = '';

    /**
     * @var string
     */
    private $updatedAt = '';

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): SearchQueryInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): SearchQueryInterface
    {
        $this->description = $description;

        return $this;
    }

    public function getConfiguration(): QueryConfigurationInterface
    {
        return $this->configuration;
    }

    public function setConfiguration(QueryConfigurationInterface $configuration): SearchQueryInterface
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function isDebugMode(): bool
    {
        return $this->debugMode;
    }

    public function setDebugMode(bool $debugMode): SearchQueryInterface
    {
        $this->debugMode = $debugMode;

        return $this;
    }

    public function getQueryKey(): string
    {
        return $this->queryKey;
    }

    public function setQueryKey(string $queryKey): SearchQueryInterface
    {
        $this->queryKey = $queryKey;

        return $this;
    }

    public function getCreatedByUser(): string
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(string $createdByUser): SearchQueryInterface
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): SearchQueryInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): SearchQueryInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'configuration' => $this->configuration,
            'debugMode' => $this->debugMode,
        ];
    }
}