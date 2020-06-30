<?php

namespace App\ResourceBundle\Model\ListStructure\Output;

/**
 * Class UnknownPageException
 * @package App\ResourceBundle\Model\ListStructure\Output
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
