<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Content extends Poll
{
    public $name = 'content';

    public function query()
    {
        var_dump($this->source);
    }

    public function transform($result)
    {
        $task = $this->initTask();
        $task->setExternalId($result['sha']);
        $task->setUrl($result['html_url']);
        $task->setDescription($result['commit']['message']);
        $task->setContributorExternalId($result['commit']['committer']['email']);
        $task->setDate($this->createDate($result['commit']['committer']['date']));
        $task->setContributorExternalIdType('email');
        $task->setDescription($result['commit']['message']);
        $task->setValue($this->getValue($result));

        return $task;
    }
    
    function getValue($result = null){
        return 1;
    }
}
