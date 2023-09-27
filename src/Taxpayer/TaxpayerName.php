<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * Наименование.
 *
 * @property string|null $full_with_opf полное наименование
 * @property string|null $short_with_opf краткое наименование
 * @property string|null $full полное наименование без ОПФ
 * @property string|null $short краткое наименование без ОПФ
 */
class TaxpayerName extends ArrayBased implements Stringable
{
    public function __toString()
    {
        return $this->short_with_opf;
    }
}