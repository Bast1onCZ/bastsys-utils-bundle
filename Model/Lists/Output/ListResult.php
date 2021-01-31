<?php
declare(strict_types=1);

namespace BastSys\UtilsBundle\Model\Lists\Output;

use BastSys\UtilsBundle\Model\Lists\Input\Pagination;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class ListResult
 * @package BastSys\UtilsBundle\Model\Lists\Output
 * @author mirkl
 */
class ListResult
{
	/** @var int */
	private int $totalCount;

	/** @var PageInfo */
	private PageInfo $pageInfo;

	/** @var array */
	private array $edges;

	/**
	 * ListResult constructor.
	 *
	 * @param Paginator  $paginator
	 * @param Pagination $pagination
	 *
	 * @throws \Exception
	 */
    public function __construct(Paginator $paginator, Pagination $pagination)
	{
		$this->totalCount = $paginator->count();
		$this->pageInfo = new PageInfo($pagination, $this->totalCount);
		$this->edges = $paginator->getIterator()->getArrayCopy();
	}

	/**
	 * @return array
	 */
	public function getEdges(): array
	{
		return $this->edges;
	}

	/**
	 * @return PageInfo
	 */
	public function getPageInfo(): PageInfo
	{
		return $this->pageInfo;
	}

	/**
	 * @return int
	 */
	public function getTotalCount(): int
	{
		return $this->totalCount;
	}
}
