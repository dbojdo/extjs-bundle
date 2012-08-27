<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method FilterInterface get()
 */
class SorterCollection extends ArrayCollection {
	public function add($value) {
		if($value instanceof SorterInterface) {
			parent::add($filter);
		} else {
			throw new \InvalidArgumentException('Given value must be instance of Webit\Bundle\ExtJsBundle\Store\SorterInterface');
		}
	}
	
	public function toArray() {
		$arSorters = array();
		foreach($this as $sorter) {
			$arSorter = array($sorter->getProperty() => $sorter->getDirection());
			$arSorters[] = $arSorter;
		}
		
		return $arSorters;
	}
}
?>
