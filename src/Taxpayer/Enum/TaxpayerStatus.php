<?php

namespace Codewiser\Dadata\Taxpayer\Enum;

enum TaxpayerStatus: string
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
            self::unknown, self::liquidating, self::active, self::reorganizing => true,
            self::liquidated, self::bankrupt => false,
        };
    }

    public function getSortPriorityAgainst(self $status): int
    {
        if ($this->weight() == $status->weight()) return 0;
        return ($this->weight() < $status->weight()) ? -1 : 1;
    }

    /**
     * Правила сортировки результатов в зависимости от статуса юрлица.
     */
    public function weight(): int
    {
        return match ($this) {
            self::active => 0,
            self::reorganizing => 1,
            self::liquidating => 2,
            self::bankrupt => 3,
            self::liquidated => 4,
            self::unknown => PHP_INT_MAX,
        };
    }
}
