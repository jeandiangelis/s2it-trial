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
     * @return bool
     */
    abstract function handle(string $filePath);
}
