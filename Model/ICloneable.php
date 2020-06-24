<?php

namespace BastSys\UtilsBundle\Model;

/**
 * Interface ICloneable
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
interface ICloneable
{
    /**
     * @return ICloneable
     */
    public function clone(): ICloneable;
}
