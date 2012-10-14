<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method SorterInterface get()
 */
class SorterCollection extends ArrayCollection {
	public function getSorter($property) {
		foreach($this as $item) {
			if($item->getProperty() == $property) {
				return $item;
			}
		}
		
		return null;
	}
}
?>
