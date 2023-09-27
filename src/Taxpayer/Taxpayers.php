<?php

namespace Codewiser\Dadata\Taxpayer;

use Illuminate\Support\Collection;

/**
 * @method Taxpayer|null first(callable $callback = null, $default = null)
 */
class Taxpayers extends Collection
{
    /**
     * Упорядочить результаты по статусу юрлица.
     */
    public function sortByStatus(): static
    {
        return $this
            ->sort(function (Taxpayer $one, Taxpayer $two) {
                return $one->state->status->getSortPriorityAgainst($two->state->status);
            });
    }
}
