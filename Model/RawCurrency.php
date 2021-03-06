<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model;

/**
 * Class RawCurrency
 * @package BastSys\UtilsBundle\Model
 * @author mirkl
 */
class RawCurrency implements ICurrency
{
    /**
     * @var string
     */
	private string $code;

    /**
     * RawCurrency constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string {
        return $this->code;
    }
}
