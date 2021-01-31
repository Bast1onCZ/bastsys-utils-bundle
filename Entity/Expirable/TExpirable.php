<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Expirable;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * Trait TExpirable
 * @package BastSys\UtilsBundle\Entity\Expirable
 * @author mirkl
 *
 * @ORM\MappedSuperclass()
 */
trait TExpirable
{
    /**
     * @var DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
	private ?DateTime $expiration;

    /**
     * @return bool
     * @throws Exception
     */
    public function hasExpired(): bool {
        return $this->expiration && $this->expiration < new DateTimeImmutable();
    }

    /**
     * @return DateTime|null
     */
    public function getExpiration(): ?DateTime {
        return $this->expiration;
    }

    /**
     * @param DateTime|null $expiration
     */
    public function setExpiration(?DateTime $expiration): void {
        $this->expiration = $expiration;
    }
}
