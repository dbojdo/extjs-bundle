<?php
namespace Webit\Bundle\ExtJsBundle\Service;
use Symfony\Component\DependencyInjection\ContainerAware;

class ExtJsAppNameGenerator extends ContainerAware {
	public function getExtJsAppName($bundleName) {
		$appName = substr($bundleName, 0,-6);
		
		return $appName;
	}
}
?>
