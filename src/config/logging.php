<?php

return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stdout', 'daily', 'elasticsearch'],
            'ignore_exceptions' => false,
        ],

        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => Kali\Elastic\ElasticsearchHandler::class,
            'formatter'      => Kali\Elastic\ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type'  => '_doc',
            ],
            'handler_with'   => [
                'hosts' => [env('ELASTIC_HOST', "http://elasticsearch:9200/")],
                'options' => [
                    'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),
                ]
            ],
        ],
    ],

];
