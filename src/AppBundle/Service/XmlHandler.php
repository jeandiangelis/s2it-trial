<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

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
     * PeopleXmlHandler constructor.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $filePath
     */
    abstract function handle(string $filePath);

    /**
     * @param string $xml
     * @return array
     */
    protected function xmlToArray(string $xml)
    {
        return (array) simplexml_load_string($xml);
    }
}
