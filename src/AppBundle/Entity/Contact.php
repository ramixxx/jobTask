<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 */
class Contact
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(length=30)
     */
    private $firstName;

    /**
     * @ORM\Column(length=30)
     */
    private $lastName;

    /**
     * @ORM\Column(length=100)
     */
    private $streetAndNumber;

    /**
     * @ORM\Column(length=20)
     */
    private $zip;

    /**
     * @ORM\Column(length=40)
     */
    private $city;

    /**
     * @ORM\Column(length=40)
     */
    private $country;

    /**
     * @ORM\Column(length=100)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(length=40)
     */
    private $birthday;

    /**
     * @ORM\Column(length=50)
     */
    private $email;

    /**
     * @ORM\Column(length=255)
     */
    private $picture;

    /**
     * Get id
     *
     * @return Integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get firstName
     *
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstname)
    {
        $this->firstName = $firstname;
    }

    /**
     * Get lastName
     *
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastname)
    {
        $this->lastName = $lastname;
    }

     /**
     * Get streetAndNumber
     *
     * @return String
     */
    public function getStreetAndNumber()
    {
        return $this->streetAndNumber;
    }

    public function setStreetAndNumber($streetAndNumber)
    {
        $this->streetAndNumber = $streetAndNumber;
    }

     /**
     * Get zip
     *
     * @return String
     */
    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

     /**
     * Get city
     *
     * @return String
     */
    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

     /**
     * Get country
     *
     * @return String
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

     /**
     * Get phoneNumber
     *
     * @return String
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

     /**
     * Get birthday
     *
     * @return String
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

     /**
     * Get email
     *
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

     /**
     * Get picture
     *
     * @return String
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
 
}