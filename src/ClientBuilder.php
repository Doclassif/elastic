<?php

namespace Kali\Elastic;
use Elastic\Elasticsearch\ClientBuilder as ElasticClient;

use Elasticsearch\Client;
use Elastic\Elasticsearch\Client as Client8;

class ClientBuilder 
{
    public static function create(array $client) {
        return ElasticClient::create()->setHosts($client)->build();
    }
}
