<?php

declare(strict_types=1);

namespace Denismitr\Enum;

use Denismitr\Enum\Exceptions\EnumIsDeclaredIncorrectly;
use InvalidArgumentException;

abstract class Enum
{
    protected $value;
    protected $key;
    protected $checkMethod;

    protected static $enumerated;

    protected function __construct($value, string $key)
    {
        $this->value = $value;
        $this->key = $key;
    }

    /**
     * @param string $key
     * @return static
     */
    public static function fromKey(string $key)
    {
        return static::$key();
    }

    /**
     * @param mixed $value
     * @return static
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function fromValue($value)
    {
        $enumerate = static::enumerate();

        foreach ($enumerate as $k=>$v) {
            if ($value === $v) {
                return new static($value, $k);
            }
        }

        throw new InvalidArgumentException("Invalid value {$value}");
    }

    protected abstract static function states(): array;

    /**
     * @return array
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function enumerate(): array
    {
        if ( ! isset(static::$enumerated[static::class])) {
            $states = static::states();

            if ( ! static::isAssoc($states)) {
                // for non associative array we use string values as keys
                // and sequential keys are turned into sequential values
                foreach ($states as $k=>$v) {
                    if ( ! is_string($v) || is_numeric($v)) {
                        throw new EnumIsDeclaredIncorrectly("All values of non associative array like state must be strings");
                    }
                }

                static::$enumerated[static::class] = array_flip($states);
            } else {
                foreach ($states as $k=>$v) {
                    if ( ! is_string($k) || is_numeric($k)) {
                        throw new EnumIsDeclaredIncorrectly("All keys of states must be strings or be omitted");
                    }
                }

                static::$enumerated[static::class] = $states;
            }
        }

        return static::$enumerated[static::class];
    }

    private static function isAssoc(array $states): bool
    {
        if ($states === []) return false;
        return array_keys($states) !== range(0, count($states) - 1);
    }

    /**
     * @param string $name
     * @param $arguments
     * @return static
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $states = static::enumerate();

        if ( ! array_key_exists($name, $states)) {
            throw new \Exception("Attempt to initialize enum with invalid state {$name}");
        }

        $value = $states[$name];

        return new static($value, $name);
    }

    /**
     * @param $name
     * @param $arguments
     * @return bool
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'is') === 0) {
            if ($this->checkMethod === null) {
                $this->generateCheckMethod();
            }

            return $name === $this->checkMethod;
        }

        throw new \Exception("Method {$name} does not exist");
    }

    /**
     * @param $value
     * @return bool
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function isValidValue($value): bool
    {
        return in_array($value, static::enumerate());
    }

    /**
     * @param string $key
     * @return bool
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function isValidKey(string $key): bool
    {
        return array_key_exists($key, static::enumerate());
    }

    /**
     * @param Enum ...$except
     * @return array
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function values(Enum ...$except): array
    {
        $values = array_values(static::enumerate());
        if (\count($except) === 0) {
            return $values;
        }

        $exceptValues = array_map(function($enum) {
            return $enum->value();
        }, $except);

        return array_values(array_diff($values, $exceptValues));
    }

    /**
     * @param Enum ...$except
     * @return array
     * @throws EnumIsDeclaredIncorrectly
     */
    public static function keys(Enum ...$except): array
    {
        $keys = array_keys(static::enumerate());

        if (\count($except) === 0) {
            return $keys;
        }

        $exceptKeys = array_map(function($enum) {
            return $enum->key();
        }, $except);

        return array_values(array_diff($keys, $exceptKeys));
    }

    public function is(Enum $enum): bool
    {
        if ( ! ($enum instanceof static)) {
            return false;
        }

        return $this->value === $enum->value();
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function hasValue($value): bool
    {
        return $this->value === $value;
    }

    public function hasKey(string $key): bool
    {
        return $this->key === $key;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    public function key(): string
    {
        return $this->key;
    }

    protected function generateCheckMethod()
    {
        $this->checkMethod = 'is' . str_replace(' ', '', ucwords(
            str_replace('_', ' ', strtolower($this->key))
        ));
    }
}