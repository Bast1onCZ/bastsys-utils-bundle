<?php

namespace BastSys\UtilsBundle\Model;

/**
 * Interface IComparable
 * @package BastSys\UtilsBundle\Model
 * @author  mirkl
 */
interface IComparable
{
	/**
	 * Can be compared to the same instance.
	 *
	 * i = 0 equal instances
	 * i < 0 this instance is lesser
	 * i > 0 this instance is greater
	 *
	 * @param IComparable $comparable - given instance compared to this instance
	 *
	 * @return int
	 */
	function compare(self $comparable): int;
}
