<?php

namespace BastSys\UtilsBundle\Entity\Timestampable;

/**
 * Interface ITimestampable
 * @package BastSys\UtilsBundle\Entity\Timestampable
 * @author  mirkl
 */
interface ITimestampable
{
	/**
	 * @return \DateTime
	 */
	function getCreatedAt(): \DateTime;

	/**
	 * @return \DateTime
	 */
	function getUpdatedAt(): \DateTime;
}
