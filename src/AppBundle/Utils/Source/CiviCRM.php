<?php

namespace AppBundle\Utils\Source;

use AppBundle\Utils\Source;
use GuzzleHttp\Client;

class CiviCRM extends Source
{
    function __construct($base_uri, $key, $api_key){
        $this->client = new Client(['base_uri' => $base_uri]);
        $this->key=$key;
        $this->api_key=$api_key;
    }
    
    function fetch($entity, $params){
        $query = $params;
        $query['entity'] = $entity;
        $query['action'] = 'get';
        $query['key'] = $this->key;
        $query['api_key'] = $this->api_key;
        $query['json'] = 1;
        $response = $this->client->request('GET', '', ['query' => $query]);
        return json_decode((string)$response->getBody());
    }
    
    function fetchOne($entity, $params){
        $result = $this->fetch($entity, $params);
        if ($result->count == 1) {
            return $result->values->{$result->id};
        }
    }    
}
