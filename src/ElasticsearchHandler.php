<?php

namespace Elastic;

use Monolog\Handler\ElasticsearchHandler as Handler;


class ElasticsearchHandler extends Handler
{
    public function __construct(array $options = [])
    {
        $this->client = ClientBuilder::create();
        $this->options = array_merge(
            [
                'index'        => 'monolog', // Elastic index name
                'type'         => '_doc',    // Elastic document type
                'ignore_error' => false,     // Suppress Elasticsearch exceptions
            ],
            $options
        );
    }
}
