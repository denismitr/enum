<?php

declare(strict_types=1);

namespace Denismitr\Enum;

use InvalidArgumentException;

abstract class Enum
{
    protected $value;
    protected $key;
    protected $states = [];

    protected abstract static function getStates(): array;

    protected function __construct($value, string $key, array $states)
    {
        if ( ! \in_array($value, $states)) {
            throw new InvalidArgumentException("Invalid enum value {$value}");
        }

        $this->states = $states;
        $this->value = $value;
        $this->key = $key;
    }

    public static function __callStatic($name, $arguments)
    {
        $states = static::getStates();

        if ( ! array_key_exists($name, $states)) {
            throw new InvalidArgumentException("Invalid state {$name}");
        }

        $value = $states[$name];

        return new static($value, $name, $states);
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'is') === 0) {
            $key = strtoupper(str_replace('is', '', $name));

            if ( ! array_key_exists($key, $this->states)) {
                throw new InvalidArgumentException("Invalid enum state {$key}");
            }

            return $this->key === $key;
        }

        throw new \BadMethodCallException("Method $name does not exist");
    }

    public static function isValidValue($value): bool
    {
        return in_array($value, static::getStates());
    }

    public static function isValidKey(string $key): bool
    {
        return array_key_exists($key, static::getStates());
    }

    public static function values(): array
    {
        return array_values(static::getStates());
    }

    /**
     * @param string[]
     * @return string[]
     */
    public static function keys(array $except = []): array
    {
        $keys = [];

        foreach (static::getStates() as $key=>$value) {
            if ( ! in_array($key, $except)) {
                $keys[] = $key;
            }
        }

        return $keys;
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
}