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
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'elasticsearch'],
        'ignore_exceptions' => false,
    ],
    
    'channels' => [
        'elasticsearch' => [
            'driver'         => 'monolog',
            'level'          => 'debug',
            'handler'        => Elastic\ElasticsearchHandler::class::class,
            'formatter'      => Elastic\ElasticsearchFormatter::class,
            'formatter_with' => [
                'index' => env('ELASTIC_LOGS_INDEX', 'default'),
                'type'  => '_doc',
                'ignore_error' => true,
            ]
        ],
    ],

```

.env переменные

```
ELASTIC_HOST=elasticsearch:9200
ELASTIC_LOGS_INDEX=test_logs
```

4. Выполнить ```php artisan vendor:publish``` и выбрать ```Elastic\Providers\ElasticServiceProvider```