<?php

namespace BastSys\UtilsBundle\Entity\Expirable;

/**
 * Interface IExpirable
 * @package BastSys\UtilsBundle\Entity\Expirable
 * @author mirkl
 */
interface IExpirable
{
    /**
     * @return bool
     */
    public function hasExpired(): bool;

    /**
     * @return \DateTime|null
     */
    public function getExpiration(): ?\DateTime;
}
