<?php

namespace BastSys\UtilsBundle\Entity\Identification;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class AUuidEntity
 * @package BastSys\UtilsBundle\Entity\Identification
 * @author mirkl
 *
 * @ORM\MappedSuperclass()
 */
class AUuidEntity implements IUuidEntity
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(length=255)
     */
    private string $id;

    /**
     * AUuidEntity constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
