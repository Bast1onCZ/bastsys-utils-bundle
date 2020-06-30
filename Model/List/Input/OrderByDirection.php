<?php

namespace App\ResourceBundle\Model\ListStructure\Input;

use BastSys\UtilsBundle\Model\IEnumClass;

/**
 * Class OrderByDirection
 * @package App\ResourceBundle\Model\ListStructure\Input
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
