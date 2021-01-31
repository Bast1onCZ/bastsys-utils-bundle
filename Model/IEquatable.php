<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Interface IEquatable
 * @package BastSys\UtilsBundle\Model
 * @author  mirkl
 */
interface IEquatable
{
	/**
	 * Compares this instance with another instance whether they are equal
	 *
	 * @param IEquatable $comparable
	 *
	 * @return bool
	 */
	function equals(IEquatable $comparable): bool;
}
