<?php

namespace BastSys\UtilsBundle\Repository\FetchAllRepository;

use BastSys\UtilsBundle\Repository\IEntityRepository;

/**
 * Interface IFetchAllRepository
 *
 * Use this interface along with trait for repositories, that work with a few entities, but can be frequently accessed
 *
 * @package BastSys\UtilsBundle\Repository\FetchAllRepository
 * @author  mirkl
 */
interface IFetchAllRepository extends IEntityRepository
{
	/**
	 * Fetches all entities if not done yet
	 */
	function tryFetchAll(): void;
}
