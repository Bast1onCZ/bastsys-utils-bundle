<?php

namespace BastSys\UtilsBundle\Entity\Validation;

/**
 * Interface IValidable
 * @package BastSys\UtilsBundle\Entity
 * @author mirkl
 */
interface IValidatable
{
    /**
     * @return bool
     */
    function isValid(): bool;
}
