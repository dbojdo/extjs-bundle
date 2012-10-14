<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method FilterInterface get()
 */
class FilterCollection extends ArrayCollection {

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
