<?php

namespace BastSys\UtilsBundle\Repository\SyncRepository;

use BastSys\UtilsBundle\Entity\ISyncableEntity;
use BastSys\UtilsBundle\Exception\Entity\EntityNotFoundByIdException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Trait TSyncRepository
 * @package BastSys\UtilsBundle\Repository\SyncRepository
 * @author mirkl
 */
trait TSyncRepository
{
    /**
     * @param ISyncableEntity[] $syncEntities
     */
    public function syncEntitites(array $syncEntities): void {
        // validation
        foreach($syncEntities as $entity) {
            if(!$this->isValidEntity($entity)) {
                throw new \InvalidArgumentException('Invalid entity type supplied', 500);
            }
        }

        /** @var ISyncableEntity[] $prevEntities */
        $prevEntities = $this->findAll();
        $nextEntities = [];

        foreach($syncEntities as $syncEntity) {
            $entity = $this->prepareEntity($syncEntity->getId());
            $syncEntity->copyInto($entity);
            $nextEntities[] = $entity;
        }

        $deletedEntities = array_diff($prevEntities, $nextEntities);
        foreach($deletedEntities as $deletedEntity) {
            $this->getEntityManager()->remove($deletedEntity);
        }
    }

    /**
     * @param $entity
     * @return bool
     */
    private function isValidEntity($entity): bool {
        return $entity instanceof ISyncableEntity && get_class($entity) === $this->getEntityClass();
    }

    /**
     * @param string $id
     * @return ISyncableEntity
     */
    private function prepareEntity(string $id): ISyncableEntity {
        $entity = null;
        try {
            $entity = $this->findById($id, true);
        } catch (EntityNotFoundByIdException $ex) {
            $entityClass = $this->getEntityClass();
            /** @var ISyncableEntity $entity */
            $entity = new $entityClass();
            $entity->setId($id);
            $this->getEntityManager()->persist($entity);
        }

        return $entity;
    }

    /**
     * @return string
     */
    protected abstract function getEntityClass(): string;

    /**
     * @param string $id
     * @param bool $notFoundError
     * @return object|null
     * @throws EntityNotFoundByIdException
     */
    protected abstract function findById(string $id, bool $notFoundError = false): ?object;

    /**
     * @return object[]
     */
    protected abstract function findAll(): array;

    /**
     * @return EntityManagerInterface
     */
    public abstract function getEntityManager(): EntityManagerInterface;
}
