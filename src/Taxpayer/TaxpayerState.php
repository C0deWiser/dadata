<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerStatus;
use DateTimeInterface;

/**
 * ФИО индивидуального предпринимателя.
 *
 * @property DateTimeInterface|null $actuality_date дата последних изменений
 * @property DateTimeInterface|null $registration_date дата регистрации
 * @property DateTimeInterface|null $liquidation_date дата ликвидации
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