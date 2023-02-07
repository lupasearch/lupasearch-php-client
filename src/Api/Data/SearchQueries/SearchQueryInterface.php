<?php

namespace LupaSearch\Api\Data\SearchQueries;

use JsonSerializable;

interface SearchQueryInterface extends JsonSerializable
{
    public function getId(): string;

    public function setId(string $id): self;

    public function getDescription(): string;

    public function setDescription(string $description): self;

    /**
     * @return QueryConfigurationInterface<SearchQueryConfigurationInterface|SuggestionQueryConfigurationInterface>
     */
    public function getConfiguration(): QueryConfigurationInterface;

    /**
     * @param QueryConfigurationInterface<SearchQueryConfigurationInterface|SuggestionQueryConfigurationInterface> $configuration
     * @return $this
     */
    public function setConfiguration(QueryConfigurationInterface $configuration): self;

    public function isDebugMode(): bool;

    public function setDebugMode(bool $debugMode): self;

    public function getQueryKey(): string;

    public function setQueryKey(string $queryKey): self;

    public function getCreatedByUser(): string;

    public function setCreatedByUser(string $createdByUser): self;

    public function getCreatedAt(): string;

    public function setCreatedAt(string $createdAt): self;

    public function getUpdatedAt(): string;

    public function setUpdatedAt(string $updatedAt): self;
}
