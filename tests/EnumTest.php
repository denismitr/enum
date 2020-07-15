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

        $delivering = OrderStatus::BEING_DELIVERED();

        $this->assertInstanceOf(OrderStatus::class, $delivering);
        $this->assertEquals(4, $delivering->value());
        $this->assertEquals('BEING_DELIVERED', $delivering->key());
        $this->assertTrue($delivering->isBeingDelivered());
        $this->assertFalse($delivering->isPending());
        $this->assertFalse($delivering->isCompleted());
        $this->assertFalse($delivering->isCanceled());
    }

    /**
     * @test
     */
    public function it_can_enumerate_itself()
    {
        $enumerate = OrderStatus::enumerate();

        $this->assertEquals([
            'PENDING' => 1,
            'COMPLETED' => 2,
            'CANCELED' => 3,
            'BEING_DELIVERED' => 4,
        ], $enumerate);
    }

    /**
     * @test
     */
    public function it_provides_static_validation()
    {
        $this->assertTrue(OrderStatus::isValidKey('PENDING'));
        $this->assertTrue(OrderStatus::isValidValue(1));

        $this->assertTrue(OrderStatus::isValidKey('COMPLETED'));
        $this->assertTrue(OrderStatus::isValidValue(2));

        $this->assertTrue(OrderStatus::isValidKey('CANCELED'));
        $this->assertTrue(OrderStatus::isValidValue(3));

        $this->assertTrue(OrderStatus::isValidKey('BEING_DELIVERED'));
        $this->assertTrue(OrderStatus::isValidValue(4));

        $this->assertFalse(OrderStatus::isValidKey('FOO'));
        $this->assertFalse(OrderStatus::isValidValue(5));
    }

    /**
     * @test
     */
    public function it_provides_static_information()
    {
        $keys = OrderStatus::keys();
        $keysExceptSome = OrderStatus::keys(OrderStatus::PENDING(), OrderStatus::CANCELED());

        $values = OrderStatus::values();
        $valuesExceptSome = OrderStatus::values(OrderStatus::PENDING(), OrderStatus::CANCELED());


        $this->assertEquals(['PENDING', 'COMPLETED', 'CANCELED', 'BEING_DELIVERED'], $keys);
        $this->assertEquals(['COMPLETED', 'BEING_DELIVERED'], $keysExceptSome);

        $this->assertEquals([1,2,3,4], $values);
        $this->assertEquals([2,4], $valuesExceptSome);
    }

    /**
     * @test
     */
    public function it_throws_on_invalid_initialization()
    {
        $this->expectException(\Exception::class);
        OrderStatus::FOO();
    }
}