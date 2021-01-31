<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Indexable;

use BastSys\UtilsBundle\Model\IComparable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TIndexable
 * @package BastSys\UtilsBundle\Entity\IIndexable
 * @author  mirkl
 *
 * @ORM\MappedSuperclass()
 */
trait TIndexable
{
	/**
	 * @var int
	 * @ORM\Column(name="`index`", type="integer")
	 */
	private int $index = -1;

	/**
	 * @param IComparable $indexable
	 *
	 * @return int
	 */
	public function compare(IComparable $indexable): int
	{
		/** @var IIndexable $indexable */
		return $this->index - $indexable->getIndex();
	}

	/**
	 * @return int
	 */
	public function getIndex(): int
	{
		return $this->index;
	}

	/**
	 * @param int $index
	 * @internal use TIndexManager::changeIndex
	 */
	public function setIndex(int $index): void
	{
		$this->index = $index;
	}
}
