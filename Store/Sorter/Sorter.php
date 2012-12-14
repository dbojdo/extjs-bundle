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
	
	/**
	 *
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $alias;
	
	public function __construct($property, $direction = SorterInterface::DIRECTION_ASC) {
		$this->property = $property;
		$this->direction = $direction;
	}
	
	public function getProperty() {
		return $this->property;
	}

	public function getDirection() {
		return $this->direction;
	}
	
	public function getAlias() {
		return $this->alias;
	}
	
	/**
	 * @JMS\PostDeserialize
	 */
	public function postDeserialize() {
		$property = $this->getProperty();
		$arProperty = explode('.',$property);
		if(count($arProperty) > 1) {
			$this->property = array_pop($arProperty);
			$this->alias = array_pop($arProperty);
		}
	}
}
?>
