<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\FilterInterface;
use JMS\SerializerBundle\Annotation as JMS;

/**
 * 
 * @author dbojdo
 *
 */
class Filter implements FilterInterface {
	const COMPARISION_EQUAL = 'eq';
	const COMPARISION_GREATER_THAN = 'gt';
	const COMPARISION_LESS_THAN = 'lt';
	
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_STRING = 'string';
	const TYPE_NUMERIC = 'numeric';
	const TYPE_DATE = 'date';
	const TYPE_LIST = 'list';
	
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
	protected $type = self::TYPE_STRING;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $comparision = self::COMPARISION_EQUAL;
	
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