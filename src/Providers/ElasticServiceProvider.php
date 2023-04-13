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

}
