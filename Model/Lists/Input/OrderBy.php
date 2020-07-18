<?php

namespace BastSys\UtilsBundle\Model\Lists\Input;

use Iterator;

/**
 * Class OrderBy
 * @package BastSys\UtilsBundle\Model\Lists\Input
 * @author mirkl
 */
class OrderBy extends \ArrayIterator implements Iterator
{
    /**
     * Creates OrderBy structure
     *
     * @param OrderBy $fieldDirectionPairs
     */
    public function __construct(array $fieldDirectionPairs)
    {
        parent::__construct($fieldDirectionPairs);
    }

    /**
     * @return FieldDirectionPair
     */
    public function current(): FieldDirectionPair
    {
        return parent::current();
    }
}
