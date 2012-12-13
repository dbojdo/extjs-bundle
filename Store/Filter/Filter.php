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
	
	/**
   * @var FilterParams
   * @JMS\Type("Webit\Bundle\ExtJsBundle\Store\Filter\FilterParams")
	 */
	protected $params;
	
	public function __construct($property, $value, FilterParams $params = null) {
		$this->property = $property;
		$this->value = $value;
		$this->params = $params ?: new FilterParams();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface::getProperty()
	 */
	public function getProperty() {
		$property = empty($this->property) == false ? $this->property : $this->field;
		return $property;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface::getValue()
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface::getComparision()
	 */
	public function getComparision() {
		return $this->comparision;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface::getType()
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Webit\Bundle\ExtJsBundle\Store\Filter\FilterInterface::getParams()
	 */
	public function getParams() {
		return $this->params ?: new FilterParams();
	}
}