<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Orderable;

use BastSys\UtilsBundle\Entity\Identification\IIdentifiableEntity;
use Doctrine\Common\Collections\Collection;

/**
 * Trait TOrderableManager
 *
 * Provides methods to manage order of IOrderable items
 *
 * @package BastSys\UtilsBundle\Entity\Orderable
 * @author  mirkl
 */
trait TOrderableManager
{
	/**
	 * Changes order of an item in Collection
	 *
	 * @param Collection $items
	 * @param IOrderable      $item
	 * @param int             $newItemOrder
	 *
	 * @return Collection the same instance
	 */
	protected function changeOrder(Collection $items, IOrderable $item, int $newItemOrder): Collection {
		/** @var IOrderable[]|IIdentifiableEntity[] $values */
		$values = $items->getValues();

        $currentOrder = array_search($item, $values);
        if (!is_numeric($currentOrder)) {
            throw new \InvalidArgumentException('Orderable item is not contained in given array of orderabled items', 500);
        }
        if($newItemOrder < 0) {
            throw new \InvalidArgumentException('newItemOrder < 0', 400);
        }
        if($newItemOrder > count($values)) {
            throw new \InvalidArgumentException('newItemOrder > count($items)', 400);
        }

        array_splice($values, $currentOrder, 1);
        array_splice($values, $newItemOrder, 0, [$item]);

		// fix indexes by inserting all items to doctrine collection again
		$items->clear();
		foreach($values as $value) {
			$items->set($value->getId(), $value);
		}

		return $this->fixOrder($items);
	}

	/**
	 * Fixes orders of items
	 *
	 * @param Collection $items
	 *
	 * @return Collection the same instance
	 */
	protected function fixOrder(Collection $items): Collection {
		/** @var IOrderable[] $values */
		$values = $items->getValues();
		for($i = 0; $i < count($values); $i++) {
			$values[$i]->setOrder($i);
		}

		return $items;
	}
}
