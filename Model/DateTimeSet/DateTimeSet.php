<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\DateTimeSet;

use BastSys\UtilsBundle\Model\Arrays;

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

    public function __construct()
    {
    }

    /**
     * @param DateTimeInterval $addInterval
     * @throws \Exception
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

        array_reverse($intersectionIndexIndicators); // reverse because of continuous array splicing

        foreach ($intersectionIndexIndicators as $index => $indicator) {
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
     * @throws \Exception
     */
    public function remove(DateTimeInterval $removeInterval): void
    {
        $intersectionIndexIndicators = $this->analyzeIntersections($removeInterval);

        array_reverse($intersectionIndexIndicators); // continuous array splicing

        foreach($intersectionIndexIndicators as $index => $indicator) {
            $prevInterval = $this->intervals[$index];
            switch ($indicator) {
                case self::CONTAINED_INTERVAL_INDICATOR:
                    array_splice($this->intervals, $index, 1);
                    break;
                case self::PARTLY_INTERSECTED_INTERVAL_INDICATOR:
                    if($removeInterval->contains($prevInterval->getStart())) {
                        $prevInterval = $prevInterval->setStart($removeInterval->getEnd());
                    } else if($removeInterval->contains($prevInterval->getEnd())) {
                        $prevInterval = $prevInterval->setEnd($removeInterval->getStart());
                    }
                    $this->intervals[$index] = $prevInterval;
                    break;
                case self::WRAPPED_INTERVAL_INDICATOR:
                    $prevEnd = $prevInterval->getEnd();

                    $prevInterval = $prevInterval->setEnd($removeInterval->getStart());
                    $this->intervals[$index] = $prevInterval;

                    $nextInterval = new DateTimeInterval($removeInterval->getEnd(), $prevEnd);
                    $this->intervals[] = $nextInterval;
                    break;
            }
        }

        $this->sortIntervals();
    }

    /**
     * @param DateTimeInterval $interval
     * @return array [$index => $intersectionIndicator, ...]
     * @throws \Exception
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
