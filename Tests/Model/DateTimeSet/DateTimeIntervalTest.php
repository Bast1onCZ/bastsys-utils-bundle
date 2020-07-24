<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Tests\Model\DateTimeSet;

use BastSys\UtilsBundle\Model\DateTimeSet\DateTimeInterval;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeIntervalTest
 * @package BastSys\UtilsBundle\Tests\Model\DateTimeSet
 * @author mirkl
 */
class DateTimeIntervalTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testIntersectsStart() {
        $interval = new DateTimeInterval(new \DateTimeImmutable('1 day'), new \DateTimeImmutable('2 days'));
        $interval1 = new DateTimeInterval(new \DateTimeImmutable('10 hours'), new \DateTimeImmutable('1 day + 5 hours'));

        $this->assertTrue($interval->intersects($interval1), '$interval intersects $interval1');
        $this->assertTrue($interval1->intersects($interval), '$interval1 intersects $interval');
        $this->assertFalse($interval->contains($interval1), '$interval does not contain $interval1');
        $this->assertFalse($interval1->contains($interval), '$interval1 does not contain $interval');
    }

    /**
     * @throws \Exception
     */
    public function testIntersectsEnd() {
        $interval = new DateTimeInterval(new \DateTimeImmutable('1 day'), new \DateTimeImmutable('2 days'));
        $interval1 = new DateTimeInterval(new \DateTimeImmutable('1 day + 16 hours'), new \DateTimeImmutable('2 days + 5 hours'));

        $this->assertTrue($interval->intersects($interval1), '$interval intersects $interval1');
        $this->assertTrue($interval1->intersects($interval), '$interval1 intersects $interval');
        $this->assertFalse($interval->contains($interval1), '$interval does not contain $interval1');
        $this->assertFalse($interval1->contains($interval), '$interval1 does not contain $interval');
    }

    /**
     * @throws \Exception
     */
    public function testContains() {
        $interval = new DateTimeInterval(new \DateTimeImmutable('1 day'), new \DateTimeImmutable('2 days'));
        $interval1 = new DateTimeInterval(new \DateTimeImmutable('0 days'), new \DateTimeImmutable('2 days + 5 hours'));

        $this->assertTrue($interval->intersects($interval1), '$interval intersects $interval1');
        $this->assertTrue($interval1->intersects($interval), '$interval1 intersects $interval');
        $this->assertTrue($interval1->contains($interval), '$interval1 contains $interval');
        $this->assertFalse($interval->contains($interval1), '$interval1 does not contain $interval');
    }

    /**
     *
     * @throws \Exception
     */
    public function testDoesNotIntersect() {
        $interval = new DateTimeInterval(new \DateTimeImmutable('1 day'), new \DateTimeImmutable('2 days'));
        $interval1 = new DateTimeInterval(new \DateTimeImmutable('2 days + 1 minute'), new \DateTimeImmutable('3 days'));

        $this->assertFalse($interval->intersects($interval1), '$interval does not intersect $interval1');
        $this->assertFalse($interval1->intersects($interval), '$interval1 does not intersect $interval');
        $this->assertFalse($interval->contains($interval1), '$interval does not contain $interval1');
        $this->assertFalse($interval1->contains($interval), '$interval1 does not contain $interval');
    }

    /**
     * @throws \Exception
     */
    public function testLength() {
        $interval = new DateTimeInterval(
            new \DateTimeImmutable('1 second'),
            new \DateTimeImmutable('2 seconds')
        );
        $length = $interval->getLength();

        $this->assertEquals(1, $length->s);
        $this->assertEquals(0, $length->invert);
    }

    /**
     * @throws \Exception
     */
    public function testUnixCreation() {
        $interval = new DateTimeInterval(0, 65000);

        $this->assertEquals(0, $interval->getStart()->getTimestamp());
        $this->assertEquals(65000, $interval->getEnd()->getTimestamp());
    }

    /**
     * @throws \Exception
     */
    public function testStartAfterEnd() {
        $this->expectException(\InvalidArgumentException::class);
        new DateTimeInterval(new \DateTimeImmutable(), new \DateTimeImmutable('-1 day'));
    }

    /**
     * @throws \Exception
     */
    public function testInvalidCreationData() {
        $this->expectException(\InvalidArgumentException::class);

        /** @var \DateTimeImmutable $start */
        $start = new \DateTime();
        /** @var \DateTimeImmutable $end */
        $end = new \DateTime('+1 day');
        new DateTimeInterval($start, $end);
    }
}
