<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Interface IEnumClass
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
interface IEnumClass
{
    /**
     * @return array
     */
    static function getOptions(): array;
}
