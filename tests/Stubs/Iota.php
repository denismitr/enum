<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests\Stubs;


use Denismitr\Enum\Enum;

/**
 * @method static IOTA PENDING
 * @method static IOTA READY
 * @method static IOTA FAILED
 *
 * @method bool isPending()
 * @method bool isReady()
 * @method bool isFailed()
 */
class Iota extends Enum
{
    protected static function states(): array
    {
        return ['PENDING', 'READY', 'FAILED'];
    }
}