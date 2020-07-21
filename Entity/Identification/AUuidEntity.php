<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Entity\Identification;

use BastSys\UtilsBundle\Model\IEquatable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class AUuidEntity
 * @package BastSys\UtilsBundle\Entity\Identification
 * @author mirkl
 *
 * @ORM\MappedSuperclass()
 */
abstract class AUuidEntity implements IUuidEntity
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
        $this->id = (string) Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param IEquatable $comparable
     * @return bool
     */
    public function equals($comparable): bool
    {
        return get_class($comparable) === get_class($this) && $comparable->getId() === $this->id;
    }
}
