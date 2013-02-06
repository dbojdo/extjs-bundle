<?php
namespace Webit\Bundle\ExtJsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;

use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Response;

use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\TreeStore\TreeStoreInterface;

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
		 * @FOS\Route("/tree/load")
		 *
		 * @param ParamFetcher $paramFetcher
		 */
		public function loadNodeAction(ParamFetcher $paramFetcher) {
			$json = $this->getStore()->loadNode($paramFetcher->get('id'));

			$view = View::create($json);
			$this->container->get('serializer')->setGroups($json->getSerializerGroups());
			
			return $this->handleView($view);
		}
		
		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node-data")
		 */
		public function getNodeAction(ParamFetcher $paramFetcher) {
			$json = $this->getStore()->loadNode($paramFetcher->get('id'));
			
			$view = View::create($json);
			$this->container->get('serializer')->setGroups($json->getSerializerGroups());
				
			return $this->handleView($view);
		}

		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node")
		 */
		public function postNodeAction() {
			$store = $this->getStore();
			$arNodes = $this->get('serializer')->deserialize($this->getRequest()->getContent(),$store->getDataClass());
			var_dump($arNodes);
			//$json = $this->getStore()->createNodes();
		}
		
		/**
		 * Return node's data
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/tree/node")
		 */
		public function putNodeAction() {
			$store = $this->getStore();
			$arNodes = $this->get('serializer')->deserialize($this->getRequest()->getContent(),$store->getDataClass());
			var_dump($arNodes);
			//$json = $this->getStore()->createNodes();
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
}
?>
