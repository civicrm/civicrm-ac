<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class ExtensionReleases extends Poll
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
        $this->results = $this->source->fetch('content/extension_release_cms+extension_release_civicrm', $this->startDate, $this->endDate);
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
        $task->setValue(20);
    }
}
