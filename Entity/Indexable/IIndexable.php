<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Indexable;

use BastSys\UtilsBundle\Model\IComparable;

/**
 * Interface IIndexable
 * @package BastSys\UtilsBundle\Entity\IIndexable
 * @author  mirkl
 */
interface IIndexable extends IComparable
{
	/**
	 * @return int
	 */
	function getIndex(): int;

    /**
     * @param int $index
     * @internal only setter, used only in TIndexManager
     */
	function setIndex(int $index): void;
}
