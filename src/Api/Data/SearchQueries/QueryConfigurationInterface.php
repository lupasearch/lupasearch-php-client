<?php

namespace LupaSearch\Api\Data\SearchQueries;

use JsonSerializable;

interface QueryConfigurationInterface extends JsonSerializable
{
    public function getLimit(): int;

    public function setLimit(int $limit): self;
}
