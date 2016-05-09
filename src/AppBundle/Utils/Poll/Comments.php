<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Comments extends Poll
{
    public function query()
    {
        $this->results = $this->source->fetch('comments', $this->startDate, $this->endDate);
    }

    public function transform($result, $task)
    {
        $task->setExternalId($result->cid);
        $task->setDescription($result->text);
        $task->setDate($this->createDate($result->date));
        $task->setUrl($result->url);
        $task->setContributorId($result->contact_id);
        $task->setContributorIdType('contact_id');
        $task->setValue(1);
    }
}
