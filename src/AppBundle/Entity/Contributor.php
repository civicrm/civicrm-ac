<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Contributor
 *
 * @ORM\Table(name="contributor")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContributorRepository")
 */
class Contributor
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
     * @var int
     *
     * @ORM\Column(name="contact_id", type="integer")
     */
    private $contactId;
    
    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="contributor")
     */
    private $tasks;

    /**
    * @ORM\OneToMany(targetEntity="Identifier", mappedBy="contributor")
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
     * @return Contributor
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
     * Set contactId
     *
     * @param integer $contactId
     *
     * @return Contributor
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId
     *
     * @return int
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->identifiers = new ArrayCollection();
    }

    /**
     * Add task
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return Contributor
     */
    public function addTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task
     *
     * @param \AppBundle\Entity\Task $task
     */
    public function removeTask(\AppBundle\Entity\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Add identifier
     *
     * @param \AppBundle\Entity\Identifier $identifier
     *
     * @return Contributor
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
