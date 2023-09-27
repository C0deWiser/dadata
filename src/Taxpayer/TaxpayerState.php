<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\Taxpayer\Enum\TaxpayerStatus;
use Codewiser\Dadata\ArrayBased;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;

/**
 * ФИО индивидуального предпринимателя.
 *
 * @property DateTime|null $actuality_date дата последних изменений
 * @property DateTime|null $registration_date дата регистрации
 * @property DateTime|null $liquidation_date дата ликвидации
 * @property TaxpayerStatus|null $status статус организации
 */
class TaxpayerState extends ArrayBased
{
    protected array $casts = [
        'actuality_date'    => 'timestamp',
        'registration_date' => 'timestamp',
        'liquidation_date'  => 'timestamp',
        'status'            => TaxpayerStatus::class,
    ];

}