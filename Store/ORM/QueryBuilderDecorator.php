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
					$this->applyStringFilter($property, $filter);
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
		$paramName = 'string_' . substr(md5(serialize($filter) . microtime()),0,10);
		$qb = $this->qb;
		$value = (string)$filter->getValue();
		$qb->andWhere($qb->expr()->eq($property,':'.$paramName));
		$qb->setParameter($paramName,$value,\Doctrine\DBAL\Types\Type::STRING);
	}
	
	protected function applyNumericFilter($property, FilterInterface $filter) {
		$qb = $this->qb;
		
		$paramName = 'number_' . substr(md5(serialize($filter) . microtime()),0,10);
		
		$value = $filter->getValue();
		switch($filter->getComparision()) {
			case FilterInterface::COMPARISION_GREATER:
				$qb->andWhere($qb->expr()->gt($property,':' . $paramName));
				break;
			case FilterInterface::COMPARISION_LESS:
				$qb->andWhere($qb->expr()->lt($property,':' . $paramName));
				break;
			case FilterInterface::COMPARISION_LESS_OR_EQUAL:
				$qb->andWhere($qb->expr()->lte($property,':' . $paramName));
				break;
			case FilterInterface::COMPARISION_GREATER_OR_EQUAL:
				$qb->andWhere($qb->expr()->gte($property,':' . $paramName));
				break;
			default:
				//FilterInterface::COMPARISION_EQUAL:
				$qb->andWhere($qb->expr()->eq($property,':' . $paramName));
		}
		$qb->setParameter($paramName,$value,\Doctrine\DBAL\Types\Type::FLOAT);
	}
	
	protected function applyBooleanFilter($property, FilterInterface $filter) {
		$value = (boolean)$filter->getValue();
		$paramName = 'number_' . substr(md5(serialize($filter) . microtime()),0,10);
		
		$qb->andWhere($qb->expr()->eq($property,':' . $paramName));
		$qb->setParameter($paramName,$value,\Doctrine\DBAL\Types\Type::BOOLEAN);
	}
	
	protected function applyListFilter($property, FilterInterface $filter) {
		$arValue = explode(',',$filter->getValue());
		$paramName = 'list_' . substr(md5(serialize($filter) . microtime()),0,10);
		$qb = $this->qb;
		$qb->andWhere($qb->expr()->in($property,':'. $paramName));
		$qb->setParameter($paramName,$arValue);
	}
	
	/**
	 * 
	 * @param SorterCollection $sorterCollection
	 */
	public function applySorters(SorterCollectionInterface $sorterCollection) {
		foreach($sorterCollection as $sorter) {
			$property = $sorter->getProperty();
			$property = $this->getQueryProperty($property);

			$direction = $sorter->getDirection();
			
			$this->qb->addOrderBy($property,$direction);
		}
		
		return $this;
	}
	
	public function applySearching($query,array $fields) {
		$qb = $this->qb;
		$arCond = array();
		foreach($fields as $field) {
			$field = $this->qb->getRootAlias() . '.'.$this->underscoreToCamelCase($field);
			// FIXME: tylko po polach typu string
			// FIXME: możliwość ustalenia like %saf% lub %dfssa lub dsfd%
			// FIXME: możliwość ustalenia dodatkowych filtrów (lowercase, usuwanie białych znaków, przecinków itd)
			$arCond[] = $qb->expr()->like($field,$qb->expr()->literal($query.'%'));
		}
		
		if(count($arCond) > 0) {
			$this->qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $arCond));
		}
	
		return $this;
	}
	
	private function getQueryProperty($property) {
		$property = $this->underscoreToCamelCase($property);
		if($this->qb->getRootAlias()) {
			$property = $this->qb->getRootAlias() .'.'.$property;
		}
		
		return $property;
	}
	
	private function underscoreToCamelCase($string, $capitalizeFirstCharacter = false) {
		$str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
	
		if (!$capitalizeFirstCharacter) {
			$str = lcfirst($str);
		}
	
		return $str;
	}
	
	protected function getEntityClass($property) {
		
	}
	
	/**
	 * 
	 * @param integer $limit
	 */
	public function applyLimit($limit) {
		if($limit > 0) {
			$this->qb->setMaxResults($limit);
		}
		
		return $this;
	}
	
	/**
	 * 
	 * @param integer $offset
	 */
	public function applyOffset($offset) {
		if($offset > 0) {
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
