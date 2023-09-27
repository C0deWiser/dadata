<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * ФИО индивидуального предпринимателя.
 *
 * @property string|null $surname фамилия
 * @property string|null $name имя
 * @property string|null $patronymic отчество
 */
class TaxpayerFio extends ArrayBased implements Stringable
{
    //
    public function __toString(): string
    {
        return trim(
            $this->surname . ' ' . $this->name . ' ' . $this->patronymic
        );
    }
}