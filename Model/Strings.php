<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Class Strings
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class Strings
{
    /**
     * Gets bundle name from the namespace of the class
     *
     * @param object $object
     *
     * @return string bundle name of the given object
     */
    public static function getBundleName($object): string
    {
        $class = get_class($object);

        return self::getClassBundleName($class);
    }

    /**
     * @param string $class
     * @return string
     */
    public static function getClassBundleName(string $class): string
    {
        $path = explode('\\', $class, 3);

        return $path[1];
    }

    /**
     * @param string $entityClass
     * @return string
     */
    public static function getEntityRepositoryServiceName(string $entityClass): string
    {
        $underscoreClassName = Strings::camelCaseToUnderscore(
            Strings::getSimpleClassName($entityClass)
        );
        $underscoreBundleName = Strings::camelCaseToUnderscore(
            Strings::getClassBundleName($entityClass)
        );

        return "$underscoreBundleName.repository.$underscoreClassName";
    }

    /**
     * Converts camel case string to understoce
     *
     * e.g. AppBundle -> app_bundle
     *
     * @param string $str source string
     *
     * @return string underscore string
     */
    public static function camelCaseToUnderscore(string $str): string
    {
        $newStr = preg_replace('/(.)([A-Z])/', '$1_$2', $str); // AppBundle -> App_Bundle
        $newStr = strtolower($newStr);

        return $newStr;
    }

    /**
     * Gets simple class name from class name
     *
     * e. g. App\AppBundle\MyClass -> MyClass
     *
     * @param string $classString
     * @return string $className
     */
    public static function getSimpleClassName(string $classString): string
    {
        return preg_replace('/.*\\\\/', '', $classString);
    }

    /**
     * Gets getter name for a variable
     * E.g. 'firstName' -> 'getFirstName'
     *
     * @param string $variableName
     *
     * @return string
     */
    public static function getGetterName(string $variableName): string
    {
        if(preg_match('/^is/', $variableName)) {
            return $variableName;
        }

        return 'get' . ucfirst($variableName);
    }

    /**
     * Gets setter name for a variable
     * E.g. 'firstName' -> 'setFirstName'
     *
     * @param string $variableName
     *
     * @return string
     */
    public static function getSetterName(string $variableName): string
    {
        return 'set' . ucfirst($variableName);
    }

    /**
     * Gets expected database table name for an entity
     *
     * example 'App\CoreBundle\Entity\Community\User' -> 'core__user'
     *
     * @param string $entityClass entity class name
     * @return string expected table name
     */
    public static function getDatabaseTableName(string $entityClass): string
    {
        $simpleBundleName = str_replace('Bundle', '', Strings::getClassBundleName($entityClass));
        $simpleClassName = Strings::getSimpleClassName($entityClass);

        $underscoredBundleName = Strings::camelCaseToUnderscore($simpleBundleName);
        $underscoreClassName = Strings::camelCaseToUnderscore($simpleClassName);

        return $underscoredBundleName . '__' . $underscoreClassName;
    }

    /**
     * Converts special letter characters in a string to [A-Za-z]
     *
     * @param string $str
     * @return string
     */
    public static function accentFold(string $str) {
        $def = [
            'á' => 'a', 'ä' => 'a',
            'Á' => 'A', 'Ä' => 'A',
            'č' => 'c',
            'Č' => 'C',
            'é' => 'e', 'ě' => 'e',
            'É' => 'E', 'Ě' => 'E',
            'í' => 'i',
            'Í' => 'I',
            'ó' => 'o', 'ö' => 'o',
            'Ó' => 'O', 'Ö' => 'o',
            'ú' => 'u', 'ů' => 'u', 'ü' => 'u',
            'Ú' => 'U', 'Ů' => 'U', 'Ü' => 'U',
            'ř' => 'r',
            'Ř' => 'R',
            'š' => 's',
            'Š' => 'S',
            'ý' => 'y',
            'Ý' => 'Y',
            'ž' => 'z',
            'Ž' => 'Z',
            'ß' => 's'
        ];

        return strtr($str, $def);
    }

}
