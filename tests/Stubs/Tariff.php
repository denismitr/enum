<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

class Tariff extends Enum
{
    protected static function states(): array
    {
        return [
            'FREE' => 0,
            'BASIC' => 299.87,
            'GOLD' => 789.66,
        ];
    }
}