<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Persistence\ObjectManager;
use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;

/**
 * Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreAbstract
 * @author dbojdo
 *
 */
abstract class TreeStoreAbstract extends ContainerAware implements TreeStoreInterface {
	/**
	 * 
	 * @var ObjectManager
	 */
	protected $om;
	
	/**
   * @var array
	 */
	protected $serializerGroups = array();
	
	public function __construct(ObjectManager $om) {
		$this->om = $om;
	}

	public function init() {
		// template method for init service
	}
	
	public function loadNode($id = null) {
		$id = $id ?: 'root';
		
		$collData = $this->fetchNode($id);
		
		$response = new ExtJsJson();
		$response->setData($collData);
		$response->setSerializerGroups($this->serializerGroups);
		return $response;
	}
	
	abstract protected function fetchNode($id);
	
	/**
	 *
	 * @param string $node
	 * @param string $targetNode
	 * @param string $position
	 */
	public function moveNode($node, $targetNode, $position) {
		throw new \RuntimeException('Moving is not supported by this store.');
	}
}
?>