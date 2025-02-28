<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use DateTimeInterface;
use Stringable;

/**
 * Наименование.
 *
 * @property string|null $name наименование руководителя (для юрлиц) или ФИО руководителя (для физлиц)
 * @property string|null $post должность руководителя (для физлиц)
 * @property DateTimeInterface|null $start_date дата вступления в должность руководителя
 */
class TaxpayerManagement extends ArrayBased implements Stringable
{
    protected array $casts = [
        'start_date'    => 'timestamp',
    ];

    public function __toString()
    {
        return $this->name;
    }
}