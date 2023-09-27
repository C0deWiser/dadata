<?php

namespace Codewiser\Dadata;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Stringable;

abstract class ArrayBased implements Arrayable
{
    protected array $data = [];
    protected array $casts = [];

    public static function make(array $data): ?static
    {
        return $data ? new static($data) : null;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            $data[$key] = $this->cast($key, $value);
        }

        $this->data = $data;
    }

    protected function cast($name, $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        $cast = $this->casts[$name] ?? null;

        switch ($cast) {
            case 'string':
                return (string)$value;
            case 'boolean':
                return (boolean)$value;
            case 'integer':
                return (integer)$value;
            case 'timestamp':
                return (new \DateTime)->setTimestamp($value / 1000);
            default:
                if (enum_exists($cast)) {
                    return $cast::tryFrom($value);
                }
                if (class_exists($cast)) {
                    return new $cast($value);
                }
                return $value;
        }
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $this->cast($name, $value);
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void
    {
        unset($this->data[$name]);
    }

    public function toArray(): array
    {
        $data = $this->data;

        foreach ($data as $key => $value) {
            $data[$key] = $value instanceof Arrayable ? $value->toArray() : (
            $value instanceof Stringable ? (string)$value : $value
            );
        }

        return $data;
    }
}