<?php

namespace LupaSearch\Api\Data\SearchQueries;

use JsonSerializable;

interface OrderedMapInterface extends JsonSerializable
{
    /**
     * @param mixed $value
     */
    public function add(string $name, $value): self;

    public function remove(string $name): self;

    /**
     * @return mixed
     */
    public function get(string $name);

    public function isEmpty(): bool;
}
