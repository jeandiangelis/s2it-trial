<?php

namespace AppBundle\Service;

use AppBundle\Entity\Person;
use AppBundle\Entity\Phone;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class PeopleXmlHandler
 */
final class PeopleXmlHandler extends XmlHandler
{
    /**
     * @param string $filePath
     */
    public function handle(string $filePath)
    {
        if (file_exists($filePath)) {
            $peopleXml = file_get_contents($filePath);

            $content = current($this->xmlToArray($peopleXml));

            foreach ($content as $person) {
                $personEntity = new Person($person->personid, $person->personname);

                $phones = new ArrayCollection();

                if (count($person->phones->phone) > 1) {
                    foreach ($person->phones->phone as $phone) {
                        $phones->add(new Phone((string) $phone));
                    }
                } else {
                    $phones->add(new Phone((string) $person->phones->phone));
                }

                $personEntity->setPhones($phones);

                $this->entityManager->merge($personEntity);
            }

            $this->entityManager->flush();
        } else {
            throw new FileNotFoundException();
        }
    }
}
