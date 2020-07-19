<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Repository\SyncRepository;

use BastSys\UtilsBundle\Entity\ISyncableEntity;

/**
 * Interface ISyncRepository
 * @package BastSys\UtilsBundle\Repository\SyncRepository
 * @author mirkl
 */
interface ISyncRepository
{
    /**
     * Synchronizes given entities with the database.
     * New entities are created.
     * Changed entities are updated.
     * Non-included entities are deleted.
     *
     * @param ISyncableEntity[] $entities
     *
     * @return void
     */
    public function syncEntitites(array $entities): void;
}
