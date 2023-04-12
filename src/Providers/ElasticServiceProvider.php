<?php

namespace Elastic\Custom\Providers;

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
        //
    }

    /**
     * Регистрация Elasticsearch логера
     *
     * @return void
     */
    public function makeElasticHandler()
    {
        $this->app->bind(ElasticsearchHandler::class, function ($app) {
            return new ElasticsearchHandler(ClientBuilder::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build());
        });
    }
}
