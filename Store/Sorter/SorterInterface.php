<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

interface SorterInterface {
	const DIRECTION_ASC = 'ASC';
	const DIRECTION_DESC = 'DESC';
	
	/**
	 * @return string
	 */
	public function getProperty();
	
	/**
	 * @return string
	 */
	public function getDirection();	
}
?>
