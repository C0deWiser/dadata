<?php

namespace Codewiser\Dadata\Taxpayer\Casts;

use Codewiser\Dadata\Taxpayer\Taxpayer;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsTaxpayer implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value) {
            $value = json_decode($value, true);
        }

        if (is_array($value)) {
            $value = new Taxpayer($value);
        }

        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof Taxpayer) {
            $value = $value->getData();
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        return $value;
    }
}
