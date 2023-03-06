<?php

declare(strict_types=1);

namespace Tests\Dto;

use Uvarats\Dto\Data;

final class LoginDto extends Data
{
    public function __construct(
        public string $login,
        public string $password,
        public bool $agreement = false,
    )
    {
    }
}