<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Exception\Entity;

use Throwable;

/**
 * Class EntityException
 * @package BastSys\UtilsBundle\Exception\Entity
 * @author mirkl
 */
class EntityException extends \Exception
{
    /**
     * EntityException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
