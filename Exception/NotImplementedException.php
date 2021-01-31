<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Exception;

use LogicException;
use Throwable;

/**
 * Class NotImplementedException
 * @package BastSys\UtilsBundle\Exception
 * @author mirkl
 */
class NotImplementedException extends LogicException
{
    /**
     * NotImplementedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'This piece of code was not implemented', $code = 501, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
