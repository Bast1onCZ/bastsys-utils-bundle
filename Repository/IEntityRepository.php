<?php

namespace BastSys\UtilsBundle\Repository;

use BastSys\UtilsBundle\Exception\Entity\EntityNotFoundByIdException;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface IEntityRepository
 * @package BastSys\UtilsBundle\Repository
 * @author mirkl
 */
interface IEntityRepository
{
    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;
	/**
	 * @return ObjectRepository
	 */
	public function getObjectRepository(): ObjectRepository;

    /**
     * @param string $id
     * @param bool $notFoundError
     * @return object|null
     * @throws EntityNotFoundByIdException
     */
    public function findById(string $id, bool $notFoundError = false): ?object;

	/**
	 * @return object[]
	 */
	public function findAll(): array;
}
