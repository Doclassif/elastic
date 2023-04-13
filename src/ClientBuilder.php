<?php

namespace Elastic;
use Elasticsearch\ClientBuilder as Client;

class ClientBuilder 
{
    public function __construct() {
        Client::create()->setHosts([env('ELASTIC_HOST', "http://elasticsearch:9200/")])->build();
    }
}
