<?php

declare(strict_types=1);

namespace LupaSearch\Api\Data\SearchQueries;

class OrderedMap implements OrderedMapInterface
{
    /**
     * @var array<string, int|float|bool|string|OrderedMapInterface>
     */
    private $map = [];

    public function add(string $name, $value): OrderedMapInterface
    {
        $this->map[$name] = $value;

        return $this;
    }

    public function remove(string $name): OrderedMapInterface
    {
        unset($this->map[$name]);

        return $this;
    }

    public function get(string $name)
    {
        return $this->map[$name] ?? null;
    }

    public function isEmpty(): bool
    {
        return !$this->map;
    }

    public function jsonSerialize(): ?array
    {
        return $this->map ?: null;
    }
}
