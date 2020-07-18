<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Input;

use Doctrine\ORM\QueryBuilder;

/**
 * Class AFilter
 * @package BastSys\UtilsBundle\Model\Lists\Input
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
