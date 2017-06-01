<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Person;
use AppBundle\Entity\Phone;
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

    /**
     * Returns all phones of a person based on this person ID
     *
     * @ApiDoc(
     *     resource=true,
     *     description="Returns all phones of a person"
     * )
     * @param $id
     * @return Response
     */
    public function getPersonPhonesAction($id)
    {
        $manager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $person = $manager
            ->getRepository(Person::class)
            ->find($id)
        ;

        if (!$person) {
            $this->createNotFoundException('User not found');
        }

        $phones = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Phone::class)
            ->findBy(['person' => $person])
        ;

        $phones = ['phones' => $phones];

        $view = $this
            ->view($phones, Response::HTTP_OK)
            ->setTemplate("AppBundle:People:phones.twig.html")
            ->setTemplateVar('$phones')
        ;

        return $this->handleView($view);
    }
}
