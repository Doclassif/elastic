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
    use Monolog\Handler\ElasticsearchHandler;
    use Elastic\ElasticsearchFormatter;

    'channels' => [

        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'elasticsearch'],
            'ignore_exceptions' => false,
        ],

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
```

.env переменные

```
ELASTIC_HOST=elasticsearch:9200
ELASTIC_LOGS_INDEX=test_logs
```

4. Выполнить ```php artisan vendor:publish``` и выбрать ```Elastic\Providers\ElasticServiceProvider```