<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Exception\Entity;

use RuntimeException;
use Throwable;

/**
 * Class EntityNotFoundException
 * @package BastSys\UtilsBundle\Exception\Entity
 * @author mirkl
 */
class EntityNotFoundException extends RuntimeException
{
    /**
     * EntityNotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
