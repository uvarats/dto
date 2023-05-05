<?php

declare(strict_types=1);

namespace Tests\Dto;

use Uvarats\Dto\Data;

final class SimpleTestDto extends Data
{
    public function __construct(
        public readonly int $someInt,
        public readonly string $someString,
    ) {
    }
}