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
                'index' => env('ELASTIC_LOGS_INDEX'),
                'type'  => '_doc',
            ],
            'handler_with'   => [
                'options' => [
                    'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),
                ]
            ],
        ],
    ],

];
