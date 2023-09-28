<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\Taxpayer\Enum\TaxpayerStatus;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerType;
use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;
use Stringable;

/**
 * @property integer|null $inn Идентификационный номер налогоплательщика
 * @property integer|null $kpp Код причины постановки на учет
 * @property integer|null $ogrn Основной государственный регистрационный номер
 * @property integer|null $okato Общероссийский классификатор объектов административно-территориального деления
 * @property integer|null $oktmo Общероссийский классификатор территорий муниципальных образований
 * @property \DateTime|null $ogrn_date Дата постановки на учет
 * @property TaxpayerType|null $type Тип налогоплательщика
 * @property TaxpayerName|null $name Название юридического лица
 * @property TaxpayerFio|null $fio Имя физического лица
 * @property TaxpayerOpf|null $opf Организационно-правовая форма
 * @property TaxpayerState|null $state Состояние налогоплательщика
 * @property TaxpayerAddress|null $address Адрес налогоплательщика
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
