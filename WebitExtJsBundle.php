<?php
namespace Webit\Bundle\ExtJsBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Webit\Bundle\ExtJsBundle\DependencyInjection\Compiler\StaticDataExposerPass;

class WebitExtJsBundle extends Bundle {
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new StaticDataExposerPass());
	}
}
?>
