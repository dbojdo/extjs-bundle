<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use JMS\SerializerBundle\Annotation\Type;
use Doctrine\Common\Collections\ArrayCollection;

class TreeNodeData {	
	/**
	 * 
	 * @var mixed
	 */
	public $id;
	
	/**
	 * 
	 * @var string
	 * @Type("string")
	 */
	public $text;
	
	/**
	 * 
	 * @var mixed
	 */
	public $parentId;
	
	/**
	 * 
	 * @var int
	 * @Type("integer")
	 */
	public $index;
	
	/**
	 * 
	 * @var int
	 * @Type("integer")
	 */
	public $depth = 0;
	
	/**
   * @var boolean
   * @Type("boolean")
	 */
	public $expanded = false;
	
	/**
	 * @var boolean
	 * @Type("boolean")
	 */
	public $expandable = true;	

	/**
	 * @var string
	 */
	public $checked;
	
	/**
	 * @var boolean
	 * @Type("boolean")
	 */
	public $leaf = false;
	
	/**
	 * 
	 * @var string
	 * @Type("string")
	 */
	public $cls;

	/**
	 *
	 * @var string
	 * @Type("string")
	 */
	public $iconCls;
	
	/**
	 *
	 * @var string
	 * @Type("string")
	 */
	public $icon;
	
	/**
	 * 
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $root = false;
	
	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $isLast = false;
	
	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $isFirst = false;
	
	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $allowDrop = true;
	
	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $allowDrag = true;

	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $loaded = false;
	
	/**
	 *
	 * @var Boolean
	 * @Type("boolean")
	 */
	public $loading = false;
	
	/**
	 * @var string
	 * @Type("string")
	 */
	public $href;
	
	/**
	 * @var string
	 * @Type("string")
	 */
	public $hrefTarget;
	
	/**
	 * @var string
	 * @Type("string")
	 */
	public $qtip;
	
	/**
	 * @var string
	 * @Type("string")
	 */
	public $qtitle;
	
	/**
	 * @var string
	 * @Type("ArrayCollection<Webit\Bundle\ExtJsBundle\TreeStore\TreeNodeData>")
	 */
	public $children;
	
	public function __construct() {
		$this->children = new ArrayCollection();
	}
}
?>
