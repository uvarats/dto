<?php

declare(strict_types=1);

namespace Uvarats\Dto\Exception;

use Exception;
use Throwable;

class PropertyMissingException extends Exception
{
    public function __construct(
        string $message = "Data array doesn't contain mandatory property",
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}