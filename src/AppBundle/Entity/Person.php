<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonRepository")
 */
class Person
{
    /**
     * @var int
     *
     * @ORM\Column(name="personid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $personid;

    /**
     * @var string
     *
     * @ORM\Column(name="personname", type="string")
     */
    private $personname;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person")
     */
    private $phones;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @param ArrayCollection $phones
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
    }

    /**
     * Set personid
     *
     * @param integer $personid
     * @return Person
     */
    public function setPersonid($personid)
    {
        $this->personid = $personid;

        return $this;
    }

    /**
     * Get personid
     *
     * @return integer 
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * @return string
     */
    public function getPersonname()
    {
        return $this->personname;
    }

    /**
     * @param string $personname
     */
    public function setPersonname($personname)
    {
        $this->personname = $personname;
    }
}
