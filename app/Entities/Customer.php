<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * User constructor.
     * @param $name
     * @param $email
     * @param $password
     */
    public function __construct($first_name, $last_name, $email, $username, $password, $gender, $country, $city, $phone)
    {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->gender = $gender;
        $this->country = $country;
        $this->city = $city;
        $this->phone = $phone;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $first_name;

    /**
     * @ORM\Column(type="string")
     */
    private $last_name;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string")
     */
    private $gender;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $phone;

    public function getID()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }
    
    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}