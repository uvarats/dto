<?php

declare(strict_types=1);

namespace Tests\Dto;

use Uvarats\Dto\Data;

final class DefaultValueDto extends Data
{
    public function __construct(
        public string $name,
        public bool $accept = false,
    )
    {
    }
}