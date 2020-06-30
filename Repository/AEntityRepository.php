<?php

namespace BastSys\UtilsBundle\Repository;

use App\ResourceBundle\Model\ListStructure\Input\AFilter;
use App\ResourceBundle\Model\ListStructure\Input\OrderBy;
use App\ResourceBundle\Model\ListStructure\Input\Pagination;
use App\ResourceBundle\Model\ListStructure\Output\ListResult;
use BastSys\UtilsBundle\Exception\Entity\EntityNotFoundByIdException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

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

    /**
     * @param Pagination $pagination
     * @param OrderBy|null $orderBy
     * @param null $filter
     *
     * @return ListResult
     */
    public function listEntities(Pagination $pagination, OrderBy $orderBy = null, $filter = null): ListResult
    {
        return new ListResult(
            $this->preparePaginator($pagination, $orderBy, $filter),
            $pagination
        );
    }

    /**
     * Prepares paginator for given parameters
     *
     * @param \App\ResourceBundle\Model\ListStructure\Input\Pagination $pagination
     * @param \App\ResourceBundle\Model\ListStructure\Input\OrderBy $orderBy
     * @param \App\ResourceBundle\Model\ListStructure\Input\AFilter|null $filter
     *
     * @return Paginator
     */
    protected function preparePaginator(
        Pagination $pagination,
        OrderBy $orderBy = null,
        AFilter $filter = null
    ): Paginator
    {
        $qb = $this->prepareListQueryBuilder($pagination, $orderBy, $filter);

        return new Paginator($qb);
    }

    /**
     * Prepares QueryBuilder to perform list query. Override this to applyOnEntity filter
     *
     * @param \App\ResourceBundle\Model\ListStructure\Input\Pagination $pagination
     * @param \App\ResourceBundle\Model\ListStructure\Input\OrderBy $orderBy
     * @param \App\ResourceBundle\Model\ListStructure\Input\AFilter $filter
     *
     * @return QueryBuilder
     */
    protected function prepareListQueryBuilder(
        Pagination $pagination,
        OrderBy $orderBy = null,
        AFilter $filter = null
    ): QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('e')
            ->from($this->entityClass, 'e')
            ->setFirstResult($pagination->getOffset())
            ->setMaxResults($pagination->getLimit());

        if($filter) {
            $filter->applyOnQueryBuilder($qb);
        }

        if ($orderBy) {
            while ($orderBy->valid()) {
                $pair = $orderBy->current();
                $qb->addOrderBy(
                    'e.' . $pair->getField(),
                    $pair->getDirection()
                );

                $orderBy->next();
            }
        }

        return $qb;
    }
}
