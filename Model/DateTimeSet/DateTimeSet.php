<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\DateTimeSet;

/**
 * Class DateTimeSet
 * @package BastSys\UtilsBundle\Model\DateTimeSet
 * @author mirkl
 */
class DateTimeSet
{
    private const CONTAINED_INTERVAL_INDICATOR = 1;
    private const PARTLY_INTERSECTED_INTERVAL_INDICATOR = 2;

    /**
     * @var DateTimeInterval[]
     */
    private array $intervals = [];

    public function __construct()
    {
    }

    /**
     * @param DateTimeInterval $interval
     * @throws \Exception
     */
    public function add(DateTimeInterval $interval): void {
        $intersectedIndexIndicators = [];
        for($i = 0; $i < count($this->intervals); $i++) {
            $setInterval = $this->intervals[$i];
            if($interval->intersects($setInterval)) {
                if($setInterval->contains($interval)) {
                    // no need to do anything, because this interval is already contained in another one
                    return;
                }

                if($interval->contains($setInterval)) {
                    $intersectedIndexIndicators[$i] = self::CONTAINED_INTERVAL_INDICATOR;
                } else {
                    $intersectedIndexIndicators[$i] = self::PARTLY_INTERSECTED_INTERVAL_INDICATOR;
                }
            }
        }

        array_reverse($intersectedIndexIndicators); // reverse because of continuous array splicing

        foreach($intersectedIndexIndicators as $index => $indicator) {
            switch ($indicator) {
                case self::CONTAINED_INTERVAL_INDICATOR:
                    array_splice($this->intervals, $index, 1);
                    break;
                case self::PARTLY_INTERSECTED_INTERVAL_INDICATOR:
                    $partlyIntersectedInterval = $this->intervals[$index];
                    if($interval->contains($partlyIntersectedInterval->getEnd()) && !$interval->contains($partlyIntersectedInterval->getStart())) {
                        $interval = $interval->setStart($partlyIntersectedInterval->getStart());
                        array_splice($this->intervals, $index, 1);
                    } else if($interval->contains($partlyIntersectedInterval->getStart()) && !$interval->contains($partlyIntersectedInterval->getEnd())) {
                        $interval = $interval->setEnd($partlyIntersectedInterval->getEnd());
                        array_splice($this->intervals, $index, 1);
                    }
                    break;
            }
        }

        $this->intervals[] = $interval;
        usort($this->intervals, function(DateTimeInterval $interval0, DateTimeInterval $interval1) {
            return $interval0->getStart() < $interval1->getStart() ? -1 : 1;
        });
    }

    public function remove(DateTimeInterval $interval): void {
        // TODO: implement this
    }

    /**
     * @return DateTimeInterval[]
     */
    public function getIntervals(): array
    {
        return array(...$this->intervals);
    }
}
