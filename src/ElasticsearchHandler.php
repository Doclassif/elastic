<?php

namespace Kali\Elastic;

use Monolog\Handler\ElasticsearchHandler as Handler;
use Monolog\Level;
use Elasticsearch\Client;
use Elastic\Elasticsearch\Client as Client8;


class ElasticsearchHandler extends Handler
{
    private $needsType;

    public function __construct(array $client, array $options = [], $level = Level::Debug, bool $bubble = true)
    {
        AbstractHandler::boot($level, $bubble);

        $this->client = ClientBuilder::create($client);

        if (!$this->client instanceof Client && !$this->client instanceof Client8) {
            throw new \TypeError('Elasticsearch\Client or Elastic\Elasticsearch\Client instance required');
        }

        $this->options = array_merge(
            [
                'index'        => 'monolog', // Elastic index name
                'type'         => '_doc',    // Elastic document type
                'ignore_error' => false,     // Suppress Elasticsearch exceptions
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
