<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShipOrder
 *
 * @ORM\Table(name="shiporder")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShipOrderRepository")
 */
class ShipOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="orderid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $orderid;

    /**
     * @var Person
     *
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="orderperson", referencedColumnName="personid")
     */
    private $orderperson;

    /**
     * @var ShipDestination
     *
     * @ORM\OneToOne(targetEntity="ShipDestination", cascade={"merge"})
     * @ORM\JoinColumn(name="shipto", referencedColumnName="id")
     */
    private $shipto;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Item", mappedBy="shiporder", cascade={"merge"})
     */
    private $items;

    /**
     * ShipOrder constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getOrderid()
    {
        return $this->orderid;
    }

    /**
     * @param int $orderid
     */
    public function setOrderid($orderid)
    {
        $this->orderid = $orderid;
    }

    /**
     * @return Person
     */
    public function getOrderperson()
    {
        return $this->orderperson;
    }

    /**
     * @param Person $orderperson
     */
    public function setOrderperson($orderperson)
    {
        $this->orderperson = $orderperson;
    }

    /**
     * @return ShipDestination
     */
    public function getShipto()
    {
        return $this->shipto;
    }

    /**
     * @param ShipDestination $shipto
     */
    public function setShipto($shipto)
    {
        $this->shipto = $shipto;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param ArrayCollection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
}
