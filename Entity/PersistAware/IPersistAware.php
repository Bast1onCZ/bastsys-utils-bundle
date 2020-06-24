<?php

namespace BastSys\UtilsBundle\Entity\PersistAware;

/**
 * Interface IPersistAware
 * @package BastSys\UtilsBundle\Entity\PersistAware
 * @author mirkl
 */
interface IPersistAware
{
    /**
     * @return bool
     */
    public function isPersisted(): bool;
}
