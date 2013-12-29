<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

interface TreeStoreInterface {
	/**
	 * 
	 * @param string $id
	 */
	public function loadNode($id = null);
	
	/**
	 * 
	 * @param string $node
	 * @param string $targetNode
	 * @param string $position
	 */
// 	public function moveNode($node, $targetNode, $position);
}
?>
