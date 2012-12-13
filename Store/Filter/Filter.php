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
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $alias;
	
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
	
	public function __construct($property,$value,$alias = null) {
		$this->property = $property;
		$this->value = $value;
		$this->alias = $alias;
	}
	
	public function getProperty() {
		$property = empty($this->property) == false ? $this->property : $this->field;
		return $property;
	}

	
	public function getAlias() {
		return $this->alias;
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
	
	/**
	 * @JMS\PostDeserialize
	 */
	public function postDeserialize() {
		$property = $this->getProperty();
		$arProperty = explode('.',$property);
		if(count($arProperty) > 1) {
			if($this->property) {
				$this->property = array_pop($arProperty);
			} else {
				$this->field = array_pop($arProperty);
			}
			
			$this->alias = array_pop($arProperty);
		}
	}
}