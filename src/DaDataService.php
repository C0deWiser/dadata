<?php


namespace Codewiser\Dadata;

use Codewiser\Dadata\Names\CleanName;
use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayers;
use Dadata\DadataClient;
use Psr\SimpleCache\CacheInterface;

class DaDataService implements TaxpayerServiceContract
{
    public function __construct(
        readonly public ?DadataClient $client,
        readonly public ?CacheInterface $cache,
    ) {
        //
    }

    /**
     * Check if da-data service is properly configured.
     */
    public function enabled(): bool
    {
        return (boolean) $this->client;
    }

    protected function ttl(): \DateInterval
    {
        return now()->diff(now()->addDay());
    }

    /**
     * @deprecated
     */
    public function search(int $inn): Taxpayers
    {
        return $this->taxpayer($inn);
    }

    /**
     * Поиск по ИНН.
     */
    public function taxpayer(int $inn): Taxpayers
    {
        if (!$this->enabled()) {
            throw new \RuntimeException("DaData is not configured");
        }

        $items = $this->cache?->get(__METHOD__.$inn);

        if (!$items) {
            $items = $this->client->findById('party', $inn);
            $this->cache?->set(__METHOD__.$inn, $items, $this->ttl());
        }

        return Taxpayers::make(
            array_map(fn($data) => Taxpayer::make($data), $items),
        )->sortByStatus();
    }

    /**
     * Стандартизация ФИО
     */
    public function cleanName(string $name): CleanName
    {
        if (!$this->enabled()) {
            throw new \RuntimeException("DaData is not configured");
        }

        $response = $this->cache?->get(__METHOD__.$name);

        if (!$response) {
            $response = $this->client->clean('name', $name);
            $this->cache?->set(__METHOD__.$name, $response, $this->ttl());
        }

        return CleanName::make($response);
    }
}
