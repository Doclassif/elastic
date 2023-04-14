# Elastic custom formatter

<a href="https://packagist.org/packages/doclassif/elastic"><img src="https://img.shields.io/packagist/v/doclassif/elastic" alt="Latest Stable Version"></a>

## Запуск в dev container VScode
1. Open project
2. F1 -> Dev Containers: Rebuild and Reopen in Container

## Запуск тестов (которые будут в обозримом будущем)
```sh
composer test
```

3. Добавить конфигурацию в ```config/logging.php``` (актуальная конфигурация в документации пакета)

```php
     'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'elasticsearch'],
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
                'client' => [env('ELASTIC_HOST', "http://elasticsearch:9200/")],
                'options' => [
                    'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),
                ]
            ],
        ],
    ],

```

.env переменные

```
ELASTIC_HOST=elasticsearch:9200
ELASTIC_LOGS_INDEX=test_logs
```

4. Выполнить ```php artisan vendor:publish``` и выбрать ```Elastic\Providers\ElasticServiceProvider```