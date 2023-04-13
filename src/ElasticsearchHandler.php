<?php

namespace Elastic;

use Elasticsearch\ClientBuilder;
use Monolog\Handler\ElasticsearchHandler as Handler;
use Monolog\Level;
use Elastic\Elasticsearch\Client as Client8;

class ElasticsearchHandler extends Handler
{
    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build();
        $this->options = 
            [
                'index' => env('ELASTIC_LOGS_INDEX', 'default'),
                'type'  => '_doc',
                'ignore_error' => env('ELASTIC_IGNORE_ERROR', true),    // Suppress Elasticsearch exceptions
                'op_type'      => 'index',   // Elastic op_type (index or create) (https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-index_.html#docs-index-api-op_type)
            ];

        if ($this->client instanceof Client8 || $this->client::VERSION[0] === '7') {
            $this->needsType = false;
            // force the type to _doc for ES8/ES7
            $this->options['type'] = '_doc';
        } else {
            $this->needsType = true;
        }
    }
}
