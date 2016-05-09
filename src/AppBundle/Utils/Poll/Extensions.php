<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Extensions extends Poll
{
    public $nodeTypes = array(
        'blog',
        'ccrm-case-study',
        'community-highlight',
        'feature',
        'homepage-slide',
        'homepage-stat',
        'advisory',
        'webform',
        'working-group',
    );

    public function query()
    {
        $this->results = $this->source->fetch('content/extension', $this->startDate, $this->endDate);
    }

    public function transform($result, $task)
    {
        $task->setSubtype($result->type);
        $task->setExternalId($result->nid);
        $task->setDescription($result->title);
        $task->setDate($this->createDate($result->date));
        $task->setUrl($result->url);
        $task->setContributorId($result->contact_id);
        $task->setContributorIdType('contact_id');
        $task->setValue(100);
    }
}
