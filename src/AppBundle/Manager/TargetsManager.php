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
        $this->entityClass = Target::class;

        parent::__construct($entityManager);
    }

} 