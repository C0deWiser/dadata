<?php

namespace Codewiser\Dadata\Profile;

use Codewiser\Dadata\ArrayBased;

/**
 * @property-read \DateTimeInterface $date
 * @property-read ServiceStat $services Потрачено.
 * @property-read ServiceStat $remaining Осталось.
 */
class DailyStats extends ArrayBased
{
    protected array $casts = [
        'date'      => 'date',
        'services'  => ServiceStat::class,
        'remaining' => ServiceStat::class,
    ];
}