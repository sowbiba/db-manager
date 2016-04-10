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

} 