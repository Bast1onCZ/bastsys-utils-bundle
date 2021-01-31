<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Input;

use BastSys\UtilsBundle\Model\Lists\Output\UnknownPageException;
use InvalidArgumentException;

/**
 * Class Pagination
 * @package BastSys\UtilsBundle\Model\Lists\Input
 * @author mirkl
 */
class Pagination
{
	/**
	 * @param int $page
	 * @param int $itemsPerPage
	 *
	 * @return self
	 */
	public static function constructFromPage(int $page, int $itemsPerPage): self
	{
		return new Pagination(
			($page - 1) * $itemsPerPage,
			$itemsPerPage
		);
	}

	/** @var int */
	private int $limit;

	/** @var int */
	private int $offset;

	/**
	 * Creates pagination structure
	 *
	 * @param integer $offset how many items are skipped
	 * @param integer $limit  how many items are returned
	 */
	public function __construct(int $offset, int $limit)
	{
		if ($offset < 0) {
			throw new InvalidArgumentException("Invalid offset ($offset)");
		}

		$this->offset = $offset;
		$this->limit = $limit;
	}

	/**
	 * @return int
	 */
	public function getLimit(): int
	{
		return $this->limit;
	}

	/**
	 * @return int
	 */
	public function getOffset(): int
	{
		return $this->offset;
	}

	/**
	 * @return bool
	 */
	public function hasValidPage(): bool {
		return $this->offset % $this->limit === 0;
	}

	/**
	 * @return int|null
	 * @throws UnknownPageException
	 */
	public function getPage(): int {
		if(!$this->hasValidPage()) {
			throw new UnknownPageException();
		}

		return ($this->offset / $this->limit) + 1;
	}
}
