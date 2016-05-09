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
        $response = $this->client->request('GET', '', ['query' => [
            'entity' => $entity,
            'params' => $params,
            'key' => $this->key,
            'api_key' => $this->api_key,
            'json' => 1,
            'params' => $params,
            ]]);
        return json_decode((string)$response->getBody());
    }

}
