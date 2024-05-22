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
        $this->app->singleton(DaDataService::class,
            fn($app) => new DaDataService(
                new DadataClient(
                    $app['config']['services.dadata.token'],
                    $app['config']['services.dadata.secret'],
                ),
                cache()->driver()
            ));

        $this->app->singleton(TaxpayerServiceContract::class,
            fn($app) => app(DaDataService::class));
    }
}
