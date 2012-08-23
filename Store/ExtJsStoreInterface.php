<?php
namespace Webit\Bundle\ExtJsBundle\Store;

interface ExtJsStoreInterface {
	public function getModelList($queryParams,$filters,$sort,$page,$limit,$offset);
	public function loadModel($id);
	public function createModels($modelListData);
	public function updateModels($modelListData);
	public function deleteModel($id);
}
?>
