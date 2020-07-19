<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\PersistAware;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TPersistAware
 * @package BastSys\UtilsBundle\Entity\PersistAware
 * @author mirkl
 *
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
trait TPersistAware
{
    private $isPersisted = false;

    /**
     * @return bool
     */
    public function isPersisted(): bool {
        return $this->isPersisted;
    }

    /**
     * @internal
     * @ORM\PostPersist()
     */
    public function persistAwarePostPersist() {
        $this->isPersisted = true;
    }

    /**
     * @internal
     * @ORM\PostLoad()
     */
    public function persistAwarePostLoad() {
        $this->isPersisted = true;
    }

    /**
     * @internal
     * @ORM\PostRemove()
     */
    public function persistAwarePostRemove() {
        $this->isPersisted = false;
    }
}
