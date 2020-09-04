<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

/**
 * @method static OrderStatusCopy PENDING
 * @method static OrderStatusCopy COMPLETED
 * @method static OrderStatusCopy CANCELED
 * @method static OrderStatusCopy BEING_DELIVERED
 *
 * @method bool isPending()
 * @method bool isCompleted()
 * @method bool isCanceled()
 * @method bool isBeingDelivered()
 */
class OrderStatusCopy extends Enum
{
    protected static function states(): array
    {
        return [
            'PENDING' => 1,
            'COMPLETED' => 2,
            'CANCELED' => 3,
            'BEING_DELIVERED' => 4,
        ];
    }
}