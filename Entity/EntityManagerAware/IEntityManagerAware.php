<?php

namespace BastSys\UtilsBundle\Entity\EntityManagerAware;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Interface IEntityManagerAware
 * @package BastSys\UtilsBundle\Entity\EntityManagerAware
 * @author mirkl
 */
interface IEntityManagerAware
{
    /**
     * @param LifecycleEventArgs $event
     */
    public function injectEntityManager(EntityManagerInterface $event): void;
}
