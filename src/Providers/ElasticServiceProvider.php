<?php

namespace Elastic\Providers;

use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\ElasticsearchHandler;

class ElasticServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->makeElasticHandler();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/logging.php', 'logging'
        );
    }

    /**
     * Регистрация Elasticsearch логера
     *
     * @return void
     */
    public function makeElasticHandler()
    {
        $this->app->bind(ElasticsearchHandler::class, function ($app) {
            return new ElasticsearchHandler(ClientBuilder::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build(), 
            [
                'index' => env('ELASTIC_LOGS_INDEX', 'default'),
                'type'  => '_doc',
                'ignore_error' => true,
            ]);
        });
    }
}
