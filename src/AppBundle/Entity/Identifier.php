<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Identifier
 *
 * @ORM\Table(name="identifier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IdentifierRepository")
 */
class Identifier
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
     * @ORM\Column(name="identifier", type="string", length=255)
     */
    private $identifier;

    /**
    * @ORM\ManyToOne(targetEntity="Contributor", inversedBy="identifiers")
    * @ORM\JoinColumn(nullable=false)
    */
    private $contributor;

    /**
    * @ORM\ManyToOne(targetEntity="IdentifierType", inversedBy="identifiers")
    * @ORM\JoinColumn(nullable=false)
    */
    private $identifierType;

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
     * Set contributor
     *
     * @param \AppBundle\Entity\Contributor $contributor
     *
     * @return Identifier
     */
    public function setContributor(\AppBundle\Entity\Contributor $contributor = null)
    {
        $this->contributor = $contributor;

        return $this;
    }

    /**
     * Get contributor
     *
     * @return \AppBundle\Entity\Contributor
     */
    public function getContributor()
    {
        return $this->contributor;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set identifierType
     *
     * @param \AppBundle\Entity\IdentifierType $identifierType
     *
     * @return Identifier
     */
    public function setidentifierType(\AppBundle\Entity\IdentifierType $identifierType = null)
    {
        $this->identifierType = $identifierType;

        return $this;
    }

    /**
     * Get identifierType
     *
     * @return \AppBundle\Entity\IdentifierType
     */
    public function getidentifierType()
    {
        return $this->identifierType;
    }
}
