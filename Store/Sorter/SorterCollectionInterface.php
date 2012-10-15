<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

interface SorterCollectionInterface extends \Traversable {
	/**
	 * 
	 * @param string $property
	 * @return SorterInterface|NULL
	 */
	public function getSorter($property);
}