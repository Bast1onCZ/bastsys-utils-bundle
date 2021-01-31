<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Service;

use BastSys\UtilsBundle\Exception\NotImplementedException;
use DateTime;
use Exception;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use SimpleXMLElement;

/**
 * Class XmlClassLoader
 * @package BastSys\UtilsBundle\Service
 * @author mirkl
 *
 * @todo: test this class
 */
class XmlClassLoader
{
    /**
     * @param string $class
     * @param SimpleXMLElement $data
     *
     * @return object instance of given class
     * @throws ReflectionException
     * @throws NotImplementedException
     */
    public function loadClass(string $class, SimpleXMLElement $data): object {
        $instance = new $class();

        $ref = new ReflectionClass($class);
        $properties = $this->getAllProperties($ref);

        foreach($properties as $prop) {
            $propName = $prop->getName();
            $isAccessible = $prop->isPublic();

            if(!$isAccessible) {
                $prop->setAccessible(true);
            }

            $type = $this->getDocVarType($prop);
            $value = $this->typeConvert((string) ($data->$propName ?? ''), $type);
            $prop->setValue($instance, $value);

            if(!$isAccessible) {
                $prop->setAccessible(false);
            }
        }

        return $instance;
    }

    /**
     * @param ReflectionClass $class
     * @return ReflectionProperty[]
     */
    private function getAllProperties(ReflectionClass $class): array {
        $filter = ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC;
        $properties = $class->getProperties($filter);

        $parentClass = $class;
        while($parentClass = $parentClass->getParentClass()) {
            $parentProperties = $parentClass->getProperties($filter);
            foreach($parentProperties as $parentProperty) {
                $properties[] = $parentProperty;
            }
        }

        return $properties;
    }

    /**
     * @param ReflectionProperty $property
     * @return string
     */
    private function getDocVarType(ReflectionProperty $property): string {
        $matches = [];
        preg_match('/@var\s+([\S]+)/', $property->getDocComment(), $matches);
        if(!isset($matches[1])) {
            $propName = $property->getName();
            throw new InvalidArgumentException("Doc comment of property '$propName' does not contain valid @var annotation");
        }

        return $matches[1];
    }

	/**
	 * @param string $value
	 * @param string $phpdocType
	 *
	 * @return DateTime|string
	 */
    private function typeConvert(string $value, string $phpdocType) {
        $result = $value;

        $types = explode('|', $phpdocType);

        if($value === null && in_array('null', $types)) {
            return null;
        }

        $preferredType = $types[0];

        switch($preferredType) {
            case 'string':
            case 'int':
            case 'float':
            case 'bool':
            case 'boolean':
                settype($result, $preferredType);
                break;
            case 'DateTime':
            case '\DateTime':
                try {
                    $result = new DateTime($value);
                } catch(Exception $ex) {
                    throw new InvalidArgumentException("Invalid datetime '$preferredType'");
                }
                break;
            default:
                throw new NotImplementedException("Type '$preferredType' not implemented");
        }

        return $result;
    }
}
