<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * Организационно-правовая форма.
 *
 * @property integer|null $code код ОКОПФ
 * @property integer|null $type версия справочника ОКОПФ (99, 2012 или 2014)
 * @property string|null $full полное название ОПФ
 * @property string|null $short краткое название ОПФ
 */
class TaxpayerOpf extends ArrayBased implements Stringable
{
    protected array $casts = [
        'code'  => 'integer',
        'type'  => 'integer',
    ];

    public function __toString()
    {
        return $this->short;
    }
}