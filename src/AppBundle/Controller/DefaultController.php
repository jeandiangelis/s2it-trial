<?php

namespace AppBundle\Controller;

use AppBundle\Form\UploadForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(UploadForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //@todo validate file extension
            $files = $form->getData();

            /** @var UploadedFile $peopleXml */
            $peopleXml = $files['people'];

            /** @var UploadedFile $ordersXml */
            $ordersXml = $files['order'];

            //@todo move to a proper place
            $peopleFileName = md5(uniqid()) . '.' . $peopleXml->guessExtension();
            $ordersFileName = md5(uniqid()) . '.' . $peopleXml->guessExtension();

            $peopleXml->move(
                $this->getParameter('uploads_dir'),
                $peopleFileName
            );

            $ordersXml->move(
                $this->getParameter('uploads_dir'),
                $ordersFileName
            );

            //@todo add success message to flashbag
        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'form' => $form->createView()
        ]);
    }
}
