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
     * @var \DateTime
     */
    private \DateTime $start;
    /**
     * @var \DateTime
     */
    private \DateTime $end;

    /**
     * DateTimeInterval constructor.
     * @param \DateTime $start
     * @param \DateTime $end
     */
    public function __construct(\DateTime $start, \DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * Checks whether this complex interval fully contains given value
     *
     * @param \DateTime|DateTimeInterval $entity
     * @return bool
     * @throws \Exception
     */
    public function contains($entity): bool {
        if($entity instanceof \DateTime) {
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
