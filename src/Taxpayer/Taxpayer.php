<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Codewiser\Dadata\Taxpayer\Enum\BranchType;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerType;
use DateTimeInterface;
use Stringable;

/**
 * @property string|null $inn ИНН (идентификационный номер налогоплательщика)
 * @property string|null $kpp КПП (код причины постановки на учет)
 * @property string|null $ogrn ОГРН (основной государственный регистрационный номер)
 * @property string|null $okato Код ОКАТО (общероссийский классификатор объектов административно-территориального деления)
 * @property string|null $oktmo Код ОКТМО (общероссийский классификатор территорий муниципальных образований)
 * @property string|null $okpo Код ОКПО
 * @property string|null $okogu Код ОКОГУ
 * @property string|null $okfs Код ОКФС
 * @property string|null $okved Код ОКВЭД
 * @property string|null $okved_type Версия справочника ОКВЭД (2001 или 2014)
 * @property DateTimeInterface|null $ogrn_date Дата постановки на учет
 * @property TaxpayerType|null $type Тип налогоплательщика
 * @property TaxpayerName|null $name Название юридического лица
 * @property TaxpayerFio|null $fio ФИО индивидуального предпринимателя
 * @property TaxpayerOpf|null $opf Организационно-правовая форма
 * @property TaxpayerState|null $state Состояние налогоплательщика
 * @property TaxpayerAddress|null $address Адрес налогоплательщика
 * @property TaxpayerManagement|null $management Руководитель
 * @property integer|null $branch_count Количество филиалов
 * @property BranchType|null $branch_type Тип подразделения
 */
class Taxpayer extends ArrayBased implements Stringable
{
    protected array $casts = [
        'ogrn_date'    => 'timestamp',
        'branch_count' => 'integer',
        'branch_type'  => BranchType::class,
        'type'         => TaxpayerType::class,
        'name'         => TaxpayerName::class,
        'fio'          => TaxpayerFio::class,
        'opf'          => TaxpayerOpf::class,
        'state'        => TaxpayerState::class,
        'address'      => TaxpayerAddress::class,
        'management'   => TaxpayerManagement::class,
    ];

    public function __toString()
    {
        return $this->name ?? $this->fio;
    }
}
