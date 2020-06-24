<?php

namespace BastSys\UtilsBundle\Model\Interval;

use InvalidArgumentException;

/**
 * Class Interval
 * @package BastSys\UtilsBundle\Model\Interval
 * @author  mirkl
 */
class Interval
{
	/**
	 * @param string $intervalStr
	 *
	 * @return Interval
	 */
	public static function fromString(string $intervalStr): Interval {
		$matches = [];
		preg_match('/^([(<])((?:\d+(?:\.\d+)?)|(?:min))[;,] ?((?:\d+(?:\.\d+)?)|(?:max))([)>])$/', $intervalStr, $matches);

		$minContained = $matches[1] === '<';
		$min = $matches[2] === 'min' ? PHP_INT_MIN : +$matches[2];
		$max = $matches[3] === 'max' ? PHP_INT_MAX : +$matches[3];
		$maxContained = $matches[4] === '>';

		return new Interval($min, $minContained, $max, $maxContained);
	}

	/** @var int|float */
	private $min;

	/** @var int|float */
	private $max;

	/** @var bool */
	private $minContained;

	/** @var bool */
	private $maxContained;

	/**
	 * Interval constructor.
	 *
	 * @param int|float $min
	 * @param int|float $max
	 */
	public function __construct($min = PHP_INT_MIN, bool $minContained = true, $max = PHP_INT_MAX, bool $maxContained = true)
	{
		if (!is_numeric($min) || !is_numeric($max)) {
			throw new InvalidArgumentException();
		}
		if($min > $max) {
			throw new InvalidArgumentException();
		}

		$this->min = +$min;
		$this->max = +$max;

		$this->minContained = $minContained;
		$this->maxContained = $maxContained;
	}

	/**
	 * @param int|float|Interval $value
	 *
	 * @return bool
	 */
	public function contains($value): bool
	{
		if(is_numeric($value)) {
			return ($this->minContained ? $this->min <= $value : $this->min < $value) &&
				($this->maxContained ? $value <= $this->max : $value < $this->max);
		}

		if($value instanceof Interval) {
			return $this->contains($value->minContained ? $value->min : $value->min + PHP_FLOAT_MIN) &&
				$this->contains($value->maxContained ? $value->max : $value->max - PHP_FLOAT_MIN);
		}

		throw new InvalidArgumentException();
	}

    /**
     * @param $value
     * @throws IntervalMissingValueException
     */
	public function checkContains($value): void {
        if(!$this->contains($value)) {
            throw new IntervalMissingValueException($this, $value);
        }
    }

	/**
	 * @return string
	 */
	public function __toString()
	{
		return ($this->minContained ? '<' : '(') .
			$this->min .
			';' .
			$this->max .
			($this->maxContained ? '>' : ')');
	}
}
