<?php

return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stdout', 'daily', 'elasticsearch'],
            'ignore_exceptions' => false,
        ],

        'elasticsearch' => [
            'driver' => 'monolog',
            'handler' => Kali\Elastic\ElasticsearchHandler::class,
            'formatter' => Kali\Elastic\ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type' => '_doc',
            ],
            'handler_with' => [
                'hosts' => [env('ELASTIC_HOST', "http://elasticsearch:9200/")],
                'options' => [
                    'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),
                ],
                'level' => env('LOG_LEVEL', env('APP_DEBUG', false) ? 'debug' : 'info'),
            ],
            'formatter_ignore_request_keys' => [] 
        ],
    ],

];
