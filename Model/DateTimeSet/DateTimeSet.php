<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\DateTimeSet;

use BastSys\UtilsBundle\Model\Arrays;
use Exception;

/**
 * Class DateTimeSet
 * @package BastSys\UtilsBundle\Model\DateTimeSet
 * @author mirkl
 */
class DateTimeSet
{
    /**
     * Previous interval is contained in the new one
     */
    private const CONTAINED_INTERVAL_INDICATOR = 1;
    /**
     * Previous interval shares its part with the new one
     */
    private const PARTLY_INTERSECTED_INTERVAL_INDICATOR = 2;
    /**
     * Previous interval completely wraps the new one
     */
    private const WRAPPED_INTERVAL_INDICATOR = 3;

    /**
     * @var DateTimeInterval[]
     */
    private array $intervals = [];

    /**
     * DateTimeSet constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param DateTimeInterval $addInterval
     * @throws Exception
     */
    public function add(DateTimeInterval $addInterval): void
    {
        $intersectionIndexIndicators = $this->analyzeIntersections($addInterval);
        $isWrapped = Arrays::some($intersectionIndexIndicators, function (int $indicator) {
            return $indicator === self::WRAPPED_INTERVAL_INDICATOR;
        });

        if ($isWrapped) {
            // new interval is already wrapped in a previous one
            return;
        }

        for ($index = count($intersectionIndexIndicators) - 1; $index >= 0; $index--) {
            $indicator = $intersectionIndexIndicators[$index];
            switch ($indicator) {
                case self::CONTAINED_INTERVAL_INDICATOR:
                    array_splice($this->intervals, $index, 1);
                    break;
                case self::PARTLY_INTERSECTED_INTERVAL_INDICATOR:
                    $partlyIntersectedInterval = $this->intervals[$index];
                    if ($addInterval->contains($partlyIntersectedInterval->getEnd()) && !$addInterval->contains($partlyIntersectedInterval->getStart())) {
                        $addInterval = $addInterval->setStart($partlyIntersectedInterval->getStart());
                        array_splice($this->intervals, $index, 1);
                    } else if ($addInterval->contains($partlyIntersectedInterval->getStart()) && !$addInterval->contains($partlyIntersectedInterval->getEnd())) {
                        $addInterval = $addInterval->setEnd($partlyIntersectedInterval->getEnd());
                        array_splice($this->intervals, $index, 1);
                    }
                    break;
            }
        }

        $this->intervals[] = $addInterval;
        $this->sortIntervals();
    }

    /**
     * @param DateTimeInterval $removeInterval
     * @throws Exception
     */
    public function remove(DateTimeInterval $removeInterval): void
    {
        $intersectionIndexIndicators = $this->analyzeIntersections($removeInterval);

        for ($index = count($intersectionIndexIndicators) - 1; $index >= 0; $index--) {
            $indicator = $intersectionIndexIndicators[$index];
            $currentInterval = $this->intervals[$index];
            switch ($indicator) {
                case self::CONTAINED_INTERVAL_INDICATOR:
                    array_splice($this->intervals, $index, 1);
                    break;
                case self::PARTLY_INTERSECTED_INTERVAL_INDICATOR:
                    if($removeInterval->contains($currentInterval->getStart())) {
                        $currentInterval = $currentInterval->setStart($removeInterval->getEnd());
                    } else if($removeInterval->contains($currentInterval->getEnd())) {
                        $currentInterval = $currentInterval->setEnd($removeInterval->getStart());
                    }
                    $this->intervals[$index] = $currentInterval;
                    break;
                case self::WRAPPED_INTERVAL_INDICATOR:
                    $prevEnd = $currentInterval->getEnd();

                    $currentInterval = $currentInterval->setEnd($removeInterval->getStart());
                    $this->intervals[$index] = $currentInterval;

                    $nextInterval = new DateTimeInterval($removeInterval->getEnd(), $prevEnd);
                    $this->intervals[] = $nextInterval;
                    break;
            }
        }

        $this->removeEmptyIntervals();
        $this->sortIntervals();
    }

    /**
     * @param DateTimeInterval $interval
     * @return array [$index => $intersectionIndicator, ...]
     * @throws Exception
     */
    private function analyzeIntersections(DateTimeInterval $interval): array
    {
        $intersectedIndexIndicators = [];
        for ($i = 0; $i < count($this->intervals); $i++) {
            $prevInterval = $this->intervals[$i];
            if ($interval->intersects($prevInterval)) {
                if ($prevInterval->contains($interval)) {
                    $intersectedIndexIndicators[$i] = self::WRAPPED_INTERVAL_INDICATOR;
                } else if ($interval->contains($prevInterval)) {
                    $intersectedIndexIndicators[$i] = self::CONTAINED_INTERVAL_INDICATOR;
                } else {
                    $intersectedIndexIndicators[$i] = self::PARTLY_INTERSECTED_INTERVAL_INDICATOR;
                }
            }
        }

        return $intersectedIndexIndicators;
    }

	/**
	 * @throws Exception
	 */
    private function removeEmptyIntervals() {
        $this->intervals = array_filter($this->intervals, function (DateTimeInterval $interval) {
            return !$interval->isEmpty();
        });
    }

    /**
     *
     */
    private function sortIntervals(): void {
        usort($this->intervals, function (DateTimeInterval $interval0, DateTimeInterval $interval1) {
            return $interval0->getStart() < $interval1->getStart() ? -1 : 1;
        });
    }

    /**
     * @return DateTimeInterval[]
     */
    public function getIntervals(): array
    {
        return array(...$this->intervals);
    }
}
