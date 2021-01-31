<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Expirable;

use DateTime;

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
     * @return DateTime|null
     */
    public function getExpiration(): ?DateTime;
}
