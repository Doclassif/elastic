<?php

use Monolog\Handler\ElasticsearchHandler;
use Elastic\ElasticsearchFormatter;

return [

    'channels' => [
        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => ElasticsearchHandler::class,
            'formatter'      => ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type'  => '_doc'
            ]
        ],
    ],

];
