<?php

namespace AppBundle\Service;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class PeopleXmlHandler
 */
final class PeopleXmlHandler extends XmlHandler
{

    public function handle(string $filePath)
    {
        if (file_exists($filePath)) {
            $peopleXml = file_get_contents($filePath);

            $content = json_decode(json_encode((array) simplexml_load_string($peopleXml)), 1);

        }

        throw new FileNotFoundException();
    }
}
