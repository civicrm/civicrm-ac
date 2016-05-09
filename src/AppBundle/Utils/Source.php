<?php

namespace AppBundle\Utils;
use \Symfony\Component\DependencyInjection\ContainerAware;

class Source{
    
    function init(){
        if(!isset($this->dateFormat)){
            $this->dateFormat = \DateTime::ISO8601;
        } 
    }
}
