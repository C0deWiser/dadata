<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\Taxpayer\Enum\TaxpayerStatus;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerType;
use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * @property integer|null $inn
 * @property integer|null $kpp
 * @property integer|null $ogrn
 * @property integer|null $okato
 * @property integer|null $oktmo
 * @property \DateTime|null $ogrn_date
 * @property TaxpayerType|null $type
 * @property TaxpayerName|null $name
 * @property TaxpayerFio|null $fio
 * @property TaxpayerOpf|null $opf
 * @property TaxpayerState|null $state
 * @property TaxpayerAddress|null $address
 */
class Taxpayer extends ArrayBased implements Stringable
{
    protected array $casts = [
        'inn'       => 'integer',
        'kpp'       => 'integer',
        'ogrn'      => 'integer',
        'ogrn_date' => 'timestamp',
        'type'      => TaxpayerType::class,
        'name'      => TaxpayerName::class,
        'fio'       => TaxpayerFio::class,
        'okato'     => 'integer',
        'oktmo'     => 'integer',
        'opf'       => TaxpayerOpf::class,
        'state'     => TaxpayerState::class,
        'address'   => TaxpayerAddress::class,
    ];

    public function __toString()
    {
        return $this->name ?? $this->fio;
    }
}
