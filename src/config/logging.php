<?php

use Monolog\Handler\ElasticsearchHandler;
use Elastic\Custom\ElasticsearchFormatter;

return [

    'channels' => [
        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => ElasticsearchHandler::class,
            'formatter'      => ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type'  => '_doc',
                'test_format' => 'test'
            ]
        ],
    ],

];
