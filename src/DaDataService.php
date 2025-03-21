<?php


namespace Codewiser\Dadata;

use Codewiser\Dadata\Names\CleanName;
use Codewiser\Dadata\Profile\DailyStats;
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

    protected function ttl(bool $short = false): \DateInterval
    {
        return now()->diff(
            $short
                ? now()->addMinutes(5)
                : now()->addDay()
        );
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
     * @param  string  $query  ИНН или ОГРН.
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

        $key = __METHOD__.md5(json_encode(func_get_args()));

        $items = $this->cache?->get($key);

        if (!$items) {
            $items = $this->client->findById('party', $query);
            $this->cache?->set($key, $items, $this->ttl());
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

        $key = __METHOD__.md5(json_encode(func_get_args()));

        $response = $this->cache?->get($key);

        if (!$response) {
            $response = $this->client->clean('name', $name);
            $this->cache?->set($key, $response, $this->ttl());
        }

        return CleanName::make($response);
    }

    public function getDailyStats($date = null): DailyStats
    {
        if (!$this->enabled()) {
            throw new \RuntimeException("DaData is not configured");
        }

        $key = __METHOD__.md5(json_encode(func_get_args()));

        $response = $this->cache?->get($key);

        if (!$response) {
            $response = $this->client->getDailyStats($date);
            $this->cache?->set($key, $response, $this->ttl(true));
        }

        return DailyStats::make($response);
    }

    public function getBalance(): float
    {
        if (!$this->enabled()) {
            throw new \RuntimeException("DaData is not configured");
        }

        $key = __METHOD__;

        $response = $this->cache?->get($key);

        if (!$response) {
            $response = $this->client->getBalance();
            $this->cache?->set($key, $response, $this->ttl(true));
        }

        return $response;
    }
}
