<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Repository;

use BastSys\UtilsBundle\Exception\Entity\EntityNotFoundByIdException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

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
