<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdentifierType
 *
 * @ORM\Table(name="identifier_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IdentifierTypeRepository")
 */
class IdentifierType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="Identifier", mappedBy="identifierType")
    */
    private $identifiers;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return IdentifierType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->identifiers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     *
     * @return IdentifierType
     */
    public function addIdentifier(\AppBundle\Entity\Identifier $identifier)
    {
        $this->identifiers[] = $identifier;

        return $this;
    }

    /**
     * Remove identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     */
    public function removeIdentifier(\AppBundle\Entity\Identifier $identifier)
    {
        $this->identifiers->removeElement($identifier);
    }

    /**
     * Get identifiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdentifiers()
    {
        return $this->identifiers;
    }
}
