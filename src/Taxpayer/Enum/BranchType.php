<?php

namespace Codewiser\Dadata\Taxpayer\Enum;

use Illuminate\Contracts\Support\Arrayable;

enum BranchType: string implements Arrayable
{
    case unknown = 'unknown';
    case main = 'MAIN';
    case branch = 'BRANCH';

    public function caption(): string
    {
        return match ($this) {
            self::main => __('dadata::taxpayer.branch.main'),
            self::branch => __('dadata::taxpayer.branch.branch'),
            self::unknown => __('dadata::taxpayer.branch.unknown'),
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
