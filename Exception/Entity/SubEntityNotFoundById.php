<?php

namespace BastSys\UtilsBundle\Exception\Entity;

use BastSys\UtilsBundle\Entity\Identification\IIdentifiableEntity;
use Throwable;

/**
 * Class SubEntityNotFoundById
 * @package BastSys\UtilsBundle\Exception\Entity
 * @author mirkl
 */
class SubEntityNotFoundById extends EntityNotFoundException
{
    /**
     * SubEntityNotFoundById constructor.
     * @param IIdentifiableEntity $parentEntity
     * @param string $subEntityClass
     * @param string $subEntityId
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(IIdentifiableEntity $parentEntity, string $subEntityClass, string $subEntityId, $code = 404, Throwable $previous = null)
    {
        $parentEntityClass = get_class($parentEntity);
        $parentId = $parentEntity->getId();

        parent::__construct("Entity '$subEntityClass' with id '$subEntityId' was not found as a child of '$parentEntityClass' with id '$parentId'", $code, $previous);
    }
}
