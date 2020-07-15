<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

/**
 * @method static OrderStatus PENDING
 * @method static OrderStatus COMPLETED
 * @method static OrderStatus CANCELED
 * @method static OrderStatus BEING_DELIVERED
 *
 * @method bool isPending()
 * @method bool isCompleted()
 * @method bool isCanceled()
 * @method bool isBeingDelivered()
 */
class OrderStatus extends Enum
{
    public static function enumerate(): array
    {
        return [
            'PENDING' => 1,
            'COMPLETED' => 2,
            'CANCELED' => 3,
            'BEING_DELIVERED' => 4,
        ];
    }
}