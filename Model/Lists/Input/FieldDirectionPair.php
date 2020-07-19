<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Input;

/**
 * Class FieldDirectionPair
 * @package BastSys\UtilsBundle\Model\Lists\Input
 * @author mirkl
 */
class FieldDirectionPair
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $direction;

    /**
     * FieldDirectionPair constructor.
     *
     * @param string $field
     * @param string $direction
     */
    public function __construct(string $field, string $direction)
    {
        if (!in_array($direction, OrderByDirection::getOptions())) {
            throw new \InvalidArgumentException("Invalid direction '$direction'");
        }

        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getField(): string {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDirection(): string {
        return $this->direction;
    }
}
