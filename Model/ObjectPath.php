<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

use InvalidArgumentException;

/**
 * Class ObjectPathKey
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class ObjectPath
{
    /**
     * Macro for get
     *
     * @param object $source
     * @param string $path
     * @return mixed
     */
    public static function g(object $source, string $path) {
        return (new ObjectPath($path))->get($source);
    }

    /**
     * @var string
     */
    private $parts;

    /**
     * ObjectPathKey constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        if(!preg_match('/^[\w.]*$/', $path)) {
            throw new InvalidArgumentException("Invalid path '$path'");
        }

        $this->parts = explode('.', $path);
    }

    /**
     * Retrieves value from object.
     * If any part returns null, null is returned
     *
     * @param object $source
     * @return mixed
     */
    public function get(object $source) {
        $current = $source;
        foreach($this->parts as $part) {
            if(!$current) {
                break;
            }

            $getter = Strings::getGetterName($part);

            $current = $current->$getter();
        }

        return $current;
    }
}
