<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Identifier
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="constraint", columns={"string", "type_id"})})
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
     * @ORM\Column(type="string", length=255)
     */
     private $string;

     /**
      * @var \DateTime
      *
      * @ORM\Column(type="datetime")
      */
     private $expiry;

    /**
    * @ORM\ManyToOne(targetEntity="Contributor", inversedBy="identifiers")
    */
    private $contributor;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="identifier")
     */
    private $tasks;

    /**
    * @ORM\ManyToOne(targetEntity="IdentifierType", inversedBy="identifiers")
    * @ORM\JoinColumn(nullable=false)
    */
    private $type;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->expiry = new \DateTime('+ 1 week');

    }

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
     * Set string
     *
     * @param string $string
     *
     * @return Identifier
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set expiry
     *
     * @param \DateTime $expiry
     *
     * @return Identifier
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * Get expiry
     *
     * @return \DateTime
     */
    public function getExpiry()
    {
        return $this->expiry;
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
     * Add task
     *
     * @param \AppBundle\Entity\Task $task
     *
     * @return Identifier
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
     * Set type
     *
     * @param \AppBundle\Entity\IdentifierType $type
     *
     * @return Identifier
     */
    public function setType(\AppBundle\Entity\IdentifierType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\IdentifierType
     */
    public function getType()
    {
        return $this->type;
    }
}
