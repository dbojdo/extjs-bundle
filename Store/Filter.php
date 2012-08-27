<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\FilterInterface;

class Filter implements FilterInterface {
	protected $property;
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