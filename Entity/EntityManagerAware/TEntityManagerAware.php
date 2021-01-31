<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\EntityManagerAware;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EntityManagerAware
 * @package BastSys\UtilsBundle\Entity
 * @author mirkl
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
trait TEntityManagerAware
{
    /**
     * @var EntityManagerInterface
     */
	protected EntityManagerInterface $entityManager;

    /**
     * @ORM\PrePersist()
     *
     * @param LifecycleEventArgs $event
     */
    public function entityManagerAwarePrePersist(LifecycleEventArgs $event): void {
        $this->injectEntityManager($event->getEntityManager());
    }

    /**
     * @ORM\PostLoad()
     *
     * @param LifecycleEventArgs $event
     */
    public function entityManagerAwarePostLoad(LifecycleEventArgs $event): void {
        $this->injectEntityManager($event->getEntityManager());
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function injectEntityManager(EntityManagerInterface $entityManager): void {
        $this->entityManager = $entityManager;
        $this->onInjectEntityManager($this->entityManager);
    }

    /**
     * Called right after an entity manager was injected.
     * Use this method to feed embeddables that need entity manager.
     *
     * @param EntityManagerInterface $entityManager
     */
    protected function onInjectEntityManager(EntityManagerInterface $entityManager): void
    {
    }
}
