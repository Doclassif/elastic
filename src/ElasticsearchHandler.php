<?php

namespace Elastic;

use Elasticsearch\ClientBuilder;
use Monolog\Handler\ElasticsearchHandler as Handler;

class ElasticsearchHandler extends Handler
{
    
    /**
     * @param Client|Client8 $client  Elasticsearch Client object
     * @param mixed[]        $options Handler configuration
     *
     * @phpstan-param InputOptions $options
     */
    public function __construct(Client|Client8 $client, array $options = [], int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->client = ClientBuilder::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build();
        $this->options = array_merge(
            [
                'index' => env('ELASTIC_LOGS_INDEX', 'default'),
                'type'  => '_doc',
                'ignore_error' => true,    // Suppress Elasticsearch exceptions
                'op_type'      => 'index',   // Elastic op_type (index or create) (https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-index_.html#docs-index-api-op_type)
            ],
            $options
        );

        if ($client instanceof Client8 || $client::VERSION[0] === '7') {
            $this->needsType = false;
            // force the type to _doc for ES8/ES7
            $this->options['type'] = '_doc';
        } else {
            $this->needsType = true;
        }
    }
}
