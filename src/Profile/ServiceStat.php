<?php

namespace Codewiser\Dadata\Profile;

use Codewiser\Dadata\ArrayBased;

/**
 * @property-read integer $clean
 * @property-read integer $company
 * @property-read integer $company_similar
 * @property-read integer $merging
 * @property-read integer $suggestions
 */
class ServiceStat extends ArrayBased
{
    protected array $casts = [
        'clean'           => 'integer',
        'company'         => 'integer',
        'company_similar' => 'integer',
        'merging'         => 'integer',
        'suggestions'     => 'integer',
    ];
}