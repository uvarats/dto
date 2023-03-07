<?php

declare(strict_types=1);

namespace Uvarats\Dto\Contract;

interface Arrayable
{
    public function toArray(): array;
}