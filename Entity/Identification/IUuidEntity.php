<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Identification;

use BastSys\UtilsBundle\Model\IEquatable;

/**
 * Interface IUuidEntity
 * @package BastSys\UtilsBundle\Entity\Identification
 * @author mirkl
 */
interface IUuidEntity extends IIdentifiableEntity, IEquatable
{
    /**
     * @return string
     */
    public function getId(): string;
}
