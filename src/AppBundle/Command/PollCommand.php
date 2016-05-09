<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\Task;

class PollCommand extends ContainerAwareCommand
{
    const DATE_FORMAT = 'g:ia \o\n jS M Y';

    protected function configure()
    {
        $this
        ->setName('app:poll')
        ->setDescription('Poll sources for tasks to record')
        ->addArgument('poll', InputArgument::OPTIONAL, "Name of the poll that we want to run, or 'all' to run all defined polls.")
        ->addOption('from', 'f', InputOption::VALUE_REQUIRED, 'When should we poll from?', 'midnight 1 week ago')
        ->addOption('to', 't', InputOption::VALUE_REQUIRED, 'When should we poll to?', 'midnight today')
        ->addOption('list', 'l', InputOption::VALUE_NONE, 'List all polls')
        ->addOption('delete', 'd', InputOption::VALUE_NONE, 'Delete tasks');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Poll for tasks');
        if ($input->getOption('list')) {
            $this->listPolls();
            return;
        }
        if(!$this->name = $input->getArgument('poll')){
            $this->io->error("No poll defined");
            $this->io->block("Please include a poll from the list below or type 'all' to run all polls.");
            $this->listPolls();
            return;
        };

        $this->startDate = new \DateTime($input->getOption('from'), new \DateTimeZone('UTC'));
        $this->endDate = new \DateTime($input->getOption('to'), new \DateTimeZone('UTC'));

        //Run all polls if requested
        if ($this->name == 'all') {
            $this->io->text('Running ALL polls.');
            foreach($this->getAllPolls() as $poll){
                $this->name = $poll;
                $this->poll = $this->getContainer()->get('poll.'.$poll);
                $this->poll($input, $output);
            }
            return;
        }

        //Else run a specific poll
        $service = "poll.{$this->name}";
        if ($this->getContainer()->has($service)) {
            $this->poll = $this->getContainer()->get($service);
            $this->poll($input, $output);
        } else {
            $this->io->error("No service has been defined for {$this->name}");
        }
    }
    
    protected function listPolls(){
        $this->io->text('Available polls:');
        $this->io->listing($this->getAllPolls());
    }
    
    protected function getAllPolls(){
        foreach ($this->getContainer()->getServiceIds() as $service) {
            if (substr($service, 0, 5) === 'poll.') {
                $polls[]=substr($service, 5);
            }
        }
        return $polls;
    }
    
    
    protected function poll(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('delete')) {
            $this->delete($input, $output);

            return;
        }

        $this->poll->startDate = $this->startDate;
        $this->poll->endDate = $this->endDate;

        $this->io->text("Running poll for {$this->name}.");
        $this->io->text(" * Polling between {$this->startDate->format(self::DATE_FORMAT)} and {$this->endDate->format(self::DATE_FORMAT)}.");

        $this->poll->query();
        $this->flushErrors();
        $countResults = count($this->poll->results);
        $this->io->text(" * Found {$countResults} {$this->name}");

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $validator = $this->getContainer()->get('validator');

        // print_r($this->poll->results);exit;
        $count = 0;
        $this->io->text(" * Adding {$this->name}");
        foreach ($this->poll->results as $result) {
            $task = new Task();
            $task->setType($this->name);
            $this->poll->transform($result, $task);
            $errors = $validator->validate($task);
            if ($errors->count()) {
                $this->io->note("Task with id {$task->getExternalId()} ({$task->getUrl()}) already exists in database."); // TODO: we might be masking other errors here
            } else {
                ++$count;
                $em->persist($task);
                if (($count % 100) === 0) {
                    $em->flush();
                    $em->clear();
                }
            }
        }
        $em->flush();
        $em->clear();
        $this->io->text(" * {$count} {$this->name} added.");
    }

    protected function delete(InputInterface $input, OutputInterface $output)
    {
        $startDate = new \DateTime($input->getOption('from'));
        $endDate = new \DateTime($input->getOption('to'));

        $this->io->text("Deleting {$this->name} between {$this->startDate->format(self::DATE_FORMAT)} and {$this->endDate->format(self::DATE_FORMAT)}.");

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery(
            'DELETE FROM AppBundle:Task t
            WHERE t.type = :name
            AND t.date >= :startDate
            AND t.date < :endDate')
        ->setParameter('startDate', $this->startDate)
        ->setParameter('endDate', $this->endDate)
        ->setParameter('name', $this->name);

        $this->io->text(" * {$query->getResult()} {$this->name} deleted.");
    }

    public function flushErrors()
    {
        foreach ($this->poll->errors as $error) {
            $this->io->error($error);
        }
        $this->poll->errors = array();
    }
}
