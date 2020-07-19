<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Input;

use BastSys\UtilsBundle\Model\IEnumClass;

/**
 * Class OrderByDirection
 * @package BastSys\UtilsBundle\Model\Lists\Input
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
