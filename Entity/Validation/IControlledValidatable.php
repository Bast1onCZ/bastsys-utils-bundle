<?php

namespace BastSys\UtilsBundle\Entity\Validation;

/**
 * Interface IControlledValidatable
 * @package BastSys\UtilsBundle\Entity\Validation
 * @author mirkl
 */
interface IControlledValidatable extends IValidatable
{
    /**
     * @param bool $isValid
     */
    public function setIsValid(bool $isValid): void;
}
