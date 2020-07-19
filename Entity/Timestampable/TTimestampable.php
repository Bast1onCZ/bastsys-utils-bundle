<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Timestampable;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait TTimestampable
 * @package BastSys\UtilsBundle\Entity\Timestampable
 * @author  mirkl
 *
 * @ORM\MappedSuperclass()
 */
trait TTimestampable
{
	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	private $updatedAt;

	/**
	 * Use this method in entity constructor
	 *
	 * @throws \Exception
	 */
	protected function setCreatedAt(): void {
		$this->createdAt = new \DateTimeImmutable();
		$this->updatedAt = new \DateTimeImmutable();
	}

    /**
     * Use this method whenever entity is updated
     *
     * @throws \Exception
     */
    protected function setUpdatedAt(): void {
		$this->updatedAt = new \DateTimeImmutable();
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt(): \DateTime
	{
		return $this->updatedAt;
	}
}
