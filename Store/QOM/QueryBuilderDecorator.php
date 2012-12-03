<?php
namespace Webit\Bundle\ExtJsBundle\Store\QOM;

use Webit\Bundle\ExtJsBundle\Store\SorterCollection;
use Webit\Bundle\ExtJsBundle\Store\FilterCollection;
use PHPCR\Util\QOM\QueryBuilder;
use PHPCR\Query\QOM\QueryObjectModelFactoryInterface;

class QueryBuilderDecorator {
	/**
	 * 
	 * @var QueryBuilder
	 */
	protected $qb;
	
	/**
   * @var QueryObjectModelFactoryInterface
	 */
	protected $qf;
	
	/**
	 * 
	 * @param QueryBuilder $qb
	 */
	public function __construct(QueryBuilder $qb) {
		$this->qb = $qb;
		$this->qf = $qb->getQOMFactory();
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
		$qb = $this->qb;
		$qf = $this->qf;

		foreach($sorterCollection as $sorter) {
			$property = $this->getQueryProperty($sorter->getProperty());
			// FIXME: null powienien być zastąpiony aliasem noda, o którego pytamy
			$qb->addOrderBy($qf->propertyValue($property,null),$sorter->getDirection());
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

	public function applySearching($query,array $fields) {
		$qb = $this->qb;
		$qf = $this->qf;
		$constraint = null;
		
		foreach($fields as $field) {
			$field = $this->getQueryProperty($field);
			// FIXME: tylko po polach typu string
			// FIXME: możliwość ustalenia like %saf% lub %dfssa lub dsfd%
			// FIXME: możliwość ustalenia dodatkowych filtrów (lowercase, usuwanie białych znaków, przecinków itd)
			$c = $qf->comparison($qf->propertyValue($field,null), Constants::JCR_OPERATOR_LIKE, $qf->literal($query.'%'));
			if($constraint) {
				$constraint->orWhere($c);
			} else {
				$constraint = $qf->comparison($c);
			}
		}
	
		if($constraint) {
			$qb->andWhere($constraint);
		}
	
		return $this;
	}
	
	
	private function getQueryProperty($property) {
		$property = $this->underscoreToCamelCase($property);
	
		return $property;
	}
	
	private function underscoreToCamelCase($string, $capitalizeFirstCharacter = false) {
		$str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
	
		if (!$capitalizeFirstCharacter) {
			$str = lcfirst($str);
		}
	
		return $str;
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
