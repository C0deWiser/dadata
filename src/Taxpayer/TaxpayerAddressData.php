<?php

namespace Codewiser\Dadata\Taxpayer;

use Codewiser\Dadata\ArrayBased;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Детали адреса.
 *
 * @property integer|null $postal_code Индекс
 * @property string|null $country Страна
 * @property string|null $country_iso_code Код страны
 * @property string|null $federal_district Федеральный округ
 * @property string|null $region Регион
 * @property string|null $region_with_type Название региона с типом
 * @property string|null $area Область
 * @property string|null $area_with_type Название области с типом
 * @property string|null $city Город
 * @property string|null $city_with_type Название города с типом
 * @property string|null $city_district Район города
 * @property string|null $city_district_with_type Название района города с типом
 * @property string|null $settlement Поселение
 * @property string|null $settlement_with_type Название поселения с типом
 * @property string|null $street Улица
 * @property string|null $street_with_type Название улицы с типом
 * @property string|null $stead Ферма
 * @property string|null $stead_with_type Название фермы с типом
 * @property string|null $house Здание
 * @property string|null $house_with_type Название здания с типом
 * @property string|null $block Корпус
 * @property string|null $block_with_type Название корпуса с типом
 * @property string|null $flat Квартира
 * @property string|null $flat_with_type Название квартиры с типом
 * @property string|null $room Комната
 * @property string|null $room_with_type Название комнаты с типом
 */
class TaxpayerAddressData extends ArrayBased
{
    public function __construct(array $data = [])
    {
        foreach (['stead', 'house', 'block', 'flat', 'room'] as $type) {
            $data["{$type}_with_type"] = trim(($data["{$type}_type"] ?? '') . ' ' . ($data[$type] ?? '')) ?: null;
        }

        parent::__construct($data);
    }

    protected array $casts = [
        'postal_code' => 'integer',
    ];
}