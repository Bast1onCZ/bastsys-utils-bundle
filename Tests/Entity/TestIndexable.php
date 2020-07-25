<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Tests\Entity;

use BastSys\UtilsBundle\Entity\Identification\AUuidEntity;
use BastSys\UtilsBundle\Entity\Indexable\IIndexable;
use BastSys\UtilsBundle\Entity\Indexable\TIndexable;

/**
 * Class TestIndexable
 * @package BastSys\UtilsBundle\Tests\Entity
 * @author mirkl
 */
class TestIndexable extends AUuidEntity implements IIndexable
{
    use TIndexable;
}
