<?php

namespace HistoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uservin", type="string", length=20, unique=true)
     *
     * @Assert\NotBlank(message="Please enter your vin.", groups={"Registration", "Profile"})
     *
     */
    private $uservin;


    public function __construct()
    {
        parent::__construct();
    }


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
     * @return string
     */
    public function getUservin()
    {
        return $this->uservin;
    }

    /**
     * @param string $uservin
     */
    public function setUservin($uservin)
    {
        $this->uservin = $uservin;
    }

}

