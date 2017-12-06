<?php

namespace HistoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HistoryBundle\Entity\Car;
use HistoryBundle\Entity\Service;
use HistoryBundle\Entity\Comment;
use HistoryBundle\Entity\User;

/**
 * Parts
 *
 * @ORM\Table(name="part")
 * @ORM\Entity(repositoryClass="HistoryBundle\Repository\PartRepository")
 */
class Part
{
    /**
     * ORM\ManyToMany(targetEntity="Service", mappedBy="parts")
     */
    private $services;
    public function __construct()
    {
        $this->services = new ArrayCollection();
    }


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
     * @var float
     *
     * @ORM\Column(name="part_no", type="float")
     */
    private $partNo;


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
     * @return Part
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
     * Set partNo
     *
     * @param float $partNo
     *
     * @return Part
     */
    public function setPartNo($partNo)
    {
        $this->partNo = $partNo;

        return $this;
    }

    /**
     * Get partNo
     *
     * @return float
     */
    public function getPartNo()
    {
        return $this->partNo;
    }
}

