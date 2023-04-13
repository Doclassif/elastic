<?php

namespace Elastic;
use Elasticsearch\ClientBuilder as Client;

class ClientBuilder 
{
    public static function create() {
        return Client::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build();
    }
}
