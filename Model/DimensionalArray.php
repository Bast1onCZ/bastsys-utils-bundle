<?php

namespace BastSys\UtilsBundle\Model;

/**
 * Class DimensionalArray
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class DimensionalArray {
    /**
     * @var array
     */
    private $array;

    /**
     * DimensionalArray constructor.
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @return array
     */
    public function getOriginal(): array {
        return $this->array;
    }

    /**
     * Tries to get value from the dimensional array at given path. Uses '.' to split the path.
     *
     * @param string $path path of the argument (e.g. 'input.password' will search like $array['input']['password'])
     * @param mixed $defaultValue value that should be returned when the param was not found
     * 
     * @return mixed found value or $defaultValue
     */
    public function get(string $path, $defaultValue = null) {
        $parts = explode('.', $path);
        $currentValue = $this->array;

        foreach($parts as $part) {
            if(!isset($currentValue[$part])) {
                return $defaultValue;
            }

            $currentValue = $currentValue[$part];
        }

        return $currentValue;
    }

    /**
     * Checks whether the given path is specified in the dimensional array; Uses '.' to split the path
     *
     * @param string $path path of the argument (e.g. 'input.password' will search like $array['input']['password'])
     *
     * @return bool
     */
    public function has(string $path): bool {
        $parts = explode('.', $path);
        $currentValue = $this->array;

        foreach($parts as $part) {
            if(!array_key_exists($path, $currentValue)) {
                return false;
            }

            $currentValue = $currentValue[$part];
        }

        return true;
    }
}
