<?php
namespace Webit\Bundle\ExtJsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('webit_ext_js');
        $rootNode
        	->children()
        		->arrayNode('download_url')
        			->defaultValue(array(
        					'4.2.0' => 'http://cdn.sencha.com/ext/gpl/ext-4.2.0-gpl.zip',
        					'4.1.1' => 'http://cdn.sencha.io/ext-4.1.1-gpl.zip',
        					'3.4.0' => 'http://extjs.cachefly.net/ext-3.4.0.zip',
        					'2.3.0' => 'http://dev.sencha.com/deploy/ext-2.3.0.zip'
        			))
        			->prototype('scalar')->end()
        	->end()
        	->arrayNode('security')
        		->addDefaultsIfNotSet()
        		->children()
        			->scalarNode('model')->defaultValue('Webit.security.User')->end()
        		->end()
        	->end()
					->scalarNode('version')->defaultValue('4.2.0')->end()
        	->scalarNode('js_root_dir')->defaultValue('/js')->end()
        ->end();

        return $treeBuilder;
    }
}
?>
