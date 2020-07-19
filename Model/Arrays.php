<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Class Arrays
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class Arrays
{
    /**
     * Check if at least one item satisfies criteria function
     *
     * @param array $array
     * @param callable $criteriaFn
     * @return bool
     */
    public static function some(array $array, callable $criteriaFn): bool {
        foreach($array as $item) {
            if($criteriaFn($item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if all items satisfy criteria function
     *
     * @param array $array
     * @param callable $criteriaFn
     * @return bool
     */
    public static function all(array $array, callable $criteriaFn): bool {
        foreach($array as $item) {
            if(!$criteriaFn($item)) {
                return false;
            }
        }

        return true;
    }
}
