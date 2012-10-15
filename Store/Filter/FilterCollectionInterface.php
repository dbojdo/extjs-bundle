<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

interface FilterCollectionInterface extends \Traversable {
	/**
	 * 
	 * @param string $property
	 * @return FilterInterface|NULL
	 */
	public function getFilter($property);
}