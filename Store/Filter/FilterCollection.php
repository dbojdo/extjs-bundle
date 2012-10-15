<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method FilterInterface get()
 */
class FilterCollection extends ArrayCollection implements FilterCollectionInterface {

	/**
	 * 
	 * @param string $property
	 * @return FilterInterface|NULL
	 */
	public function getFilter($property) {
		foreach($this as $item) {
			if($item->getProperty() == $property) {
				return $item;
			}
		}
		
		return null;
	}
}
?>
