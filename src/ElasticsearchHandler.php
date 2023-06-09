<?php

namespace Kali\Elastic;

use Monolog\Handler\ElasticsearchHandler as Handler;
use Monolog\Level;
use Elasticsearch\Client;
use Elastic\Elasticsearch\Client as Client8;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchHandler extends Handler
{
    public $needsType;

    public function __construct(array $hosts, array $options = [], int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        //AbstractHandler::boot($level, $bubble);

        $this->client = ClientBuilder::create()->setHosts($hosts)->build();

        if (!$this->client instanceof Client && !$this->client instanceof Client8) {
            throw new \TypeError('Elasticsearch\Client or Elastic\Elasticsearch\Client instance required');
        }

        $this->options = array_merge(
            [
                'index'        => 'monolog', // Elastic index name
                'type'         => '_doc',    // Elastic document type
                'ignore_error' => false,     // Suppress Elasticsearch exceptions
                'op_type'      => 'index',   // Elastic op_type (index or create)
            ],
            $options
        );

        if ($this->client instanceof Client8 || $this->client::VERSION[0] === '7') {
            $this->needsType = false;
            // force the type to _doc for ES8/ES7
            $this->options['type'] = '_doc';
        } else {
            $this->needsType = true;
        }
    }
}
