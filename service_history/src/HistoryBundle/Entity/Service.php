<?php

namespace HistoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HistoryBundle\Entity\Car;
use HistoryBundle\Entity\Part;
use HistoryBundle\Entity\Comment;
use HistoryBundle\Entity\User;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="HistoryBundle\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\ManyToOne(targetEntity="Car")
     */
    private $car;

    /**
     * @ORM\ManyToMany(targetEntity="Part", mappedBy="services")
     * @ORM\JoinTable(name="services_parts")
     */
    private $parts;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="service")
     */
    private $comments;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage", type="integer")
     */
    private $mileage;


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
     * Set description
     *
     * @param string $description
     *
     * @return Service
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
     * Set cost
     *
     * @param float $cost
     *
     * @return Service
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Service
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
     * Set mileage
     *
     * @param integer $mileage
     *
     * @return Service
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return int
     */
    public function getMileage()
    {
        return $this->mileage;
    }
}

