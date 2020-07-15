<?php

declare(strict_types=1);

namespace Denismitr\Enum;

use InvalidArgumentException;

abstract class Enum
{
    protected $value;
    protected $key;
    protected $states = [];
    protected $checkMethod;

    protected function __construct($value, string $key, array $states)
    {
        if ( ! \in_array($value, $states)) {
            throw new InvalidArgumentException("Invalid enum value {$value}");
        }

        $this->states = $states;
        $this->value = $value;
        $this->key = $key;
    }

    public abstract static function enumerate(): array;

    public static function __callStatic($name, $arguments)
    {
        $states = static::enumerate();

        if ( ! array_key_exists($name, $states)) {
            throw new \Exception("Attempt to initialize enum with Invalid state {$name}");
        }

        $value = $states[$name];

        return new static($value, $name, $states);
    }

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

    public static function isValidValue($value): bool
    {
        return in_array($value, static::enumerate());
    }

    public static function isValidKey(string $key): bool
    {
        return array_key_exists($key, static::enumerate());
    }

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