<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Identification;

/**
 * Interface IDynamicallyIdentifiableEntity
 * @package BastSys\UtilsBundle\Entity\Identification
 * @author mirkl
 */
interface IDynamicallyIdentifiableEntity extends IIdentifiableEntity
{
    /**
     * @param string $id
     */
    public function setId(string $id): void;
}
