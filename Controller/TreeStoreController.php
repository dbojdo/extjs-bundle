<?php
namespace Webit\Bundle\ExtJsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;

use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Response;

use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreInterface;
use JMS\Serializer\SerializationContext;

/**
 * 
 * @author dbojdo
 * @FOS\NamePrefix("webit_extjs_")
 */
class TreeStoreController extends FOSRestController {
		/**
		 * 
		 * @var TreeStoreInterface
		 */
		protected $store;

		/**
		 * Returns children of given node
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\QueryParam(name="node", default="root",description="Page of the overview.")
		 * @FOS\Route("/tree/load")
		 *
		 * @param ParamFetcher $paramFetcher
		 */
		public function loadNodeAction(ParamFetcher $paramFetcher) {
			
			$json = $this->getStore()->loadNode($paramFetcher->get('id'));
			
			$r = $this->createResponse($json);
    	return $r;
		}
		
		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\QueryParam(name="node", default="root",description="Page of the overview.")
		 * @FOS\Route("/tree/node-data")
		 */
		public function getNodeAction(ParamFetcher $paramFetcher) {
			$json = $this->getStore()->loadNode($paramFetcher->get('node'));
			
			$r = $this->createResponse($json);
			return $r;
		}

		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node")
		 */
		public function postNodeAction() {
			$store = $this->getStore();
			$arNodes = $this->get('serializer')->deserialize($this->getRequest()->getContent(),$store->getDataClass());
			
			//$json = $this->getStore()->createNodes();
		}
		
		/**
		 * Move node action
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node")
		 */
		public function putNodeAction() {
			$store = $this->getStore();
			$moveAction = $this->get('serializer')->deserialize($this->getRequest()->getContent(),'Webit\Bundle\ExtJsBundle\TreeStore\TreeNodeMoveAction','json');
			
			$json = $this->getStore()->moveNode($moveAction->getItem(), $moveAction->getTargetItem(), $moveAction->getPosition());
			
			$r = $this->createResponse($json);
			return $r;
		}
		
		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node")
		 */
		public function deleteNodeAction() {
			
		}
		
		protected function getStore() {
			if(is_null($this->store)) {
				$this->setStoreService();
			}
			 
			return $this->store;
		}
		
		protected function setStoreService() {
			$storeId = $this->getRequest()->query->get('store');
			$this->store = $this->findStoreService($storeId);
		}
		
		/**
		 *
		 * @param string $storeId
		 * @throws \RuntimeException
		 * @throws \InvalidArgumentException
		 * @return \Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface
		 */
		protected function findStoreService($storeId) {
			if($this->container->has($storeId) == false) {
				throw new \RuntimeException('Required service couldn\'t be found is service container.');
			}
			 
			$storeService = $this->container->get($storeId);
			 
			if(($storeService instanceof TreeStoreInterface) == false) {
				throw new \InvalidArgumentException('Service must be instance of TreeStoreInterface.');
			}
			 
			return $storeService;
		}
		
		private function createResponse(ExtJsJson $json) {
			$r = new Response();
			$r->headers->add(array('Content-Type'=>'application/json'));
			$r->setStatusCode(200,'OK');
			$r->setContent($this->get('serializer')->serialize($json,'json',$this->getSerializerContext($json)));
			 
			return $r;
		}
		
		private function getSerializerContext(ExtJsJson $json) {
			$arGroups = $json->getSerializerGroups();
			if(count($arGroups) > 0) {
				$context = SerializationContext::create()->setGroups($json->getSerializerGroups());
		
				return $context;
			}
			 
			return null;
		}
}
?>
