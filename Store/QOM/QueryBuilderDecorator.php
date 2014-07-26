<?php
namespace Webit\Bundle\ExtJsBundle\Store\QOM;

use PHPCR\Query\QOM\QueryObjectModelConstantsInterface as Constants;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface;
use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollection;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollection;
use PHPCR\Util\QOM\QueryBuilder;
use PHPCR\Query\QOM\QueryObjectModelFactoryInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterParams;

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
	 * @var array
	 */
	protected $propertyMap;
	
	/**
	 * 
	 * @param QueryBuilder $qb
	 */
	public function __construct(QueryBuilder $qb, array $propertyMap = array()) {
		$this->qb = $qb;
		$this->qf = $qb->getQOMFactory();
		$this->propertyMap = $propertyMap;
	}
	
	/**
	 * 
	 * @param FilterCollection $filterCollection
	 */
	public function applyFilters(FilterCollection $filterCollection) {
		foreach($filterCollection as $filter) {
			$property = $filter->getProperty();
			$property = $this->getQueryProperty($property);
			switch($filter->getType()) {
				case FilterInterface::TYPE_STRING:
					$this->applyStringFilter($property, $filter);
				break;
				case FilterInterface::TYPE_NUMERIC:
					$this->applyNumericFilter($property, $filter);
				break;
				case FilterInterface::TYPE_DATE:
				case FilterInterface::TYPE_DATETIME:
					$this->applyDateFilter($property, $filter);
				break;
				case FilterInterface::TYPE_BOOLEAN:
					$this->applyBooleanFilter($property, $filter);
				break;
				case FilterInterface::TYPE_LIST:
					$this->applyListFilter($property, $filter);
				break;
				case FilterInterface::TYPE_NODE:
					$this->applyNodeFilter($property, $filter);
				break;
			}
		}
		
		return $this;
	}

	protected function applyNodeFilter($arFields, FilterInterface $filter) {
		$qb = $this->qb;
		$qf = $this->qf;
		
		$constraint = null;
		foreach($arFields as $qField) {
			switch($filter->getComparision()) {
				case FilterInterface::COMPARISION_CHILD:
					$c = $qf->childNode($filter->getValue(),$qField->getAlias());
				break;
				case FilterInterface::COMPARISION_DESCENDANT:
					$c = $qf->descendantNode($filter->getValue(),$qField->getAlias());
				break;
				case FilterInterface::COMPARISION_CHILD_OR_EQUAL:
					$c = $qf->orConstraint($qf->childNode($filter->getValue(),$qField->getAlias()),
						$qf->sameNode($filter->getValue(),$qField->getAlias()));
				break;
				case FilterInterface::COMPARISION_DESCENDANT_OR_EQUAL:
					$c = $qf->orConstraint($qf->descendantNode($filter->getValue(),$qField->getAlias()),
					$qf->sameNode($filter->getValue(),$qField->getAlias()));
				break;
				default:
					$c = $qf->sameNode($filter->getValue(),$qField->getAlias());
			}
			
			if($constraint) {
				$constraint = $qf->orConstraint($constraint,$c);
			} else {
				$constraint = $c;
			}
		}
		
		if($constraint) {
			$qb->andWhere($constraint);
		}
	}
	
	protected function applyChildFilter($arFields, FilterInterface $filter) {
		$qb = $this->qb;
		$qf = $this->qf;
	
		$constraint = null;
		foreach($arFields as $qField) {
			$c = $qf->childNode($filter->getValue(),$f->getAlias());
			if($constraint) {
				$constraint = $qf->orConstraint($constraint,$c);
			} else {
				$constraint = $c;
			}
		}
	
		if($constraint) {
			$qb->andWhere($constraint);
		}
	}
	
	public function applyStringFilter($arFields, FilterInterface $filter) {
		$value = $filter->getValue();
		if(empty($value)) {
			return;
		}
		
		$qb = $this->qb;
		$qf = $this->qf;
		
		$constraint = null;
		foreach($arFields as $qField) {
		    $value = $this->resolveStringValue($filter->getValue(), $filter->getParams());
			$c = $qf->comparison($qf->propertyValue($qField->getName(),$qField->getAlias()), Constants::JCR_OPERATOR_LIKE, $qf->literal($value));
			if($constraint) {
				$constraint = $qf->orConstraint($constraint,$c);
			} else {
				$constraint = $c;
			}
		}
		
		if($constraint) {
			$qb->andWhere($constraint);
		}
	}
	
	private function resolveStringValue($value, FilterParams $params)
	{
	    switch($params->getLikeWildcard()) {
	    	case FilterParams::LIKE_WILDCARD_LEFT:
	    	    $value = ('%'.$value);
	    	    break;
    	    case FilterParams::LIKE_WILDCARD_RIGHT:
    	        $value = ($value .'%');
	           break;
	        case FilterParams::LIKE_WILDCARD_BOTH:
	            $value = ('%' . $value . '%');
	            break;
	    }
	    
	    return $value;
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
			foreach($property as $queryField) {
				$qb->addOrderBy($qf->propertyValue($queryField->getName(),$queryField->getAlias()),$sorter->getDirection());
			}
		}
		
		return $this;
	}

	/**
	 * 
	 * @param integer $limit
	 */
	public function applyLimit($limit) {
		if($limit === null || (int)$limit > 0) {
			$this->qb->setMaxResults($limit);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $offset
	 */
	public function applyOffset($offset) {
		if($offset === null || (int)$offset > 0) {
			$this->qb->setFirstResult($offset);
		}
		
		return $this;
	}

	public function applySearching($query,array $fields) {
		$qb = $this->qb;
		$qf = $this->qf;
		
		$constraint = null;
		foreach($fields as $field) {
			$arFields = $this->getQueryProperty($field);
			
			foreach($arFields as $qField) {
				$c = $qf->comparison($qf->propertyValue($qField->getName(),$qField->getAlias()), Constants::JCR_OPERATOR_LIKE, $qf->literal($query.'%'));
				if($constraint) {
					$constraint = $qf->orConstraint($constraint,$c);
				} else {
					$constraint = $c;
				}
			}
			// FIXME: tylko po polach typu string
			// FIXME: możliwość ustalenia like %saf% lub %dfssa lub dsfd%
			// FIXME: możliwość ustalenia dodatkowych filtrów (lowercase, usuwanie białych znaków, przecinków itd)
		}
	
		if($constraint) {
			$qb->andWhere($constraint);
		}
	
		return $this;
	}
	
	private function getQueryProperty($property) {
		$name = (array)$this->underscoreToCamelCase($property);
		$alias = key_exists('_rootAlias',$this->propertyMap) ? $this->propertyMap['_rootAlias'] : null;

		if(key_exists($property,$this->propertyMap)) {
			$arProperty = $this->propertyMap[$property];
			$alias = isset($arProperty['alias']) ? $arProperty['alias'] : $alias;
			$name = isset($arProperty['name']) ? (array)$arProperty['name'] : $name;
		}
		
		$arProperties = array();
		foreach($name as $n) {
			$a = $alias;
			if(is_array($n)) {
				$a = key_exists('alias',$n) ? $n['alias'] : $alias;
				$n = key_exists('name',$n) ? $n['name'] : array_shift($n);
			}
			$qProperty = new QueryField();
			$qProperty->setAlias($a);
			$qProperty->setName($n);
			$arProperties[] = $qProperty; 
		}
		
		return $arProperties;
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
