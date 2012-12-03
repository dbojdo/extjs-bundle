<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

interface FilterInterface {
	const COMPARISION_NOT = 'not';
	const COMPARISION_EQUAL = 'eq';
	const COMPARISION_GREATER = 'gt';
	const COMPARISION_LESS = 'lt';
	const COMPARISION_GREATER_OR_EQUAL = 'gte';
	const COMPARISION_LESS_OR_EQUAL = 'lte';
	
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_STRING = 'string';
	const TYPE_NUMERIC = 'numeric';
	const TYPE_DATE = 'date';
	const TYPE_DATETIME = 'datetime';
	const TYPE_LIST = 'list';
	
	public function getProperty();
	public function getValue();
	public function getType();
	public function getComparision();
}
?>
