<?php

namespace BastSys\UtilsBundle\Entity;

use BastSys\UtilsBundle\Entity\Identification\IIdentifiableEntity;

/**
 * Interface ITree
 *
 * Represents a class that has a parent of same type and simultaneously has children of the same type
 *
 * @package BastSys\UtilsBundle\Entity
 */
interface ITree extends IIdentifiableEntity
{
    /**
     * @param ITree $child
     *
     * @return ITree
     */
    function addChild(ITree $child): self;

    /**
     * @param ITree $child
     *
     * @return ITree
     */
    function removeChild(ITree $child): self;

    /**
     * @return ITree
     */
    function getParent(): ?ITree;

    /**
     * @param ITree $tree
     *
     * @return ITree
     */
    function setParent(?ITree $tree): self;
}
