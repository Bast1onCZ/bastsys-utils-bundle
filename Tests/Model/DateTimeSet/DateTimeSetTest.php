<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Tests\Model\DateTimeSet;

use BastSys\UtilsBundle\Model\DateTimeSet\DateTimeInterval;
use BastSys\UtilsBundle\Model\DateTimeSet\DateTimeSet;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeSetTest
 * @package BastSys\UtilsBundle\Tests\Model\DateTimeSet
 * @author mirkl
 */
class DateTimeSetTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testIntersectionMerge() {
        $start = new \DateTimeImmutable('1 day');
        $end = new \DateTimeImmutable('3 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start, new \DateTimeImmutable('2 days'))
        );
        $set->add(
            new DateTimeInterval(new \DateTimeImmutable('1 day + 16 hours'), $end)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start, $intervals[0]->getStart());
        $this->assertEquals($end, $intervals[0]->getEnd());

        // inverted
        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval(new \DateTimeImmutable('1 day + 16 hours'), $end)
        );
        $set->add(
            new DateTimeInterval($start, new \DateTimeImmutable('2 days'))
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start, $intervals[0]->getStart());
        $this->assertEquals($end, $intervals[0]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testWrappedMerge() {
        $start = new \DateTimeImmutable('1 day');
        $end = new \DateTimeImmutable('3 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start, $end)
        );
        $set->add(
            new DateTimeInterval(new \DateTimeImmutable('1 day + 5 hours'), new \DateTimeImmutable('2 days + 16 hours'))
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start, $intervals[0]->getStart());
        $this->assertEquals($end, $intervals[0]->getEnd());

        // inversed
        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval(new \DateTimeImmutable('1 day + 5 hours'), new \DateTimeImmutable('2 days + 16 hours'))
        );
        $set->add(
            new DateTimeInterval($start, $end)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start, $intervals[0]->getStart());
        $this->assertEquals($end, $intervals[0]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testContainedMerge() {
        $start = new \DateTimeImmutable('1 days');
        $end = new \DateTimeImmutable('4 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval(new \DateTimeImmutable('2 days'), new \DateTimeImmutable('3 days'))
        );
        $set->add(
            new DateTimeInterval($start, $end)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start, $intervals[0]->getStart());
        $this->assertEquals($end, $intervals[0]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testNonIntersectionMerge() {
        $start0 = new \DateTimeImmutable('0 days');
        $end0 = new \DateTimeImmutable('1 day');
        $start1 = new \DateTimeImmutable('2 days');
        $end1 = new \DateTimeImmutable('3 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start0, $end0)
        );
        $set->add(
            new DateTimeInterval($start1, $end1)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(2, $intervals);
        $this->assertEquals($start0, $intervals[0]->getStart());
        $this->assertEquals($end0, $intervals[0]->getEnd());
        $this->assertEquals($start1, $intervals[1]->getStart());
        $this->assertEquals($end1, $intervals[1]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testNonIntersectRemoval() {
        $start0 = new \DateTimeImmutable('0 days');
        $end0 = new \DateTimeImmutable('1 day');
        $start1 = new \DateTimeImmutable('2 days');
        $end1 = new \DateTimeImmutable('3 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start0, $end0)
        );
        $set->remove(
            new DateTimeInterval($start1, $end1)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start0, $intervals[0]->getStart());
        $this->assertEquals($end0, $intervals[0]->getEnd());

        // inverted
        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start1, $end1)
        );
        $set->remove(
            new DateTimeInterval($start0, $end0)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start1, $intervals[0]->getStart());
        $this->assertEquals($end1, $intervals[0]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testIntersectionRemoval() {
        $start0 = new \DateTimeImmutable('1 days');
        $end0 = new \DateTimeImmutable('2 days');
        $start1 = new \DateTimeImmutable('1 days + 8 hours');
        $end1 = new \DateTimeImmutable('3 days');

        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start0, $end0)
        );
        $set->remove(
            new DateTimeInterval($start1, $end1)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($start0, $intervals[0]->getStart());
        $this->assertEquals($start1, $intervals[0]->getEnd());

        // inversed
        $set = new DateTimeSet();
        $set->add(
            new DateTimeInterval($start1, $end1)
        );
        $set->remove(
            new DateTimeInterval($start0, $end0)
        );

        $intervals = $set->getIntervals();
        $this->assertCount(1, $intervals);
        $this->assertEquals($end0, $intervals[0]->getStart());
        $this->assertEquals($end1, $intervals[0]->getEnd());
    }

    /**
     * @throws \Exception
     */
    public function testContainmentRemoval() {
        $interval0 = new DateTimeInterval(new \DateTimeImmutable('2 days'), new \DateTimeImmutable('3 days'));
        $interval1 = new DateTimeInterval(new \DateTimeImmutable('1 day'), new \DateTimeImmutable('4 days'));

        $set = new DateTimeSet();
        $set->add($interval0);
        $this->assertCount(1, $set->getIntervals());
        $this->assertSame($interval0, $set->getIntervals()[0]);

        $set->remove($interval1);

        $this->assertEmpty($set->getIntervals());
    }

    /**
     * @throws \Exception
     */
    public function testWrappedRemoval() {
        $start0 = new \DateTimeImmutable('1 day');
        $end0 = new \DateTimeImmutable('4 days');
        $start1 = new \DateTimeImmutable('2 days');
        $end1 = new \DateTimeImmutable('3 days');

        $interval0 = new DateTimeInterval($start0, $end0);
        $interval1 = new DateTimeInterval($start1, $end1);

        $set = new DateTimeSet();
        $set->add($interval0);
        $set->remove($interval1);

        $intervals = $set->getIntervals();
        $this->assertCount(2, $intervals);
        $this->assertEquals($start0, $intervals[0]->getStart());
        $this->assertEquals($start1, $intervals[0]->getEnd());
        $this->assertEquals($end1, $intervals[1]->getStart());
        $this->assertEquals($end0, $intervals[1]->getEnd());
    }
}
