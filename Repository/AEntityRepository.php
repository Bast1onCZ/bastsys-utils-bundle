<?php

namespace BastSys\UtilsBundle\Repository;

use BastSys\UtilsBundle\Exception\Entity\EntityNotFoundByIdException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AEntityRepository
 * @package BastSys\UtilsBundle\Repository
 * @author  mirkl
 */
abstract class AEntityRepository implements IEntityRepository
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * AEntityRepository constructor.
     * @param string $entityClass
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(string $entityClass, EntityManagerInterface $entityManager = null)
    {
        $this->entityClass = $entityClass;
        if($entityManager) {
            $this->setEntityManager($entityManager);
        }
    }

    /**
     * @internal injects entity manager
     * @required
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository($this->entityClass);
    }

    /**
     * @return string
     */
    public function getEntityClass(): string {
        return $this->entityClass;
    }

    /**
     * Finds one entity by its id
     *
     * @param string $id
     * @param bool $notFoundError
     *
     * @return object|null
     * @throws EntityNotFoundByIdException thrown only when $notFoundError set
     */
    public function findById(string $id, bool $notFoundError = false): ?object
    {
        $entity = $this->repository->findOneBy([
            'id' => $id,
        ]);

        if($notFoundError && !$entity) {
            throw new EntityNotFoundByIdException($this->entityClass, $id);
        }

        return $entity;
    }

    /**
     * Finds all entities
     *
     * @return object[]
     */
    public function findAll(): array {
        return $this->repository->findAll();
    }

    /**
     * @param array $ids
     *
     * @return array
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function findAllById(array $ids): array {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from($this->entityClass, 'e')
            ->addCriteria(
                Criteria::create()->where(Criteria::expr()->in('id', $ids))
            );

        return $qb->getQuery()->getResult();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return ObjectRepository
     */
    public function getObjectRepository(): ObjectRepository {
        return $this->repository;
    }
}
