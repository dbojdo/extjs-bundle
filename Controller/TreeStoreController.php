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
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/treestore/node")
		 *
		 * @param ParamFetcher $paramFetcher
		 */
		public function getNodeAction(ParamFetcher $paramFetcher) {
			$json = $this->getStore()->loadNode($paramFetcher->get('id'));

			$view = View::create($json);
			
			return $this->handleView($view);
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
				throw new \InvalidArgumentException('Service must be instance of ExtJsStoreInterface.');
			}
			 
			return $storeService;
		}
}
?>
