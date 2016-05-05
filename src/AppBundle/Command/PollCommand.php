<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PollCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('app:poll')
        ->setDescription('Poll sources for tasks to record')
        ->addArgument(
            'poll',
            InputArgument::REQUIRED,
            'The poll that we want to run'
        )
        ->addOption(
            'from',
            'f',
            InputOption::VALUE_REQUIRED,
            'When should we poll from?',
            'yesterday'
        )
        ->addOption(
            'to',
            't',
            InputOption::VALUE_REQUIRED,
            'When should we poll to?',
            'today'
        )
        ->addOption(
            'delete',
            'd',
            InputOption::VALUE_NONE,
            'Delete tasks'
        )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('Poll for tasks');

        $this->name = $input->getArgument('poll');
        $service = "app.poll.{$this->name}";
        if ($this->getContainer()->has($service)) {
            $this->io->text("Using {$service} service.");
        } else {
            $this->io->error("No service has been defined for {$this->name}");

            return;
        }

        $this->startDate = new \DateTime($input->getOption('from'), new \DateTimeZone('UTC'));
        $this->endDate = new \DateTime($input->getOption('to'), new \DateTimeZone('UTC'));

        $this->poll = $this->getContainer()->get($service);
        if ($input->getOption('delete')) {
            $this->delete($input, $output);

            return;
        }

        $this->poll($input, $output);

        return;
    }

    protected function poll(InputInterface $input, OutputInterface $output)
    {
        $this->poll->startDate = $this->startDate;
        $this->poll->endDate = $this->endDate;

        $this->io->text("Querying for {$this->name} between {$input->getOption('from')} and {$input->getOption('to')} ...");

        $this->poll->query();
        $this->flushErrors();
        $countResults = count($this->poll->results);
        $this->io->text("Found {$countResults} {$this->name}.");

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $validator = $this->getContainer()->get('validator');

        // print_r($this->poll->results);exit;
        $count = 0;
        $this->io->text("Adding {$this->name}...");
        foreach ($this->poll->results as $result) {
            $task = $this->poll->transform($result);
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
        $this->io->text("{$count} {$this->name} added.");
    }

    protected function delete(InputInterface $input, OutputInterface $output)
    {
        $startDate = new \DateTime($input->getOption('from'));
        $endDate = new \DateTime($input->getOption('to'));

        $this->io->text("Deleting {$this->name} between {$input->getOption('from')} and {$input->getOption('to')} ...");

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery(
            'DELETE FROM AppBundle:Task t
            WHERE t.date >= :startDate
            AND t.date < :endDate')
        ->setParameter('startDate', $this->startDate)
        ->setParameter('endDate', $this->endDate);

        $this->io->text("{$query->getResult()} {$this->name} deleted.");
    }
    
    function flushErrors(){
        foreach ($this->poll->errors as $error){
            $this->io->error($error);
        }
        $this->poll->errors = array();
    }
}
