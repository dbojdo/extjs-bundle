<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use JMS\Serializer\Annotation as JMS;

class TreeNodeMoveAction {
	const POSITION_BEFORE = 'before';
	const POSITION_AFTER = 'after';
	const POSITION_APPEND = 'append';
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $item;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $targetItem;
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 */
	protected $position;

	/**
	 * @return the string
	 */
	public function getItem() {
		return $this->item;
	}
	
	/**
	 * @param string $item
	 */
	public function setItem($item) {
		$this->item = $item;
	}
	
	/**
	 * @return string
	 */
	public function getTargetItem() {
		return $this->targetItem;
	}
	
	/**
	 * @param string $targetItem
	 */
	public function setTargetItem($targetItem) {
		$this->targetItem = $targetItem;
	}
	
	/**
	 * @return string
	 */
	public function getPosition() {
		return $this->position;
	}
	
	/**
	 * @param string $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}
	
	
	
}