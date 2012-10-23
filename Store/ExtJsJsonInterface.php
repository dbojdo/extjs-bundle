<?php
namespace Webit\Bundle\ExtJsBundle\Store;

interface ExtJsJsonInterface {
	public function getData();
	public function getMiscData();
	public function getSuccess();
	public function getMessage();
	public function getTotal();
	public function getSerializerGroups();
}
?>
