<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Output;

/**
 * Class UnknownPageException
 * @package BastSys\UtilsBundle\Model\Lists\Output
 * @author  mirkl
 */
class UnknownPageException extends \Exception
{
	/**
	 * UnknownPageException constructor.
	 */
	public function __construct()
	{
		parent::__construct('Page cannot be determined at this instance', 500);
	}
}
