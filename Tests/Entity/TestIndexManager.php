<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Tests\Entity;

use BastSys\UtilsBundle\Entity\Identification\AUuidEntity;
use BastSys\UtilsBundle\Entity\Indexable\TIndexManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class TestIndexManager
 * @package BastSys\UtilsBundle\Tests\Entity
 * @author mirkl
 */
class TestIndexManager extends AUuidEntity
{
    use TIndexManager;

    /**
     * @var Collection|TestIndexable[]
     */
    private Collection $items;

    /**
     * TestIndexManager constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = new ArrayCollection();
    }

    /**
     * @param TestIndexable $item
     */
    public function addItem(TestIndexable $item) {
        $this->items[$item->getId()] = $item;
        $this->fixIndex($this->items);
    }

    /**
     * @param TestIndexable $item
     */
    public function removeItem(TestIndexable $item) {
        $this->items->removeElement($item);
        $this->fixIndex($this->items);
    }

    /**
     * @param TestIndexable $item
     * @param int $index
     */
    public function changeItemIndex(TestIndexable $item, int $index) {
        $this->changeIndex($this->items, $item, $index);
    }
}
