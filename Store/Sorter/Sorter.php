<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

use JMS\Serializer\Annotation as JMS;

class Sorter implements SorterInterface {

	/**
   * @var string
   * @JMS\Type("string")
	 */
	protected $property;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $direction;
	
	public function __construct($property,$direction = SorterInterface::DIRECTION_ASC) {
		$this->property = $property;
		$this->direction = $direction;
	}
	
	public function getProperty() {
		return $this->property;
	}

	public function getDirection() {
		return $this->direction;
	}
}
?>
