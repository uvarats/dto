<?php

declare(strict_types=1);

namespace Tests\Enum;

enum TestEnum: string
{
    case FOO = 'foo';
    case BAR = 'bar';
    case BAZ = 'baz';
}
