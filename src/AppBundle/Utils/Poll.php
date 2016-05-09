<?php

namespace AppBundle\Utils;

abstract class Poll
{
    public $startDate;
    public $endDate;
    public $dateFormat;
    public $taskRepo;

    public $results = array();
    public $errors = array();

    public function __construct($source)
    {
        $this->source = $source;
        $this->dateFormat = $source->dateFormat;
    }
    
    abstract function query();

    abstract function transform($result, $task);

    public function init($startDate = null, $endDate = null, $dateFormat = null)
    {
        $this->startDate = $startDate ? $startDate : new \DateTime('yesterday', new \DateTimeZone('UTC'));
        $this->endDate = $endDate ? $endDate : new \DateTime('today', new \DateTimeZone('UTC'));
    }

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function getResults()
    {
        return $this->results;
    }

    public function createDate($string)
    {
        return \DateTime::createFromFormat($this->dateFormat, $string);
    }
}
