<?php
namespace Webit\Bundle\ExtJsBundle\ExtJs\Request;
use JMS\SerializerBundle\Annotation\Type;

class SortInfo {
	/**
	 * @Type("string")
	 * @var string
	 */
	protected $field;
	
	/**
	 * 
	 * @Type("string")
	 */
	protected $direction;
	
	/**
	 * @return string
	 */
	public function getField() {
		return $this->field;
	}
	
	/**
	 * @return string 
	 */
	public function getDirection() {
		return $this->direction;
	}
}
?>