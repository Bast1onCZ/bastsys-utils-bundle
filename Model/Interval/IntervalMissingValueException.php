<?php

namespace BastSys\UtilsBundle\Model\Interval;

use Exception;

/**
 * Class IntervalMissingValueException
 * @package BastSys\UtilsBundle\Model\Interval
 * @author mirkl
 */
class IntervalMissingValueException extends Exception
{
    /**
     * IntervalMissingValueException constructor.
     * @param Interval $interval
     * @param Interval|float $value
     */
    public function __construct(Interval $interval, $value)
    {
        parent::__construct("Interval $interval is missing value ($value)");
    }
}
