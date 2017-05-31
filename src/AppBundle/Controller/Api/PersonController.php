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
    public function getPeopleAction()
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

    public function getPersonAction($id)
    {
        $person = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Person::class)
            ->find($id)
        ;

        if (!$person) {
            $this->createNotFoundException('User not found');
        }

        $person = ['person' => $person];

        $view = $this
            ->view($person, Response::HTTP_OK)
            ->setTemplate("AppBundle:People:person.twig.html")
            ->setTemplateVar('person')
        ;

        return $this->handleView($view);
    }
}
