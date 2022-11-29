<?php

namespace LupaSearch\Handler;

use LupaSearch\Exceptions\ApiException;
use Throwable;

interface ErrorHandlerInterface
{
    /**
     * @throws ApiException
     */
    public function handle(Throwable $throwable): void;
}
