<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

/**
 * Class OrderStatus
 * @package Denismitr\Enum\Tests\Stubs
 *
 * @method static OrderStatus PENDING
 * @method static OrderStatus COMPLETED
 * @method static OrderStatus CANCELED
 * @method static OrderStatus DELIVERING
 *
 * @method bool isPending()
 * @method bool isCompleted()
 * @method bool isCanceled()
 * @method bool isDelivering()
 */
class OrderStatus extends Enum
{
    protected static function getStates(): array
    {
        return [
            'PENDING' => 1,
            'COMPLETED' => 2,
            'CANCELED' => 3,
            'DELIVERING' => 4,
        ];
    }
}