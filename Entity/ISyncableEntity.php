<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity;

use BastSys\UtilsBundle\Entity\Identification\IDynamicallyIdentifiableEntity;
use BastSys\UtilsBundle\Model\ICopyable;

/**
 * Interface ISyncableEntity
 * @package BastSys\UtilsBundle\Entity
 * @author mirkl
 */
interface ISyncableEntity extends IDynamicallyIdentifiableEntity, ICopyable
{
    /**
     * @return mixed
     */
    public function __toString();
}
