<?php

namespace Kali\Elastic;

use Elastic\Elasticsearch\ClientBuilder as ElasticClient;

class ClientBuilder 
{
    public static function create(array $client) {
        return ElasticClient::create()->setHosts($client)->build();
    }
}
