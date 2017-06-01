<?php

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidFileFormatException;
use AppBundle\Form\UploadForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
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
            try {
                $files = $form->getData();

                /** @var UploadedFile $peopleXml */
                $peopleXml = $files['people'];

                /** @var UploadedFile $ordersXml */
                $ordersXml = $files['order'];

                $peopleFileName = md5(uniqid()) . '.' . $peopleXml->guessExtension();
                $ordersFileName = md5(uniqid()) . '.' . $ordersXml->guessExtension();

                if ($peopleXml->guessExtension() != 'xml'
                    || $ordersXml->guessExtension() != 'xml'
                ) {
                    throw new InvalidFileFormatException('The files must be XML');
                }

                $peopleXml->move(
                    $this->getParameter('uploads_dir'),
                    $peopleFileName
                );

                $ordersXml->move(
                    $this->getParameter('uploads_dir'),
                    $ordersFileName
                );

                $this
                    ->get('appbundle.people.handler')
                    ->handle($this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $peopleFileName);

                $this
                    ->get('appbundle.order.handler')
                    ->handle($this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $ordersFileName);

                $message = ['type' => 'success', 'content' => 'XML successfully processed'];
            } catch (InvalidFileFormatException $exception) {
                $message = ['type' => 'danger', 'content' => $exception->getMessage()];
            } catch (FileNotFoundException $exception) {
                $message = ['type' => 'danger', 'content' => $exception->getMessage()];
            } catch (\Exception $exception) {
                $message = ['type' => 'danger', 'content' => 'Something went wrong trying to process your XML, please check whether it is formatted correctly'];
            } finally {
                $this->get('session')->getFlashBag()->add($message['type'], $message['content']);
            }
        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'form' => $form->createView()
        ]);
    }
}
