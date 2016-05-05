<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Task;

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
    }
    
    public function initDates($startDate = null, $endDate = null, $dateFormat = null)
    {
        $this->startDate = $startDate ? $startDate : new \DateTime('yesterday', new \DateTimeZone('UTC'));
        $this->endDate = $endDate ? $endDate : new \DateTime('today', new \DateTimeZone('UTC'));
        $this->dateFormat = $dateFormat ? $dateFormat : \DateTime::ISO8601;
    }

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    public function getResults()
    {
        return $this->results;
    }

    function getValue($result = null){
        return 1;
    }


    public function formatDate($date)
    {
        return $date->format($this->dateFormat);
    }
    public function createDate($string)
    {
        return \DateTime::createFromFormat($this->dateFormat, $string);
    }

    protected function initTask()
    {
        $task = new Task();
        $task->setType($this->name);
        return $task;
    }
    

}
