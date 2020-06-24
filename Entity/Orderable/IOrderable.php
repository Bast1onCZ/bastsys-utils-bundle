<?php

namespace BastSys\UtilsBundle\Entity\Orderable;

use BastSys\UtilsBundle\Model\IComparable;

/**
 * Interface IOrderable
 * @package BastSys\UtilsBundle\Entity\IOrderable
 * @author  mirkl
 */
interface IOrderable extends IComparable
{
	/**
	 * @return int
	 */
	function getOrder(): int;

    /**
     * @param int $order
     * @internal only setter, used only in TOrderableManager
     */
	function setOrder(int $order): void;
}
