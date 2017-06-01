<?php

namespace AppBundle\Service;

use AppBundle\Entity\Item;
use AppBundle\Entity\Person;
use AppBundle\Entity\ShipDestination;
use AppBundle\Entity\ShipOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class OrdersXmlHandler
 */
final class OrdersXmlHandler extends XmlHandler
{
    public function handle(string $filePath)
    {
        if (file_exists($filePath)) {
            $ordersXml = file_get_contents($filePath);

            $ordersXml = simplexml_load_string($ordersXml);

            foreach ($ordersXml->shiporder as $order) {
                $shipOrder = new ShipOrder();
                $shipOrder->setOrderid((string) $order->orderid);
                $person = $this
                    ->entityManager
                    ->getRepository(Person::class)
                    ->find((string) $order->orderperson);

                if (!$person) {
                    $person = new Person((string) $order->orderperson, '');
                }

                $shipOrder->setOrderperson($person);

                $shipTo = new ShipDestination();
                $shipTo->setAddress((string) $order->shipto->address);
                $shipTo->setCity((string) $order->shipto->city);
                $shipTo->setCountry((string) $order->shipto->country);
                $shipTo->setName((string) $order->shipto->name);

                $shipOrder->setShipto($shipTo);

                $items = new ArrayCollection();

                foreach ($order->items->item as $item) {
                    $itemEntity = new Item();
                    $itemEntity->setTitle((string) $item->title);
                    $itemEntity->setNote((string) $item->note);
                    $itemEntity->setQuantity((int) $item->quantity);
                    $itemEntity->setPrice((float) $item->price);
                    $itemEntity->setShiporder($shipOrder);

                    $items->add($itemEntity);
                }

                $shipOrder->setItems($items);

                $this->entityManager->merge($shipOrder);
            }

            $this->entityManager->flush();
        } else {
            throw new FileNotFoundException('File not found');
        }
    }
}
