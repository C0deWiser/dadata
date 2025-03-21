<?php

namespace Codewiser\Dadata\Taxpayer\Enum;

use Illuminate\Contracts\Support\Arrayable;

enum TaxpayerStatus: string implements Arrayable
{
    case unknown = 'unknown';
    /**
     * Действующая
     */
    case active = 'ACTIVE';
    /**
     * В процессе ликвидации
     */
    case liquidating = 'LIQUIDATING';
    /**
     * Ликвидирована
     */
    case liquidated = 'LIQUIDATED';
    /**
     * Банкрот
     */
    case bankrupt = 'BANKRUPT';
    /**
     * В процессе присоединения к другому юрлицу, с последующей ликвидацией
     */
    case reorganizing = 'REORGANIZING';

    /**
     * Запрет на ведение деятельности?
     */
    public function denied(): bool
    {
        return !$this->allowed();
    }

    /**
     * Статус юридического лица разрешает ведение деятельности?
     */
    public function allowed(): bool
    {
        return match ($this) {
            self::unknown,
            self::liquidating,
            self::active,
            self::bankrupt,
            self::reorganizing => true,
            self::liquidated   => false,
        };
    }

    public function getSortPriorityAgainst(self $status): int
    {
        if ($this->weight() == $status->weight()) {
            return 0;
        }
        return ($this->weight() < $status->weight()) ? -1 : 1;
    }

    /**
     * Правила сортировки результатов в зависимости от статуса юрлица.
     */
    public function weight(): int
    {
        return match ($this) {
            self::active       => 0,
            self::reorganizing => 1,
            self::liquidating  => 2,
            self::bankrupt     => 3,
            self::liquidated   => 4,
            self::unknown      => PHP_INT_MAX,
        };
    }

    public function caption(): string
    {
        return match ($this) {
            self::active       => __('dadata::taxpayer.status.active'),
            self::reorganizing => __('dadata::taxpayer.status.reorganizing'),
            self::liquidating  => __('dadata::taxpayer.status.liquidating'),
            self::bankrupt     => __('dadata::taxpayer.status.bankrupt'),
            self::liquidated   => __('dadata::taxpayer.status.liquidated'),
            self::unknown      => __('dadata::taxpayer.status.unknown'),
        };
    }

    public function level(): string
    {
        return match ($this) {
            self::active     => 'success',
            self::liquidating,
            self::reorganizing,
            self::bankrupt   => 'warning',
            self::liquidated => 'danger',
            default          => 'secondary',
        };
    }

    public function toArray(): array
    {
        return [
            'name'    => $this->caption(),
            'value'   => $this->value,
            'allowed' => $this->allowed(),
            'level'   => $this->level(),
        ];
    }
}
