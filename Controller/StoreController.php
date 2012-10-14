<?php
namespace Webit\Bundle\ExtJsBundle\Controller;

use Assetic\Filter\FilterCollection;

use Doctrine\Common\Collections\ArrayCollection;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations as FOS;

use Doctrine\ODM\PHPCR\DocumentManager;

use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Response;

use Webit\Bundle\ExtJsBundle\Store\ExtJsJson;
use Webit\Bundle\ExtJsBundle\Store\ExtJsStoreInterface;

/**
 * 
 * @author dbojdo
 * @FOS\NamePrefix("webit_extjs_")
 */
class StoreController extends FOSRestController {
		/**
		 * 
		 * @var ExtJsStoreInterface
		 */
		protected $store;

		/**
		 * @FOS\QueryParam(name="id", description="Page of the overview.")
		 * @FOS\Route("/store/item")
		 *
		 * @param ParamFetcher $paramFetcher
		 * 
		 */
		public function getItemAction(ParamFetcher $paramFetcher) {
			$json = $this->getStore()->loadModel($paramFetcher->get('id'),$this->getRequest()->query->all());
			$this->container->get('serializer')->setGroups($json->getSerializerGroups());
			
			$view = View::create($json);
					
			return $this->handleView($view);
		}
		
    /**
     *  @FOS\QueryParam(name="page", requirements="\d+", default="1", description="Page of the overview.")
     *  @FOS\QueryParam(name="limit", requirements="\d+", default="25", description="Limit")
     *  @FOS\QueryParam(name="start", requirements="\d+", default="0", description="Start")
     *  @FOS\QueryParam(name="sort", default="[{}]", description="Sort")
     *  @FOS\QueryParam(name="filter", default="[{}]", description="Filters")
     *  @FOS\Route("/store/items")
     *  
     *  @param ParamFetcher $paramFetcher
     */
    public function getItemsAction(ParamFetcher $paramFetcher) {
    	$sort = $this->container->get('serializer')->deserialize($paramFetcher->get('sort'),'ArrayCollection','json');
    	
    	$filters = $this->container->get('serializer')->deserialize($paramFetcher->get('filter'),'ArrayCollection<Webit\Bundle\ExtJsBundle\Store\Filter>','json');
    	$filters = new \Webit\Bundle\ExtJsBundle\Store\FilterCollection($filters);
    	
			$json = $this->getStore()->getModelList($this->getRequest()->query->all(), $filters, $sort, $paramFetcher->get('page'), $paramFetcher->get('limit'), $paramFetcher->get('start'));
    	$view = View::create($json);

    	return $this->handleView($view);
    }
    
    /**
     * 
     * @FOS\Route("/store/items")
     */
    public function postItemsAction() {
    	$arProducts = $this->getRequest()->request->get('data');
    	$arData = $this->container->get('serializer')->deserialize($arProducts,'ArrayCollection<'.$this->getStore()->getDataClass().'>','json');
    	
    	$json = $this->getStore()->createModels(new ArrayCollection($arData));
    	$view = View::create($json);
    	
    	return $this->handleView($view);
    } // create
    
    /**
     * @FOS\Route("/store/items")
     */
    public function putItemsAction() {
    	$arProducts = $this->getRequest()->request->get('data');
    	$arData = $this->container->get('serializer')->deserialize($arProducts,'ArrayCollection<'.$this->getStore()->getDataClass().'>','json');

    	$response = $this->getStore()->updateModels(new ArrayCollection($arData));
    	$view = View::create($response);
    	
    	return $this->handleView($view);
    } // update

    /**
     * @FOS\QueryParam(name="item", description="Page of the overview.")
     * @FOS\Route("/store/items")
     * 
     * 
     * @param ParamFetcher $paramFetcher
     */
    public function deleteItemsAction(ParamFetcher $paramFetcher) {
    	$arProducts = $this->getRequest()->request->get('data');
    	$arData = $this->container->get('serializer')->deserialize($arProducts,'ArrayCollection<'.$this->getStore()->getDataClass().'>','json');
    	
    	$json = $this->getStore()->deleteModel($arData,$this->getRequest()->request->all());
    	
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
    	
    	if(($storeService instanceof ExtJsStoreInterface) == false) {
    		throw new \InvalidArgumentException('Service must be instance of ExtJsStoreInterface.');
    	}
    	
    	return $storeService;
    }
}
?>
