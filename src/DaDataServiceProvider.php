<?php


namespace Codewiser\Dadata;


use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Dadata\DadataClient;
use Illuminate\Support\ServiceProvider;

class DaDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'dadata');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/dadata'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(DaDataService::class, function ($app) {
            $token = $app['config']['services.dadata.token'];
            $secret = $app['config']['services.dadata.secret'];

            $client = $token ? new DadataClient($token, $secret) : null;

            return new DaDataService($client, cache()->driver());
        });

        $this->app->singleton(TaxpayerServiceContract::class,
            fn($app) => app(DaDataService::class));
    }
}
