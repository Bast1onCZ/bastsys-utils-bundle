<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Identification;

/**
 * Interface IIdentifiableEntity
 * @author mirkl
 */
interface IIdentifiableEntity
{
    /**
     * @return string|int
     */
    public function getId();
}
