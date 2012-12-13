<?php
namespace Webit\Bundle\ExtJsBundle\Store\ORM;

use Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface;

use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollectionInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollectionInterface;
use Doctrine\ORM\QueryBuilder;

class QueryBuilderDecorator {
	/**
	 * 
	 * @var QueryBuilder
	 */
	protected $qb;
	
	protected $propertyMap;
	
	/**
	 * 
	 * @param QueryBuilder $qb
	 */
	public function __construct(QueryBuilder $qb, $propertyMap = array()) {
		$this->qb = $qb;
		$this->propertyMap = $propertyMap;
	}
	
	/**
	 * 
	 * @param FilterCollection $filterCollection
	 */
	public function applyFilters(FilterCollectionInterface $filterCollection) {
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
			}
		}
		
		return $this;
	}
	
	protected function applyDateFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		$property = array_shift($property);
		
		$paramName = 'date_' . substr(md5(serialize($filter) . microtime()),0,10);
		$value = new \DateTime($filter->getValue());
		if($filter->getType() == FilterInterface::TYPE_DATE) {
			$value->setTime(0, 0, 0);
		}
		
		switch($filter->getComparision()) {
			case FilterInterface::COMPARISION_GREATER:
				$qb->andWhere($qb->expr()->gt($property,(':'.$paramName)));
				$qb->setParameter($paramName, $value,'datetime');
			break;
			case FilterInterface::COMPARISION_LESS:
				$qb->andWhere($qb->expr()->lt($property,(':'.$paramName)));
				$qb->setParameter($paramName, $value,'datetime');
			break;
			case FilterInterface::COMPARISION_LESS_OR_EQUAL:
				if($filter->getType() == FilterInterface::TYPE_DATE) {
					$value->add(new \DateInterval('P1D'));
					$qb->andWhere($qb->expr()->lt($property,(':'.$paramName)));
					$qb->setParameter($paramName, $value,'datetime');
				} else {
					$qb->andWhere($qb->expr()->lte($property,(':'.$paramName)));
					$qb->setParameter($paramName, $value,'datetime');
				}
			break;
			case FilterInterface::COMPARISION_GREATER_OR_EQUAL:
				$qb->andWhere($qb->expr()->gte($property,(':'.$paramName)));
				$qb->setParameter($paramName, $value,'datetime');
			break;
			default:
				// FilterInterface::COMPARISION_EQUAL:
				if($filter->getType() == FilterInterface::TYPE_DATE) {
					$qb->andWhere($qb->expr()->gte($property,(':'.$paramName)));
					$qb->setParameter($paramName, $value,'datetime');
					
					$valueTo = clone($value);
					$valueTo->add(new \DateInterval('P1D'));
					$valueTo = $valueTo->format('Y-m-d H:i:s');
					$qb->andWhere($qb->expr()->lt($property,(':'.$paramName.'_2')));
					$qb->setParameter(($paramName.'_2'), $valueTo,'datetime');
				} else {
					$qb->andWhere($qb->expr()->eq($property,(':'.$paramName)));
					$qb->setParameter($paramName, $value,'datetime');
				}
		}
	}
	
	protected function applyStringFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		$value = (string)$filter->getValue();
		
		$arCond = array();
		foreach($property as $f) {
			$arCond[] = $qb->expr()->like($f,$qb->expr()->literal($value));
		}
		
		if(count($arCond) > 0) {
			$this->qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $arCond));
		}
	}
	
	protected function applyNumericFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		$value = (float)$filter->getValue();
		$arCond = array();
		foreach($property as $f) {
			$arCond[] = $qb->expr()->eq($property,$this->expr()->literal($value));
			switch($filter->getComparision()) {
				case FilterInterface::COMPARISION_GREATER:
					$arCond[] = $qb->expr()->gt($property,$value);
					break;
				case FilterInterface::COMPARISION_LESS:
					$arCond[] = $qb->expr()->lt($property,$value);
					break;
				case FilterInterface::COMPARISION_LESS_OR_EQUAL:
					$arCond[] = $qb->expr()->lte($property,$value);
					break;
				case FilterInterface::COMPARISION_GREATER_OR_EQUAL:
					$arCond[] = $qb->expr()->gte($property,$value);
					break;
				case FilterInterface::COMPARISION_NOT:
					$arCond[] = $qb->expr()->neq($property,$value);
					break;
				default:
					//FilterInterface::COMPARISION_EQUAL:
					$arCond[] = $qb->expr()->eq($property,$value);
			}
		}
	
		if(count($arCond) > 0) {
			$this->qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $arCond));
		}
	}
	
	protected function applyBooleanFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		$value = (boolean)$filter->getValue();
		$arCond = array();
		foreach($property as $f) {
			$arCond[] = $qb->expr()->eq($f,$qb->expr()->literal($value));
		}
	
		if(count($arCond) > 0) {
			$this->qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $arCond));
		}
	}
	
	protected function applyListFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		$arValue = explode(',',$filter->getValue());
		
		$arCond = array();
		foreach($property as $f) {
			$arCond[] = $qb->expr()->in($property,$arValue);
		}
		
		$qb->andWhere($qb->expr()->orx($arCond));
	}
	
	/**
	 * 
	 * @param SorterCollection $sorterCollection
	 */
	public function applySorters(SorterCollectionInterface $sorterCollection) {
		foreach($sorterCollection as $sorter) {
			$arFields = $this->getQueryProperty($sorter->getProperty());
			foreach($arFields as $f) {
				$this->qb->addOrderBy($f,$sorter->getDirection());
			}
		}
		
		return $this;
	}
	
	public function applySearching($query,array $fields) {
		$qb = $this->qb;
		$arCond = array();
		foreach($fields as $field) {
			$arField = $this->getQueryProperty($field);
			// FIXME: tylko po polach typu string
			// FIXME: możliwość ustalenia like %saf% lub %dfssa lub dsfd%
			// FIXME: możliwość ustalenia dodatkowych filtrów (lowercase, usuwanie białych znaków, przecinków itd)
			foreach($arField as $f) {
				$arCond[] = $qb->expr()->like($f,$qb->expr()->literal($query.'%'));
			}
		}
		
		if(count($arCond) > 0) {
			$this->qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $arCond));
		}
	
		return $this;
	}
	
	private function getQueryProperty($property) {
		$name = (array)$this->underscoreToCamelCase($property);
		$alias = $this->qb->getRootAlias();

		if(key_exists($property,$this->propertyMap)) {
			$arProperty = $this->propertyMap[$property];
			$alias = isset($arProperty['alias']) ? $arProperty['alias'] : $alias;
			$name = isset($arProperty['name']) ? (array)$arProperty['name'] : $name;
		}
		
		if($alias) {
			$property = $alias .'.'.$name;
		}
		
		$arProperties = array();
		foreach($name as $n) {
			$a = $alias;
			if(is_array($n)) {
				$a = key_exists('alias',$n) ? $n['alias'] : $alias;
				$n = key_exists('name',$n) ? $n['name'] : array_shift($n);
			}
			$arProperties[] = $alias ? ($a. '.'.$n) : $n; 
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
	 * @param integer $limit
	 */
	public function applyLimit($limit) {
		if((int)$limit > 0) {
			$this->qb->setMaxResults($limit);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $offset
	 */
	public function applyOffset($offset) {
		if((int)$offset > 0) {
			$this->qb->setFirstResult($offset);
		}
		
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
