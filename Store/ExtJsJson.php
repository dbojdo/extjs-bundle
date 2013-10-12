<?php
namespace Webit\Bundle\ExtJsBundle\Store;
use JMS\Serializer\Annotation as JMS;

/**
 * 
 * @author dbojdo
 * @JMS\ExclusionPolicy("none")
 */
class ExtJsJson implements ExtJsJsonInterface {
	/**
	 * 
	 * @var boolean
	 * @JMS\Type("boolean")
	 * @JMS\Groups({"extjsResponse"})
	 */
	protected $success = true;
	
	/**
	 * 
	 * @var
	 * @JMS\Groups({"extjsResponse"}) 
	 */
	protected $data = array();
	
	/**
	 * 
	 * @var string
	 * @JMS\Type("string")
	 * @JMS\Groups({"extjsResponse"})
	 */
	protected $message;
	
	/**
	 * 
	 * @var
	 * @JMS\Groups({"extjsResponse"})
	 */
	protected $misc;
	
	/**
	 * 
	 * @var integer
	 * @JMS\Type("integer")
	 * @JMS\Groups({"extjsResponse"})
	 */
	protected $total;
	
	/**
	 * 
	 * @var array
	 * @JMS\Exclude
	 */
	protected $serializerGroups = array('extjsResponse');
	
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
	
	public function setMiscData($miscData) {
		$this->misc = $miscData;
	}
	
	public function getMiscData() {
		return $this->misc;
	}
	
	public function setSerializerGroups(array $groups) {
		if(in_array('extjsResponse',$groups) == false) {
			$groups[] = 'extjsResponse';
		}

		$this->serializerGroups = $groups;
	}
	
	public function getSerializerGroups() {
		if(in_array('extjsResponse',$this->serializerGroups) && count($this->serializerGroups) == 1) {
			return array();
		}

		return $this->serializerGroups;
	}
}
?>
