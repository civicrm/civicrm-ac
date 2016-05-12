<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class StackExchange extends Poll
{
    public function query()
    {
    }

    public function transform($result)
    {
        $task = $this->initTask();

        return $task;
    }
}
