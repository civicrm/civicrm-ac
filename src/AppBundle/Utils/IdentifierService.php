<?php

namespace AppBundle\Utils;

class IdentifierService
{
    public function __construct($source, $em, $contributorService)
    {
        $this->source = $source;
        $this->em = $em;
        $this->contributorService = $contributorService;
    }

    public function lookupContributor($identifier)
    {        
        if($identifier->getType()->getName() == 'contact_id'){
            $contributor = $this->em->getRepository('AppBundle:Contributor')->findOneByContactId($identifier->getString());
            if(!$contributor){
                $contributor = $this->contributorService->create($identifier->getString());
            }
            if($contributor){
                $identifier->setContributor($contributor);
                $this->em->persist($identifier);
            }
        }else{
            switch ($identifier->getType()->getName()){
                case 'email':
                    $emails = $this->source->fetch('email', array('email' => $identifier->getString()));
                    foreach($emails->values as $email){
                        if(isset($email->contact_id)){
                            $contactIds[] = $email->contact_id;
                        }
                    }
                    if(isset($contactIds)){
                        $contact_id = min($contactIds);
                    }
                    break;
                default:
                    throw new Exception("No method implemented to identify identifiers of type '{$identifier->getType()->getName()}'");
                    break;
            }
            if(isset($contact_id)){
                $contributor = $this->em->getRepository('AppBundle:Contributor')->findOneByContactId($contact_id);
                if(!$contributor){
                    $contributor = $this->contributorService->create($contact_id);
                }
                if($contributor){
                    $identifier->setContributor($contributor);
                    $this->em->persist($identifier);
                }
            }
        }
    }
}
