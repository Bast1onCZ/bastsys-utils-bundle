<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Exception;

use RuntimeException;

/**
 * Class TraitNotImplementingInterfaceException
 * @package BastSys\UtilsBundle\Exception
 * @author mirkl
 */
class TraitNotImplementingInterfaceException extends RuntimeException
{
    /**
     * TraitNotImplementingInterfaceException constructor.
     * @param object $traitInstance
     * @param string $traitClass
     * @param string $interfaceClass
     */
    public function __construct(object $traitInstance, string $traitClass, string $interfaceClass)
    {
        $instanceClass = get_class($traitInstance);
        parent::__construct("Class '$instanceClass' uses trait '$traitClass' without implementing interface '$interfaceClass'", 500);
    }
}
