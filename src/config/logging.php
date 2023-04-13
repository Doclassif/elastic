<?php

return [

    
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'elasticsearch'],
            'ignore_exceptions' => false,
        ],

        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => Elastic\ElasticsearchHandler::class,
            'formatter'      => Elastic\ElasticsearchFormatter::class,
            'formatter_with' => [
                'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type'  => '_doc',
            ],
            'handler_with'   => [
                'client' => Elasticsearch\ClientBuilder::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build(),
            ],
        ],
    ],

];
