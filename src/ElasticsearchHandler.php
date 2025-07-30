<?php

namespace Kali\Elastic;

use Monolog\Handler\ElasticsearchHandler as Handler;
use Monolog\Level;
use Elasticsearch\Client;
use Elastic\Elasticsearch\Client as Client8;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchHandler extends Handler
{
    public function __construct(array $hosts, array $options = [], int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        $client = ClientBuilder::create()->setHosts($hosts)->build();
        
        parent::__construct($client, $options, $level, $bubble);
    }
}
