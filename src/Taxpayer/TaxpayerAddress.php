<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * Адрес.
 *
 * @property string|null $value Полный адрес
 * @property TaxpayerAddressData|null $data Подробности
 */
class TaxpayerAddress extends ArrayBased implements Stringable
{
    protected array $casts = [
        'data'  => TaxpayerAddressData::class,
    ];

    public function __toString()
    {
        return $this->value;
    }
}