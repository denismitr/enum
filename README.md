# PHP ENUMS

## Install
```composer require denismitr/enum```

## Examples

### Create your enum

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

### Instantiate from key
```php
$beingDelivered = OrderStatus::fromKey('BEING_DELIVERED');
```

### Instantiate from key
```php
$completed = OrderStatus::fromValue(2);
```

### Enumerate all
```php
OrderStatus::enumerate(); 
// [
//    'PENDING' => 1,
//    'COMPLETED' => 2,
//    'CANCELED' => 3,
//    'BEING_DELIVERED' => 4,
// ];
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
// all keys
OrderStatus::keys(); // ['PENDING', 'COMPLETED', 'CANCELED', 'BEING_DELIVERED']
// all keys except except PENDING and CANCELED
OrderStatus::keys(OrderStatus::PENDING(), OrderStatus::CANCELED()); // ['COMPLETED', 'BEING_DELIVERED']

// all values
OrderStatus::values(); // [1,2,3,4]
// all values except PENDING and CANCELED
OrderStatus::values(OrderStatus::PENDING(), OrderStatus::CANCELED()); // [2,4]
```

## Non associative states
```php
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

$ready = Iota::READY();
$this->assertEquals(1, $ready->value());
$this->assertEquals('READY', $ready->key());

$pending = Iota::PENDING();
$this->assertEquals(0, $pending->value());
$this->assertEquals('PENDING', $pending->key());

$failed = Iota::FAILED();
$this->assertEquals(2, $failed->value());
$this->assertEquals('FAILED', $failed->key());

$this->assertEquals([
    'PENDING' => 0,
    'READY' => 1,
    'FAILED' => 2,
], Iota::enumerate());
```



