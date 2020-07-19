<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Repository\FetchAllRepository;

/**
 * Trait TFetchAllRepository
 * @package BastSys\UtilsBundle\Repository\FetchAllRepository
 * @author  mirkl
 *
 * @property IFetchAllRepository
 */
trait TFetchAllRepository
{
    /**
     * @var bool
     */
    private $fetchedAll = false;

	/**
	 * Overrides findAll() function, when called, fetchedAll identificator is set to true
	 *
	 * @return object[]
	 */
	public function findAll(): array
	{
		$this->fetchedAll = true;
        /** @noinspection PhpUndefinedClassInspection */
        return parent::findAll();
	}

	/**
	 * Tries to fetch all entities if not done yet
	 */
	public function tryFetchAll(): void
	{
		if (!$this->fetchedAll) {
			$this->findAll();
		}
	}
}
