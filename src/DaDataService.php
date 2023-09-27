<?php


namespace Codewiser\Dadata;

use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerStatus;
use Codewiser\Dadata\Taxpayer\Enum\TaxpayerType;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayers;
use Dadata\DadataClient;

class DaDataService implements TaxpayerServiceContract
{
    public function __construct(
        protected DadataClient     $client
    )
    {
        //
    }

    public function search(int $inn): Taxpayers
    {
        $items = $this->client->findById('party', $inn);

        $found = new Taxpayers;

        foreach ($items as $item) {
            $found->add(Taxpayer::make($item['data']));
        }

        return $found->sortByStatus();
    }
}
