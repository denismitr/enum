<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests;


use Denismitr\Enum\Enum;
use Denismitr\Enum\Tests\Stubs\OrderStatus;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_initialized()
    {
        $pending = OrderStatus::PENDING();

        $this->assertInstanceOf(Enum::class, $pending);
        $this->assertEquals(OrderStatus::values()[0], $pending->value());
        $this->assertEquals(OrderStatus::keys()[0], $pending->key());
    }
}