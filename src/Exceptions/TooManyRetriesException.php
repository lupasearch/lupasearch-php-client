<?php

declare(strict_types=1);

namespace LupaSearch\Exceptions;

use Throwable;

class TooManyRetriesException extends \Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        $message = $message . ($previous instanceof Throwable ? ". Error: {$previous->getMessage()}" : '');

        parent::__construct($message, $code, $previous);
    }
}
