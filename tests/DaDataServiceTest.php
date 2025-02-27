<?php

namespace Tests;

use Codewiser\Dadata\DaDataService;
use Codewiser\Dadata\Taxpayer\Taxpayer;
use Dadata\DadataClient;
use Dotenv\Dotenv;
use Illuminate\Cache\ArrayStore;
use PHPUnit\Framework\TestCase;

class DaDataServiceTest extends TestCase
{
    protected DaDataService $service;
    protected function setUp(): void
    {
        parent::setUp();

        $env = Dotenv::createImmutable(__DIR__);
        $env->load();

        $this->service = new DaDataService(
            new DadataClient($_ENV['DADATA_TOKEN'], $_ENV['DADATA_SECRET']),
            new NullCache()
        );
    }

    public function testService(): void
    {
        $items = $this->service->taxpayer(7707083893);

        $items->each(function (Taxpayer $item) {
            $this->assertEquals(7707083893, $item->inn);
        });
    }
}
