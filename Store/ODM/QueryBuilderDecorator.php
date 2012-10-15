<?php
namespace Webit\Bundle\ExtJsBundle\Store\ODM;

use Webit\Bundle\ExtJsBundle\Store\SorterCollection;
use Webit\Bundle\ExtJsBundle\Store\FilterCollection;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderDecorator {
	/**
	 * 
	 * @var QueryBuilder
	 */
	protected $qb;
	
	/**
	 * 
	 * @param QueryBuilder $qb
	 */
	public function __construct(QueryBuilder $qb) {
		$this->qb = $qb;
	}
	
	/**
	 * 
	 * @param FilterCollection $filterCollection
	 */
	public function applyFilters(FilterCollection $filterCollection) {
		foreach($filterCollection as $filter) {
			
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param SorterCollection $sorterCollection
	 */
	public function applySorters(SorterCollection $sorterCollection) {
		foreach($sorterCollection as $sorter) {
			// FIXME: uwzględnić alias oraz dashed to camelcase
			$property = $sorter->getProperty();
			$direction = $sorter->getDirection();
			
			$this->qb->addOrderBy($property,$direction);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $limit
	 */
	public function applyLimit($limit) {
		$this->qb->setMaxResults($limit);
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $offset
	 */
	public function applyOffset($offset) {
		$this->qb->setFirstResult($offset);
		
		return $this;
	} 
	
	/**
	 * 
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function getQueryBuilder() {
		return $this->qb;
	}
}
?>
