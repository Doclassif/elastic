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
        ],
    ],

];
