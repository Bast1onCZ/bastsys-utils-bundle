<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Exception\Entity;

use Throwable;

/**
 * Class EntityNotFoundByIdException
 * @package BastSys\UtilsBundle\Exception\Entity
 * @author mirkl
 */
class EntityNotFoundByIdException extends EntityNotFoundException
{
    /**
     * EntityNotFoundByIdException constructor.
     * @param string $entityClass
     * @param string $id
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $entityClass, string $id, $code = 404, Throwable $previous = null)
    {
        parent::__construct("Entity '$entityClass' with id '$id' was not found", $code, $previous);
    }
}
