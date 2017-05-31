<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Person;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonController
 */
class PersonController extends FOSRestController
{
    /**
     * Returns a collection of people not paginated
     *
     * @return Response
     * @ApiDoc(
     *     resource=true,
     *     description="Returns a collection of people"
     * )
     */
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

    /**
     * Returns a person data, if the person id is not found a Not Found response is raised
     *
     * @return Response
     * @ApiDoc(
     *     resource=true,
     *     description="Returns a person data"
     * )
     */
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
