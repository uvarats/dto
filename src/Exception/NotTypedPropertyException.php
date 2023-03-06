<?php

declare(strict_types=1);

namespace Uvarats\Dto\Exception;

use Exception;
use Throwable;

class NotTypedPropertyException extends Exception
{
    public function __construct(
        private readonly string $propertyName,
        string                  $message = "Property must be strictly typed.",
        int                     $code = 0,
        ?Throwable              $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}