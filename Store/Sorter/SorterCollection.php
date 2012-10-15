<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author dbojdo
 * @method SorterInterface get()
 */
class SorterCollection extends ArrayCollection implements SorterCollectionInterface {
	
	/**
	 * 
	 * @param string $property
	 * @return SorterInterface|NULL
	 */
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
