<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Roles extends Role
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Login", mappedBy="role")
     */
    private $login;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->login = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getRole()
    {
        return $this->getName();
    }

    public function __toString()
    {
        return $this->getRole();
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
     * Set name
     *
     * @param string $name
     *
     * @return Role
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
     * Set description
     *
     * @param string $description
     *
     * @return Role
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
     * Add login
     *
     * @param \AppBundle\Entity\Login $login
     *
     * @return Role
     */
    public function addLogin(\AppBundle\Entity\Login $login)
    {
        $this->login[] = $login;

        return $this;
    }

    /**
     * Remove login
     *
     * @param \AppBundle\Entity\Login $login
     */
    public function removeLogin(\AppBundle\Entity\Login $login)
    {
        $this->login->removeElement($login);
    }

    /**
     * Get login
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogin()
    {
        return $this->login;
    }
}
