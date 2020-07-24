<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\DateTimeSet;

/**
 * Class DateTimeInterval
 * @package BastSys\UtilsBundle\Model\DateTimeSet
 * @author mirkl
 */
class DateTimeInterval
{
    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $start;
    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $end;

    /**
     * DateTimeInterval constructor.
     * @param \DateTimeImmutable|int $start
     * @param \DateTimeImmutable|int $end
     * @throws \Exception
     */
    public function __construct($start, $end)
    {
        if(is_int($start)) {
            $start = (new \DateTimeImmutable())->setTimestamp($start);
        }
        if(is_int($end)) {
            $end = (new \DateTimeImmutable())->setTimestamp($end);
        }

        if(!($start instanceof \DateTimeImmutable)) {
            throw new \InvalidArgumentException('Invalid start type');
        }
        if(!($end instanceof \DateTimeImmutable)) {
            throw new \InvalidArgumentException('Invalid end type');
        }
        if($start > $end) {
            throw new \InvalidArgumentException('Start comes after end');
        }
        if($start === $end) {
            throw new \InvalidArgumentException('Start is equal to end');
        }

        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStart(): \DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEnd(): \DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @param \DateTimeImmutable $start
     * @return DateTimeInterval new instance
     * @throws \Exception
     */
    public function setStart(\DateTimeImmutable $start): DateTimeInterval
    {
        return new DateTimeInterval($start, $this->end);
    }

    /**
     * @param \DateTimeImmutable $end
     * @return DateTimeInterval new instance
     * @throws \Exception
     */
    public function setEnd(\DateTimeImmutable $end): DateTimeInterval
    {
        return new DateTimeInterval($this->start, $end);
    }

    /**
     * Checks whether this complex interval fully contains given value
     *
     * @param \DateTime|\DateTimeImmutable|DateTimeInterval $entity
     * @return bool
     * @throws \Exception
     */
    public function contains($entity): bool {
        if($entity instanceof \DateTime || $entity instanceof \DateTimeImmutable) {
            // compare single interval
            return $this->start <= $entity && $entity <= $this->end;
        } else if($entity instanceof DateTimeInterval) {
            // compare complex interval
            return $this->contains($entity->getStart()) &&
                $this->contains($entity->getEnd());
        } else {
            throw new \InvalidArgumentException('Invalid entity');
        }
    }

    /**
     * Checks whether this complex interval partly or fully contains given value
     *
     * @param DateTimeInterval $interval
     * @return bool
     * @throws \Exception
     */
    public function intersects(DateTimeInterval $interval): bool {
        return $this->contains($interval->getStart()) ||
            $this->contains($interval->getEnd()) ||
            $interval->contains($this->start) ||
            $interval->contains($this->end);
    }

    /**
     * @return \DateInterval
     */
    public function getLength(): \DateInterval {
        return $this->start->diff($this->end);
    }
}
