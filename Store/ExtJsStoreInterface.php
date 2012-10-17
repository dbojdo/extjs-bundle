<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollectionInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollectionInterface;

interface ExtJsStoreInterface {
	/**
	 * 
	 * @param string $option
	 * @return mixed
	 */
	public function getOption($option);
	
	/**
	 * 
	 * @param unknown_type $queryParams
	 * @param FilterCollectionInterface $filters
	 * @param SorterCollectionInterface $sorters
	 * @param int $page
	 * @param int $limit
	 * @param int $offset
	 * @return ExtJsJsonInterface 
	 */
	public function getModelList($queryParams, FilterCollectionInterface $filters, SorterCollectionInterface $sorters, $page = null, $limit = null, $offset = null);
	
	/**
	 * 
	 * @param mixed $id
	 * @param mixde $queryParams
	 * @return ExtJsJsonInterface
	 */
	public function loadModel($id, $queryParams);
	
	/**
	 * 
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function createModels(\Traversable $modelListData);
	
	/**
	 * 
	 * @param mixed $model
	 * @return ExtJsJsonInterface
	 */
	public function createModel($model);
	
	/**
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function updateModels(\Traversable $modelListData);
	
	/**
	 * 
	 * @param mixed $model
	 * @return ExtJsJsonInterface
	 */
	public function updateModel($model);
	
	/**
	 * 
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function deleteModels(\Traversable $modelListData);
	
	/**
	 * 
	 * @param mixed $id
	 * @return ExtJsJsonInterface
	 */
	public function deleteModel($id);
}
?>
