<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Indexable;

use BastSys\UtilsBundle\Entity\Identification\IIdentifiableEntity;
use Doctrine\Common\Collections\Collection;
use InvalidArgumentException;

/**
 * Trait TIndexManager
 *
 * Provides methods to manage index of IIndexable items
 *
 * @package BastSys\UtilsBundle\Entity\Indexable
 * @author  mirkl
 */
trait TIndexManager
{
	/**
	 * Changes index of an item in Collection
	 *
	 * @param Collection $items
	 * @param IIndexable      $item
	 * @param int             $newItemIndex
	 *
	 * @return Collection the same instance
	 */
	protected function changeIndex(Collection $items, IIndexable $item, int $newItemIndex): Collection {
		/** @var IIndexable[]|IIdentifiableEntity[] $values */
		$values = $items->getValues();

        $currentIndex = array_search($item, $values);
        if (!is_numeric($currentIndex)) {
            throw new InvalidArgumentException('Indexable item is not contained in given array of indexable items', 500);
        }
        if($newItemIndex < 0) {
            throw new InvalidArgumentException('newItemIndex < 0', 400);
        }
        if($newItemIndex > count($values)) {
            throw new InvalidArgumentException('newItemIndex > count($items)', 400);
        }

        array_splice($values, $currentIndex, 1);
        array_splice($values, $newItemIndex, 0, [$item]);

		// fix indexes by inserting all items to doctrine collection again
		$items->clear();
		foreach($values as $value) {
			$items->set($value->getId(), $value);
		}

		return $this->fixIndex($items);
	}

	/**
	 * Fixes indexes of items
	 *
	 * @param Collection $items
	 *
	 * @return Collection the same instance
	 */
	protected function fixIndex(Collection $items): Collection {
		/** @var IIndexable[] $values */
		$values = $items->getValues();
		for($i = 0; $i < count($values); $i++) {
			$values[$i]->setIndex($i);
		}

		return $items;
	}
}
