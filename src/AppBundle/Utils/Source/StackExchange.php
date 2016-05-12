<?php

namespace AppBundle\Utils\Source;
use AppBundle\Utils\Source;
use GuzzleHttp\Client;

class StackExchange extends Source
{
    
    // public $dateFormat = 'Y-m-d\TH:i:s';
    
    function __construct($base_uri){
        $this->client = new Client(['base_uri' => $base_uri]);
    }

    function fetch($api, $start, $end){
        $response = $this->client->request('GET', $api, ['query' => ['since' => $start->format($this->dateFormat), 'until' => $end->format($this->dateFormat)]]);
        return json_decode((string)$response->getBody());
    }
    
    
}
