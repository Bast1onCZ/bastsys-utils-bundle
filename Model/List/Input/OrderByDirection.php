<?php

namespace BastSys\UtilsBundle\Model\ListStructure\Input;

use BastSys\UtilsBundle\Model\IEnumClass;

/**
 * Class OrderByDirection
 * @package BastSys\UtilsBundle\Model\ListStructure\Input
 * @author mirkl
 */
class OrderByDirection implements IEnumClass
{
    /**
     *
     */
    const ASC = 'ASC';
    /**
     *
     */
    const DESC = 'DESC';

    /**
     * @return array
     */
    public static function getOptions(): array
    {
        return [
            self::ASC,
            self::DESC,
        ];
    }
}
