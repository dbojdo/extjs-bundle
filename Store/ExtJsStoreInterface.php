<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollectionInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollectionInterface;

interface ExtJsStoreInterface {
	public function getModelList($queryParams, FilterCollectionInterface $filters, SorterCollectionInterface $sorters, $page = 1, $limit = 25, $offset = 0);
	public function loadModel($id, $queryParams);
	public function createModels($modelListData);
	public function updateModels($modelListData);
	public function deleteModel($id);
}
?>
