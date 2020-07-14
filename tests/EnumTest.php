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

        $canceled = OrderStatus::CANCELED();

        $this->assertInstanceOf(OrderStatus::class, $canceled);
        $this->assertEquals(3, $canceled->value());
        $this->assertEquals('CANCELED', $canceled->key());
        $this->assertTrue($canceled->isCanceled());
        $this->assertFalse($canceled->isPending());
        $this->assertFalse($canceled->isCompleted());

        $delivering = OrderStatus::DELIVERING();

        $this->assertInstanceOf(OrderStatus::class, $delivering);
        $this->assertEquals(4, $delivering->value());
        $this->assertEquals('DELIVERING', $delivering->key());
        $this->assertTrue($delivering->isDelivering());
        $this->assertFalse($delivering->isPending());
        $this->assertFalse($delivering->isCompleted());
        $this->assertFalse($delivering->isCanceled());
    }

    /**
     * @test
     */
    public function it_provides_static_information()
    {
        $this->assertTrue(OrderStatus::isValidKey('PENDING'));
        $this->assertTrue(OrderStatus::isValidValue(1));

        $this->assertTrue(OrderStatus::isValidKey('COMPLETED'));
        $this->assertTrue(OrderStatus::isValidValue(2));

        $this->assertTrue(OrderStatus::isValidKey('CANCELED'));
        $this->assertTrue(OrderStatus::isValidValue(3));

        $this->assertTrue(OrderStatus::isValidKey('DELIVERING'));
        $this->assertTrue(OrderStatus::isValidValue(4));
    }
}