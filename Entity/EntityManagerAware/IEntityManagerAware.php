<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\EntityManagerAware;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface IEntityManagerAware
 * @package BastSys\UtilsBundle\Entity\EntityManagerAware
 * @author mirkl
 */
interface IEntityManagerAware
{
    /**
     * @param EntityManagerInterface $event
     */
    public function injectEntityManager(EntityManagerInterface $event): void;
}
