# PHP ENUMS

## WIP

### Example

Create your enum

```php
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
```

### Instantiate and use it

```php
$pending = OrderStatus::PENDING();

$this->assertInstanceOf(OrderStatus::class, $pending);
$this->assertEquals(1, $pending->value());
$this->assertEquals('PENDING', $pending->key());
$this->assertTrue($pending->isPending());
$this->assertFalse($pending->isCanceled());
```

### Validate values and keys
```php
OrderStatus::isValidKey('PENDING'); // true
OrderStatus::isValidValue(1); // true

OrderStatus::isValidKey('FOO'); // false
OrderStatus::isValidValue(5); // false
```


### Extract keys or values

```php
OrderStatus::keys(); // ['PENDING', 'COMPLETED', 'CANCELED', 'BEING_DELIVERED']
OrderStatus::keys(OrderStatus::PENDING(), OrderStatus::CANCELED()); // ['COMPLETED', 'BEING_DELIVERED']

OrderStatus::values(); // [1,2,3,4]
OrderStatus::values(OrderStatus::PENDING(), OrderStatus::CANCELED()); // [2,4]
```



