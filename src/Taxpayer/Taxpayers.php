<?php

namespace Codewiser\Dadata\Taxpayer;

use Illuminate\Support\Collection;

/**
 * @extends Collection<int,Taxpayer>
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
