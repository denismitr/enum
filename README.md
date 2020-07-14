#PHP ENUMS

## WIP

### Example

Create your enum

```php
use Denismitr\Enum\Enum;
/**
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
```

Instantiate and use it

```php
 $pending = OrderStatus::PENDING();

$this->assertInstanceOf(OrderStatus::class, $pending);
$this->assertEquals(1, $pending->value());
$this->assertEquals('PENDING', $pending->key());
$this->assertTrue($pending->isPending());
```

