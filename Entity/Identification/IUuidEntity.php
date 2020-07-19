<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Identification;

/**
 * Interface IUuidEntity
 * @package BastSys\UtilsBundle\Entity\Identification
 * @author mirkl
 */
interface IUuidEntity extends IIdentifiableEntity
{
    /**
     * @return string
     */
    public function getId(): string;
}
