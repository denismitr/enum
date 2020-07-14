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

        $keys = array_flip($states);

        if ( ! array_key_exists($value, $keys)) {
            throw new InvalidArgumentException("Invalid enum value {$value}");
        }

        $this->states = $states;
        $this->value = $value;
        $this->key = $keys[$value];
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