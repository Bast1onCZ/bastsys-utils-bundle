<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Output;

use BastSys\UtilsBundle\Model\Lists\Input\Pagination;

/**
 * Class PageInfo
 * @package BastSys\UtilsBundle\Model\Lists\Output
 * @author  mirkl
 */
class PageInfo
{
	/** @var Pagination */
	private Pagination $pagination;

	/** @var bool */
	private bool $hasNextPage;

    /**
     * PageInfo constructor.
     * @param Pagination $pagination
     * @param int $totalCount
     */
    public function __construct(Pagination $pagination, int $totalCount)
	{
		$this->pagination = $pagination;
		$this->hasNextPage = $pagination->getLimit() + $pagination->getOffset() < $totalCount;
	}

    /**
     * @return bool
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
