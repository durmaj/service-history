<?php

namespace HistoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HistoryBundle\Entity\User;
use HistoryBundle\Entity\Service;
use HistoryBundle\Entity\Part;
use HistoryBundle\Entity\Comment;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="HistoryBundle\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;


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
     * @ORM\Column(name="vin", type="string", length=20, unique=true)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="reg_plate", type="string", length=10, unique=true)
     */
    private $regPlate;


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
     * Set vIN
     *
     * @param string $vin
     *
     * @return Car
     */
    public function setVIN($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVIN()
    {
        return $this->vin;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Car
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set regPlate
     *
     * @param string $regPlate
     *
     * @return Car
     */
    public function setRegPlate($regPlate)
    {
        $this->regPlate = $regPlate;

        return $this;
    }

    /**
     * Get regPlate
     *
     * @return string
     */
    public function getRegPlate()
    {
        return $this->regPlate;
    }

    /**
     * Set user
     *
     * @param \HistoryBundle\Entity\User $user
     *
     * @return Car
     */
    public function setUser(\HistoryBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HistoryBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->getModel();
    }

}
