<?php

declare(strict_types=1);

namespace Uvarats\Dto\Exception;

use Exception;
use Throwable;

class ConstructorMissingException extends Exception
{
    public function __construct(
        string $message = "Supported only DTO with constructor promoted properties.",
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}