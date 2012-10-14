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
	/**
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $property;
	
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
		return $this->property;
	}

	public function getValue() {
		return $this->value;
	}
}