<?php

declare(strict_types=1);

namespace Denismitr\Enum\Tests;


use Denismitr\Enum\Tests\Stubs\OrderStatus;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_instantiated_via_a_magic_static_method()
    {
        $pending = OrderStatus::PENDING();

        $this->assertInstanceOf(OrderStatus::class, $pending);
        $this->assertEquals(1, $pending->value());
        $this->assertEquals('PENDING', $pending->key());
        $this->assertTrue($pending->isPending());

        $completed = OrderStatus::COMPLETED();

        $this->assertInstanceOf(OrderStatus::class, $completed);
        $this->assertEquals(OrderStatus::values()[1], $completed->value());
        $this->assertEquals(OrderStatus::keys()[1], $completed->key());
        $this->assertTrue($completed->isCompleted());
        $this->assertFalse($completed->isPending());
    }
}