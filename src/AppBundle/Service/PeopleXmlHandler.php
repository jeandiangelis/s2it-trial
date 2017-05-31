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

            $content = $this->xmlToArrayRecursive($peopleXml);

            foreach ($content['person'] as $person) {
                /** @var Person $personEntity */
                $personEntity = $this->serializer->deserialize(json_encode($person), Person::class, 'json');

                $phones = new ArrayCollection();

                if (is_array($person['phones']['phone'])) {
                    foreach ($person['phones']['phone'] as $phone) {
                        $phones->add(new Phone($phone));
                    }
                } else {
                    $phones->add(new Phone($person['phones']['phone']));
                }

                $personEntity->setPhones($phones);

                $this->entityManager->persist($personEntity);
            }

            $this->entityManager->flush();
        }

        throw new FileNotFoundException();
    }
}
