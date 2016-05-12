<?php

namespace AppBundle\Utils;
use AppBundle\Entity\Contributor;

class ContributorService
{
    public function __construct($source, $em)
    {
        $this->source = $source;
        $this->em = $em;
    }

    public function create($contact_id)
    {
        $contact = $this->source->fetchOne('contact', array('id' => $contact_id, 'is_deleted' => 0));
        if($contact){
            $contributor = new Contributor;
            $contributor->setContactId($contact->id);
            $contributor->setName($contact->display_name);
            $this->em->persist($contributor);
            $this->em->flush();
            return $contributor;
        }
    }
}
