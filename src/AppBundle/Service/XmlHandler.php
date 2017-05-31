<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;

/**
 * Class XmlHandler
 */
abstract class XmlHandler
{
    /**
     * @var  EntityManager
     */
    protected $entityManager;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * PeopleXmlHandler constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, Serializer $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @param string $filePath
     */
    abstract function handle(string $filePath);

    /**
     * @param string $xml
     * @return array
     */
    protected function xmlToArrayRecursive(string $xml)
    {
        return json_decode(json_encode((array) simplexml_load_string($xml)), 1);
    }
}
