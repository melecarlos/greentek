<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quotation
 *
 * @ORM\Table(name="quotation", indexes={@ORM\Index(name="fk_quotation_member1_idx", columns={"member"})})
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity
 */
class Quotation
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
     * @var float
     *
     * @ORM\Column(name="kWh", type="float", precision=10, scale=0, nullable=false)
     */
    private $kwh;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage", type="float", precision=10, scale=0, nullable=false)
     */
    private $percentage;

    /**
     * @var float
     *
     * @ORM\Column(name="KWp", type="float", precision=10, scale=0, nullable=true)
     */
    private $kwp;

    /**
     * @var string
     *
     * @ORM\Column(name="installation", type="string", nullable=true)
     */
    private $installation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \Member
     *
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="quotations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="member", referencedColumnName="id")
     * })
     */
    private $member;



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
     * Set kwh
     *
     * @param float $kwh
     *
     * @return Quotation
     */
    public function setKwh($kwh)
    {
        $this->kwh = $kwh;

        return $this;
    }

    /**
     * Get kwh
     *
     * @return float
     */
    public function getKwh()
    {
        return $this->kwh;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     *
     * @return Quotation
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set kwp
     *
     * @param float $kwp
     *
     * @return Quotation
     */
    public function setKwp($kwp)
    {
        $this->kwp = $kwp;

        return $this;
    }

    /**
     * Get kwp
     *
     * @return float
     */
    public function getKwp()
    {
        return $this->kwp;
    }

    /**
     * Set installation
     * @param string $installation
     * @return Quotation
     */
    public function setInstallation($installation)
    {
        $this->installation = $installation;
        return $this;
    }

    /**
     * Get installation
     * @return string
     */
    public function getInstallation()
    {
        return $this->installation;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Quotation
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
     * Set member
     *
     * @param \AppBundle\Entity\Member $member
     *
     * @return Quotation
     */
    public function setMember(\AppBundle\Entity\Member $member = null)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * Get member
     *
     * @return \AppBundle\Entity\Member
     */
    public function getMember()
    {
        return $this->member;
    }
}
