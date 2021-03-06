<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Timestampable;

use DateTime;

/**
 * Interface ITimestampable
 * @package BastSys\UtilsBundle\Entity\Timestampable
 * @author  mirkl
 */
interface ITimestampable
{
	/**
	 * @return DateTime
	 */
	function getCreatedAt(): DateTime;

	/**
	 * @return DateTime
	 */
	function getUpdatedAt(): DateTime;
}
