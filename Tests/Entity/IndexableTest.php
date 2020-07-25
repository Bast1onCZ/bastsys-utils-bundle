<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Class IndexableTest
 * @package BastSys\UtilsBundle\Tests\Entity
 * @author mirkl
 */
class IndexableTest extends TestCase
{
    /**
     *
     */
    public function testFluentAddition() {
        $manager = new TestIndexManager();
        $manager->addItem($item0 = new TestIndexable());
        $manager->addItem($item1 = new TestIndexable());
        $manager->addItem($item2 = new TestIndexable());
        $manager->addItem($item3 = new TestIndexable());

        $this->assertEquals(0, $item0->getIndex());
        $this->assertEquals(1, $item1->getIndex());
        $this->assertEquals(2, $item2->getIndex());
        $this->assertEquals(3, $item3->getIndex());
    }

    /**
     *
     */
    public function testItemIndexForward() {
        $manager = new TestIndexManager();
        $manager->addItem($item0 = new TestIndexable());
        $manager->addItem($item1 = new TestIndexable());
        $manager->addItem($item2 = new TestIndexable());
        $manager->addItem($item3 = new TestIndexable());

        $manager->changeItemIndex($item2, 0);
        $this->assertEquals(0, $item2->getIndex());
        $this->assertEquals(1, $item0->getIndex());
        $this->assertEquals(2, $item1->getIndex());
        $this->assertEquals(3, $item3->getIndex());
    }

    /**
     *
     */
    public function testItemIndexBackward() {
        $manager = new TestIndexManager();
        $manager->addItem($item0 = new TestIndexable());
        $manager->addItem($item1 = new TestIndexable());
        $manager->addItem($item2 = new TestIndexable());
        $manager->addItem($item3 = new TestIndexable());

        $manager->changeItemIndex($item0, 2);
        $this->assertEquals(0, $item1->getIndex());
        $this->assertEquals(1, $item2->getIndex());
        $this->assertEquals(2, $item0->getIndex());
        $this->assertEquals(3, $item3->getIndex());
    }

    /**
     *
     */
    public function testItemFluentRemoval() {
        $manager = new TestIndexManager();
        $manager->addItem($item0 = new TestIndexable());
        $manager->addItem($item1 = new TestIndexable());
        $manager->addItem($item2 = new TestIndexable());
        $manager->addItem($item3 = new TestIndexable());

        $manager->removeItem($item1);
        $this->assertEquals(0, $item0->getIndex());
        $this->assertEquals(1, $item2->getIndex());
        $this->assertEquals(2, $item3->getIndex());
    }
}
