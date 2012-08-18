<?php
namespace Webit\Bundle\ExtJsBundle\Service;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerAware;

class ExtJsDocumentClassesProvider {
	private $subclassNameGenerator;
	public function __construct($subclassNameGenerator) {
		$this->subclassNameGenerator = $subclassNameGenerator;
	}
	
	public function getExtJsDocumentClasses(Bundle $bundle) {
		$documentsPath = $bundle->getPath() . '/Document';
		
		$arClasses = array();
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($documentsPath), \RecursiveIteratorIterator::SELF_FIRST);
		foreach($iterator as $file => $objectFile){
			if($objectFile->isDir()) {
				continue;
			}
			
			$phpClassName = $className = substr($objectFile->getPathname(), mb_strlen($documentsPath) + 1); 
			$phpClassName = substr($phpClassName, 0,-4);
			$phpClassName = str_replace('/', '\\', $phpClassName);
				
			$fullClassName = $bundle->getNamespace() . '\\Document\\' . $phpClassName;
				
			$arClasses[$fullClassName] = $this->subclassNameGenerator->getExtJsSubclassName($phpClassName);
		}
		
		return $arClasses;
	}
}
?>
