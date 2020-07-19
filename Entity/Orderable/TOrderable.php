<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Orderable;

use BastSys\UtilsBundle\Model\IComparable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TOrderable
 * @package BastSys\UtilsBundle\Entity\IOrderable
 * @author  mirkl
 *
 * @ORM\MappedSuperclass()
 */
trait TOrderable
{
	/**
	 * @var int
	 * @ORM\Column(name="`order`", type="integer")
	 */
	private $order = -1;

	/**
	 * @param IComparable $orderable
	 *
	 * @return int
	 */
	public function compare(IComparable $orderable): int
	{
		/** @var IOrderable $orderable */
		return $this->order - $orderable->getOrder();
	}

	/**
	 * @return int
	 */
	public function getOrder(): int
	{
		return $this->order;
	}

	/**
	 * @param int $order
	 * @internal use TOrderableManager::changeOrder
	 */
	public function setOrder(int $order): void
	{
		$this->order = $order;
	}
}
