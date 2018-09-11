<?php

namespace AppBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Member
 *
 * @ORM\Table(name="member")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Member
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
     * @ORM\Column(name="lastname", type="string", length=100, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="forename", type="string", length=100, nullable=false)
     */
    private $forename;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Email", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $emails;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Quotation", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $quotations;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $phones;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Company", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $companies;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="Message", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $messages;

    /**
     * @ORM\OneToOne(targetEntity="Login", mappedBy="member", cascade={"persist", "remove"})
     */
    protected $login;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->emails      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->quotations  = new \Doctrine\Common\Collections\ArrayCollection();
        $this->phones      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->companies   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messages    = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Member
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set forename
     *
     * @param string $forename
     *
     * @return Member
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * Get forename
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Member
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Member
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Member
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedDateValue()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param mixed $emails
     * @return Member
     */
    public function setEmails(\Doctrine\Common\Collections\Collection $emails)
    {
        $this->emails = $emails;
        foreach ($emails as $email) {
            $email->setMember($this);
        }
        return $this;
    }


    public function getQuotations()
    {
        return $this->quotations;
    }


    public function setQuotations(\Doctrine\Common\Collections\Collection $quotations)
    {
        $this->quotations = $quotations;
        foreach($quotations as $quotation){
            $quotation->setMember($this);
        }
        return $this;
    }


    public function getPhones()
    {
        return $this->phones;
    }

    public function setPhones(\Doctrine\Common\Collections\Collection $phones)
    {
        $this->phones = $phones;
        foreach($phones as $phone){
            $phone->setMember($this);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * @param mixed $companies
     * @return Member
     */
    public function setCompanies(\Doctrine\Common\Collections\Collection $companies)
    {
        $this->companies = $companies;
        foreach($companies as $company){
            $company->setMember($this);
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param mixed $messages
     * @return Member
     */
    public function setMessages(\Doctrine\Common\Collections\Collection $messages)
    {
        $this->messages = $messages;
        foreach($messages as $message){
            $message->setMember($this);
        }
        return $this;
    }

    public function clearMessages()
    {
        $this->getMessages()->clear();
    }


    public function setLogin(Login $login = null)
    {
        $this->login = $login;
        $login->setMember($this);

        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

}
