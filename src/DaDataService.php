<?php


namespace Codewiser\Dadata;

use Codewiser\Dadata\Names\CleanName;
use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Codewiser\Dadata\Taxpayer\Taxpayers;
use Dadata\DadataClient;
use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

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
     *
     * @param  string  $query ИНН или ОГРН.
     * @param  array  $params
     * * count:integer = 10 Количество результатов (максимум — 300).
     * * kpp:string КПП для поиска по филиалам.
     * * branch_type:string Головная организация (MAIN) или филиал (BRANCH).
     * * type:string Юрлицо (LEGAL) или индивидуальный предприниматель (INDIVIDUAL).
     * * status:array
     *   * ACTIVE       — действующая
     *   * LIQUIDATING  — ликвидируется
     *   * LIQUIDATED   — ликвидирована
     *   * BANKRUPT     — банкротство
     *   * REORGANIZING — в процессе присоединения к другому юрлицу
     */
    public function taxpayer(string $query, array $params = []): Taxpayers
    {
        if (!$this->enabled()) {
            throw new \RuntimeException("DaData is not configured");
        }

        $items = $this->cache?->get(__METHOD__.$query);

        if (!$items) {
            $items = $this->client->findById('party', $query);
            $this->cache?->set(__METHOD__.$query, $items, $this->ttl());
        }

        return Taxpayers::make(
            array_map(fn($data) => Taxpayer::make($data['data']), $items),
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
