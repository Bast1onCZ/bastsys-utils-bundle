<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

use SimpleXMLElement;

/**
 * Class CleanXmlElement
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class CleanXmlElement extends SimpleXMLElement
{
    /**
     * Returns xml as string and clears all comments
     *
     * @return string
     */
    public function __toString()
    {
        $result = parent::asXML();

        return preg_replace('/<\?.+\?>/', '', $result);
    }
}
