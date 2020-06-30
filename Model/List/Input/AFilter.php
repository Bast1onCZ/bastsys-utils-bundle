<?php

namespace App\ResourceBundle\Model\ListStructure\Input;

use Doctrine\ORM\QueryBuilder;

/**
 * Class AFilter
 * @package App\ResourceBundle\Model\ListStructure\Input
 * @author mirkl
 */
abstract class AFilter
{
    /**
     * @param QueryBuilder $qb
     * @return mixed
     */
    abstract public function applyOnQueryBuilder(QueryBuilder $qb): void;
}
