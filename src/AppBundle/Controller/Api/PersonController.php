<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Person;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonController
 */
class PersonController extends FOSRestController
{
    public function getPersonAction()
    {
        $people = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Person::class)
            ->findAll()
        ;

        $people = ['people' => $people];

        $view = $this
            ->view($people, Response::HTTP_OK)
            ->setTemplate("AppBundle:People:people.twig.html")
            ->setTemplateVar('people')
        ;

        return $this->handleView($view);
    }
}
