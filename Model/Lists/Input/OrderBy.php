<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Input;

use ArrayIterator;
use Iterator;

/**
 * Class OrderBy
 * @package BastSys\UtilsBundle\Model\Lists\Input
 * @author mirkl
 */
class OrderBy extends ArrayIterator implements Iterator
{
    /**
     * Creates OrderBy structure
     *
     * @param array $fieldDirectionPairs
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
