<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 09/04/16
 * Time: 16:34
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Source;
use Doctrine\ORM\EntityManager;

class SourcesManager extends AbstractManager
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityClass = Source::class;

        parent::__construct($entityManager);
    }

    /**
     * @param Source $source
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function convert($source)
    {
        if (! $source instanceof $this->entityClass) {
            throw new \Exception("Object must be instance of " . $this->entityClass);
        }

        return array(
            'id'        => $source->getId(),
            'name'      => $source->getName(),
            'host'      => null === $source->getHost() ? '' : $source->getHost(),
            'slug'      => $source->getSlug(),
            'type_id'   => $source->getType()->getId(),
            'type_name' => $source->getType()->getName(),
        );
    }
} 