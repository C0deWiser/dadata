<?php

namespace Codewiser\Dadata\Taxpayer\Enum;

use Illuminate\Contracts\Support\Arrayable;

enum TaxpayerType: string implements Arrayable
{
    case unknown = 'unknown';
    case legal = 'LEGAL';
    case individual = 'INDIVIDUAL';

    public function caption(): string
    {
        return match ($this) {
            self::legal => __('dadata::taxpayer.type.legal'),
            self::individual => __('dadata::taxpayer.type.individual'),
            self::unknown => __('dadata::taxpayer.type.unknown'),
        };
    }

    public function toArray(): array
    {
        return [
            'name' => $this->caption(),
            'value' => $this->value,
        ];
    }
}
