<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Timestampable;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

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
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
	private DateTimeImmutable $createdAt;

    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
	private DateTimeImmutable $updatedAt;

    /**
     * Use this method in entity constructor
     *
     * @throws Exception
     */
    protected function setCreatedAt(): void {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Use this method whenever entity is updated
     *
     * @throws Exception
     */
    protected function setUpdatedAt(): void {
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return DateTime::createFromImmutable($this->createdAt);
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return DateTime::createFromImmutable($this->updatedAt);
    }
}
