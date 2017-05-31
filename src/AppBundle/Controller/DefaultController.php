<?php

namespace AppBundle\Controller;

use AppBundle\Form\UploadForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Exception\Exception;

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

            try {
                $this
                    ->get('appbundle.people.handler')
                    ->handle($this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $peopleFileName);

                $this
                    ->get('appbundle.order.handler')
                    ->handle($this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $ordersFileName);

                $message = 'XML successfully processed';
            } catch (FileNotFoundException $exception) {
                $message = 'File not found';
            } catch (Exception $exception) {
                $message = 'Something went wrong';
            } finally {
                //@todo add message to flashbag
            }
        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'form' => $form->createView()
        ]);
    }
}
