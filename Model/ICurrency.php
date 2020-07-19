<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Interface ICurrency
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
interface ICurrency
{
    /**
     * @return string
     */
    public function getCode(): string;
}
