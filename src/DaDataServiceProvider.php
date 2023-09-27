<?php


namespace Codewiser\Dadata;


use Codewiser\Dadata\Taxpayer\Contracts\TaxpayerServiceContract;
use Dadata\DadataClient;
use Illuminate\Support\ServiceProvider;

class DaDataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TaxpayerServiceContract::class, function ($app) {
            return new DaDataService(
                new DadataClient(
                    $app['config']['services.dadata.token'],
                    $app['config']['services.dadata.secret'],
                )
            );
        });
    }
}
