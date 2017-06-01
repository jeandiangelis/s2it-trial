<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Person;
use AppBundle\Entity\ShipOrder;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ShipOrderController
 */
class ShipOrderController extends FOSRestController
{
    /**
     * Returns a collection of orders not paginated
     *
     * @return Response
     * @ApiDoc(
     *     resource=true,
     *     description="Returns a collection of orders"
     * )
     */
    public function getOrdersAction()
    {
        $orders = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(ShipOrder::class)
            ->findAll()
        ;

        $orders = ['shiporders' => $orders];

        $view = $this
            ->view($orders, Response::HTTP_OK)
            ->setTemplate("AppBundle:Order:orders.twig.html")
            ->setTemplateVar('shiporders')
        ;

        return $this->handleView($view);
    }

    /**
     * Returns a ship order data, if the ship order id is not found a Not Found response is raised
     *
     * @return Response
     * @ApiDoc(
     *     resource=true,
     *     description="Returns a order data"
     * )
     */
    public function getOrderAction($id)
    {
        $order = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Person::class)
            ->find($id)
        ;

        if (!$order) {
            $this->createNotFoundException('Ship order not found');
        }

        $order = ['order' => $order];

        $view = $this
            ->view($order, Response::HTTP_OK)
            ->setTemplate("AppBundle:Order:order.twig.html")
            ->setTemplateVar('order')
        ;

        return $this->handleView($view);
    }
}
