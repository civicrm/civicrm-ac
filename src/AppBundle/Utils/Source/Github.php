<?php

namespace AppBundle\Utils\Source;

use AppBundle\Utils\Source;
use Github\Client;
class Github extends Source
{
    function __construct($client, $resultPager, $username, $password=''){
        $client->authenticate($username, $password, Client::AUTH_HTTP_TOKEN);
        $this->client = $client;
        $this->resultPager = $resultPager;
    }
}
