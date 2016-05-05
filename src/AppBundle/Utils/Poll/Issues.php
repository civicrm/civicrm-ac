<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Issues extends Poll
{
    public $name = 'issues';

    public function query()
    {
        $orgApi = $this->source->client->api('organization');
        $parameters = array('civicrm');
        $repositories = $this->source->resultPager->fetchAll($orgApi, 'repositories', $parameters);
        $commitsApi = $this->source->client->api('repo')->commits();
        foreach ($repositories as $repository) {
            $parameters = array('civicrm', $repository['name'], array(
                'since' => $this->formatDate($this->startDate),
                'until' => $this->formatDate($this->endDate),
            ));
            try {
                $commits = $this->source->resultPager->fetchAll($commitsApi, 'all', $parameters);
                foreach ($commits as $commit) {
                    $this->results[] = $commit;
                }
            } catch (\Github\Exception\RuntimeException $e) {
                $this->errors[] = "{$repository['name']}: {$e->getMessage()}";
            }
        }
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
        $task->setValue($this->value);

        return $task;
    }
}
