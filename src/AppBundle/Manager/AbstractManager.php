<?php
/**
 * Created by PhpStorm.
 * User: isow
 * Date: 09/04/16
 * Time: 16:35
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class AbstractManager
{
    protected $entityClass;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->entityClass);
    }

    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Finds all entities in the repository.
     *
     * @return array The entities.
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Finds entities by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    public function save($entity)
    {
        if (! $entity instanceof $this->entityClass) {
            var_dump($this->entityClass, $entity);die();
            return false;
        }

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush($entity);
        } catch (\Exception $e) {
            var_dump($e->getMessage());die();
            return false;
        }

        return true;
    }

    /**
     * @param $entity
     *
     * @return bool
     */
    public function delete($entity)
    {
        if (! $entity instanceof $this->entityClass) {
            var_dump($this->entityClass, $entity);die();
            return false;
        }

        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush($entity);
        } catch (\Exception $e) {
            var_dump($e->getMessage());die();
            return false;
        }

        return true;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}