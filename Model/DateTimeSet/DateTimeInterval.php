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
     * @param \DateTimeImmutable $start
     * @param \DateTimeImmutable $end
     */
    public function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end)
    {
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
     */
    public function setStart(\DateTimeImmutable $start): DateTimeInterval
    {
        return new DateTimeInterval($start, $this->end);
    }

    /**
     * @param \DateTimeImmutable $end
     * @return DateTimeInterval new instance
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
}
