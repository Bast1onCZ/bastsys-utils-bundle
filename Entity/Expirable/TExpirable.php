<?php

namespace BastSys\UtilsBundle\Entity\Expirable;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime|null
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiration;

    /**
     * @return bool
     * @throws \Exception
     */
    public function hasExpired(): bool {
        return $this->expiration && $this->expiration < new \DateTimeImmutable();
    }

    /**
     * @return \DateTime|null
     */
    public function getExpiration(): ?\DateTime {
        return $this->expiration;
    }

    /**
     * @param \DateTime|null $expiration
     */
    public function setExpiration(?\DateTime $expiration): void {
        $this->expiration = $expiration;
    }
}
