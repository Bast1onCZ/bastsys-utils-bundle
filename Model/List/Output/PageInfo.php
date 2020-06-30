<?php

namespace BastSys\UtilsBundle\Model\ListStructure\Output;

use BastSys\UtilsBundle\Model\ListStructure\Input\Pagination;

/**
 * Class PageInfo
 * @package BastSys\UtilsBundle\Model\ListStructure\Output
 * @author  mirkl
 */
class PageInfo
{
	/** @var Pagination */
	private $pagination;

	/** @var bool */
	private $hasNextPage;

	public function __construct(Pagination $pagination, int $totalCount)
	{
		$this->pagination = $pagination;
		$this->hasNextPage = $pagination->getLimit() + $pagination->getOffset() < $totalCount;
	}

	/**
	 * @return int
	 */
	public function getHasNextPage(): bool
	{
		return $this->hasNextPage;
	}

	/**
	 * @return int
	 */
	public function getLimit(): int
	{
		return $this->pagination->getLimit();
	}

	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->pagination->getOffset();
	}

	/**
	 * @return bool
	 */
	public function hasValidPage(): bool {
		return $this->pagination->hasValidPage();
	}

	/**
	 * @return int
	 * @throws UnknownPageException
	 */
	public function getPage(): int {
		return $this->pagination->getPage();
	}
}
