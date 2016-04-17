<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 09/04/16
 * Time: 16:34
 */

namespace AppBundle\Manager;


use AppBundle\Entity\Target;
use Doctrine\ORM\EntityManager;

class TargetsManager extends AbstractManager
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityClass = "\AppBundle\Entity\Target";

        parent::__construct($entityManager);
    }



    /**
     * @param Target $target
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function convert($target)
    {
        if (! $target instanceof $this->entityClass) {
            throw new \Exception("Object must be instance of " . $this->entityClass);
        }

        return array(
            'id'        => $target->getId(),
            'name'      => $target->getName(),
            'host'      => $target->getHost(),
            'slug'      => $target->getSlug(),
            'content'   => array()
        );
    }
} 