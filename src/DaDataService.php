<?php


namespace Codewiser\Dadata;

use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayers;
use Dadata\DadataClient;
use Psr\SimpleCache\CacheInterface;

class DaDataService implements TaxpayerServiceContract
{
    public function __construct(
        protected DadataClient $client,
        protected CacheInterface $cache,
    ) {
        //
    }

    protected function ttl(): \DateInterval
    {
        return now()->diff(now()->addDay());
    }

    public function search(int $inn): Taxpayers
    {
        $items = $this->cache->get(__METHOD__.$inn);

        if (!$items) {
            $items = $this->client->findById('party', $inn);
            $this->cache->set(__METHOD__.$inn, $items, $this->ttl());
        }

        $found = new Taxpayers;

        foreach ($items as $item) {
            $found->add(Taxpayer::make($item['data']));
        }

        return $found->sortByStatus();
    }

    /**
     * Стандартизация ФИО
     */
    public function cleanName(string $name): CleanName
    {
        $response = $this->cache->get(__METHOD__.$name);

        if (!$response) {
            $response = $this->client->clean('name', $name);
            $this->cache->set(__METHOD__.$name, $response, $this->ttl());
        }

        return CleanName::make($response);
    }
}
