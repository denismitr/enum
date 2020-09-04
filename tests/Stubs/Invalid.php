<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

class Invalid extends Enum
{
    protected static function states(): array
    {
        return [
            10 => 'foo',
            'FOOBAR' => 'bar',
            99 => 'baz',
        ];
    }
}