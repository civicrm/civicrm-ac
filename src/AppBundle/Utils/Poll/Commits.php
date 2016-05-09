<?php

namespace AppBundle\Utils\Poll;

use AppBundle\Utils\Poll;

class Commits extends Poll
{
    public function query()
    {
        $orgApi = $this->source->client->api('organization');
        $parameters = array('civicrm');
        $repositories = $this->source->resultPager->fetchAll($orgApi, 'repositories', $parameters);
        $commitsApi = $this->source->client->api('repo')->commits();
        foreach ($repositories as $repository) {
            $parameters = array('civicrm', $repository['name'], array(
                'since' => $this->startDate->format($this->dateFormat),
                'until' => $this->endDate->format($this->dateFormat),
            ));
            try {
                $commits = $this->source->resultPager->fetchAll($commitsApi, 'all', $parameters);
                foreach ($commits as $commit) {
                    $this->results[] = array(
                        'repo' => $repository,
                        'commit' => $commit,
                    );
                }
            } catch (\Github\Exception\RuntimeException $e) {
                $this->errors[] = "{$repository['name']}: {$e->getMessage()}";
            }
        }
    }

    public function transform($result, $task)
    {
        $task->setExternalId($result['commit']['sha']);
        $task->setUrl($result['commit']['html_url']);
        $task->setDescription($result['commit']['commit']['message']);
        $task->setDate($this->createDate($result['commit']['commit']['committer']['date']));
        $task->setContributorId($result['commit']['commit']['committer']['email']);
        $task->setContributorIdType('email');
        $task->setDescription($result['commit']['commit']['message']);
        $task->setValue(2);
        $task->setSubtype($result['repo']['name']);
    }
}
