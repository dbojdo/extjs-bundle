<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\SorterInterface;

class Sorter implements SorterInterface {
	const DIRECTION_ASC = 'ASC';
	const DIRECTION_DESC = 'DESC';
	
	protected $property;
	protected $direction;
	
	public function __construct($property,$direction = self::DIRECTION_ASC) {
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
