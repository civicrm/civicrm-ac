<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Task
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"type", "externalId"})})
 * @ORM\Entity
 * @UniqueEntity(
 *   fields={"type", "externalId"},
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
    * @ORM\Column(name="subtype", type="string", length=255)
     */
    private $subtype;

    /**
     * @var string
     *
     * @ORM\Column(name="externalId", type="string", length=255)
     * @Assert\NotNull()
     */
    private $externalId;

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
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     * @Assert\NotNull()
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="contributorExternalId", type="string", length=255)
     * @Assert\NotNull()
     */
    private $contributorExternalId;

    /**
     * @var string
     *
     * @ORM\Column(name="contributorExternalIdType", type="string", length=255)
     * @Assert\NotNull()
     */
    private $contributorExternalIdType;

    /**
     * @var string
     *
     * @ORM\Column(name="contactId", type="integer", nullable=true)
     */
    private $contactId;

    

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
     * Set externalID
     *
     * @param string $externalID
     * @return Task
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get externalID
     *
     * @return string 
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set url
     *
     * @param string $url
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
     * Set contributorExternalId
     *
     * @param string $contributorExternalId
     * @return Task
     */
    public function setContributorExternalId($contributorExternalId)
    {
        $this->contributorExternalId = $contributorExternalId;

        return $this;
    }

    /**
     * Get contributorExternalId
     *
     * @return string 
     */
    public function getContributorExternalId()
    {
        return $this->contributorExternalId;
    }

    /**
     * Set contributorExternalIdType
     *
     * @param string $contributorExternalIdType
     * @return Task
     */
    public function setContributorExternalIdType($contributorExternalIdType)
    {
        $this->contributorExternalIdType = $contributorExternalIdType;

        return $this;
    }

    /**
     * Get contributorExternalIdType
     *
     * @return string 
     */
    public function getContributorExternalIdType()
    {
        return $this->contributorExternalIdType;
    }

    /**
     * Set contactId
     *
     * @param string $contactId
     * @return Task
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId
     *
     * @return string 
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set type
     *
     * @param string $type
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
     * Set date
     *
     * @param \DateTime $date
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
}
