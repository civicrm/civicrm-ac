<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Entity\IdentifierType;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
        ->setName('app:reset')
        ->setDescription('Initialises the active contributor database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        
        $command = $this->getApplication()->find('doctrine:schema:drop');
        $command->run(new ArrayInput(array( '--force'  => true, )), $output);        
        $command = $this->getApplication()->find('doctrine:schema:create');
        $command->run(new ArrayInput(array()), $output);        

        $this->io->text('Adding identifierTypes');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        
        $identifierTypes = array(
            'contact_id',
            'email',
            'stackexchange'
        );
        
        foreach($identifierTypes as $type){
            $identifierType = new IdentifierType;
            $identifierType->setName($type);
            $em->persist($identifierType);
        }
        $em->flush();
    }
}
