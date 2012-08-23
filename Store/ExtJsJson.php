<?php
namespace Webit\Bundle\ExtJsBundle\Store;

class ExtJsJson implements ExtJsJsonInterface {
	protected $success = true;
	
	protected $data = array();
	
	protected $message;
	
	protected $total;

	public function setData($data) {
		$this->data = $data;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function setSuccess($success) {
		$this->success = (bool)$success;
	}
	
	public function getSuccess() {
		return $this->success;
	}
	
	public function setMessage($message) {
		$this->message = $message;
	}
	
	public function getMessage() {
		return $this->message;
	}
	
	public function setTotal($total) {
		$this->total = $total;
	}
	
	public function getTotal() {
		return $this->total;
	}
	
	public function __serialize() {
		$arResponse = array('success'=>$this->getSuccess(), 'data'=>$this->getData(), 'total'=>$this->getTotal(), 'message'=>$this->getMessage());
		
		return serialize($arResponse);
	}
}
?>
