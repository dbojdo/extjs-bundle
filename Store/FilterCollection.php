<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method FilterInterface get()
 */
class FilterCollection extends ArrayCollection {
	public function add($value) {
		if($value instanceof FilterInterface) {
			parent::add($filter);
		} else {
			throw new \InvalidArgumentException('Given value must be instance of Webit\Bundle\ExtJsBundle\Store\FilterInterface');
		}
	}
	
	public function toArray() {
		$arFilters = array();
		foreach($this as $filter) {
			$arFilter = array($filter->getProperty() => $filter->getValue());
			$arFilters[] = $arFilter;
		}
		
		return $arFilters;
	}
}
?>
