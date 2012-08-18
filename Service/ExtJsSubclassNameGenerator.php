<?php
namespace Webit\Bundle\ExtJsBundle\Service;
use Symfony\Component\DependencyInjection\ContainerAware;

class ExtJsSubclassNameGenerator extends ContainerAware {
	public function getExtJsSubclassName($phpClassName) {
		$phpClassName = ltrim($phpClassName,'\\'); 
		
		$arClassName = explode('\\',$phpClassName);
		foreach($arClassName as $key => &$subName) {
			if($key < count($arClassName) -1) {
				$subName = mb_strtolower($subName);
			}
		}
		
		return implode('.',$arClassName);
	}
}
?>
