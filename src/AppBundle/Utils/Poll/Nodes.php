<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Nodes extends Poll
{
    public $nodeTypes = array(
        'blog',
        'ccrm_case_study',
        'community_highlight',
        'feature',
        'homepage_slide',
        'homepage_stat',
        'advisory',
        'webform',
        'working_group',
    );

    public function query()
    {
        $this->results = $this->source->fetch('content/'.implode('+', $this->nodeTypes), $this->startDate, $this->endDate);
    }

    public function transform($result, $task)
    {
        $task->setSubtype($result->type);
        $task->setExternalIdentifier($result->nid);
        $task->setDescription($result->title);
        $task->setDate($this->createDate($result->date));
        $task->setUrl($result->url);
        $task->setIdentifierString($result->contact_id);
        $task->setIdentifierType('contact_id');
        $task->setValue(10);
    }
}
