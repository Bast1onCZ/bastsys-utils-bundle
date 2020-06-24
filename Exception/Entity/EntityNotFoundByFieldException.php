<?php

namespace BastSys\UtilsBundle\Exception\Entity;

use Throwable;

/**
 * Class EntityNotFoundByFieldException
 * @package BastSys\UtilsBundle\Exception\Entity
 * @author mirkl
 */
class EntityNotFoundByFieldException extends EntityNotFoundException
{
    /**
     * EntityNotFoundByFieldException constructor.
     * @param string $entityClass
     * @param string $fieldName
     * @param string $value
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $entityClass, string $fieldName, string $value, $code = 404, Throwable $previous = null)
    {
        parent::__construct("Entity '$entityClass' not found by field '$fieldName' using value '$value'", $code, $previous);
    }
}
