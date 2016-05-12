<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Task
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="constraint", columns={"type", "external_identifier"})})
 * @ORM\Entity
 * @UniqueEntity(
 *   fields={"type", "externalIdentifier"},
 *   message="Combination of type and external id should be unique"
 * )
 **/
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
    * @ORM\Column(name="subtype", type="string", length=255, nullable=true)
     */
    private $subtype;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $externalIdentifier;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\NotNull()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="text")
     * @Assert\NotNull()
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotNull()
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="integer")
     * @Assert\NotNull()
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $IdentifierString;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     */
    private $IdentifierType;

    /**
     * @ORM\ManyToOne(targetEntity="Identifier", inversedBy="tasks")
     * @ORM\JoinColumn(name="identifier_id", referencedColumnName="id")
     */
    private $identifier;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Task
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set subtype
     *
     * @param string $subtype
     *
     * @return Task
     */
    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Get subtype
     *
     * @return string
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * Set externalIdentifier
     *
     * @param string $externalIdentifier
     *
     * @return Task
     */
    public function setExternalIdentifier($externalIdentifier)
    {
        $this->externalIdentifier = $externalIdentifier;

        return $this;
    }

    /**
     * Get externalIdentifier
     *
     * @return string
     */
    public function getExternalIdentifier()
    {
        return $this->externalIdentifier;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Task
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Task
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Task
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set identifierString
     *
     * @param string $identifierString
     *
     * @return Task
     */
    public function setIdentifierString($identifierString)
    {
        $this->IdentifierString = $identifierString;

        return $this;
    }

    /**
     * Get identifierString
     *
     * @return string
     */
    public function getIdentifierString()
    {
        return $this->IdentifierString;
    }

    /**
     * Set identifierType
     *
     * @param string $identifierType
     *
     * @return Task
     */
    public function setIdentifierType($identifierType)
    {
        $this->IdentifierType = $identifierType;

        return $this;
    }

    /**
     * Get identifierType
     *
     * @return string
     */
    public function getIdentifierType()
    {
        return $this->IdentifierType;
    }

    /**
     * Set identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     *
     * @return Task
     */
    public function setIdentifier(\AppBundle\Entity\Identifier $identifier = null)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return \AppBundle\Entity\Identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
