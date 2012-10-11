<?php
namespace Webit\Bundle\ExtJsBundle\Store;

abstract class StoreDataAbstract implements SorterInterface {
	public function __construct($entity = null) {
		if($entity) {
			$this->fromEntity($entity);
		}
	}
	
	public function fromEntity($entity) {
		$refObj = new \ReflectionObject($this);
		$refEntity = new \ReflectionObject($entity);
		
		$arMethods = $refObj->getMethods(\ReflectionMethod::IS_PUBLIC);
		foreach($arMethods as $method) {
			if(substr($method->getName(), 0,3) == 'set') {
				$callback = array($entity,'get' . substr($method->getName(), 3));
				if(is_callable($callback)) {
					$this->{$method->getName()}(call_user_func($callback));
				}
			}
		}
	}
	
	public function fillEntity($entity) {
		$refObj = new \ReflectionObject($this);
		$arMethods = $refObj->getMethods(\ReflectionMethod::IS_PUBLIC);
		foreach($arMethods as $method) {
			if(substr($method->getName(), 0,3) == 'get') {
				$callback = array($entity,'set' . substr($method->getName(), 3));
				if(is_callable($callback)) {
					call_user_func($callback,$this->{$method->getName()}());
				}
			}
		}
	}
}
?>
