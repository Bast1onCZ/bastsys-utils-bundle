<?php

namespace BastSys\UtilsBundle\Model;

/**
 * Interface ICopyable
 * Represents a class, that can copy its data into another instance.
 *
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
interface ICopyable
{
    /**
     * @param ICopyable $instance
     */
    function copyInto(self $instance): void;
}
