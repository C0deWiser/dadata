<?php


namespace Codewiser\Dadata\Taxpayer\Contracts;

use Codewiser\Dadata\Taxpayer\Taxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayers;

interface TaxpayerServiceContract
{
    /**
     * Search taxpayer by inn number.
     *
     * @param int $inn
     * @return Taxpayers<Taxpayer>
     */
    public function search(int $inn): Taxpayers;
}
