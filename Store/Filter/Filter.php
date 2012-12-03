<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

use JMS\Serializer\Annotation as JMS;

/**
 * 
 * @author dbojdo
 *
 */
class Filter implements FilterInterface {	
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
	protected $field;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $type = FilterInterface::TYPE_STRING;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $comparision = FilterInterface::COMPARISION_EQUAL;
	
	/**
	 * 
	 * @var mixed
	 * @JMS\Type("string")
	 */
	protected $value;
	
	public function __construct($property,$value) {
		$this->property = $property;
		$this->value = $value;
	}
	
	public function getProperty() {
		$property = empty($this->property) == false ? $this->property : $this->field;
		return $property;
	}

	public function getValue() {
		return $this->value;
	}
	
	public function getComparision() {
		return $this->comparision;
	}
	
	public function getType() {
		return $this->type;
	}
}