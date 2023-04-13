<?php

return [

    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'elasticsearch'],
        'ignore_exceptions' => false,
    ],
    
    'channels' => [
        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => Elastic\ElasticsearchHandler::class,
            'formatter'      => Elastic\ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX', 'default'),
                'type'  => '_doc',
                'ignore_error' => true,
            ]
        ],
    ],

];
