<?php
namespace Webit\Bundle\ExtJsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

use FOS\RestBundle\View\ViewHandlerInterface, FOS\RestBundle\View\View;

class ExtJsController 
{
	/**
	 * 
	 * @var ViewHandlerInterface
	 */
	protected $viewHandler;
	
	/**
	 * 
	 * @var ContainerInterface
	 */
	protected $container;
	
	/**
	 * Create the Vie Controller
	 *
	 * When using hallo, the controller can include the compiled js files from
	 * hallo's examples folder or use the assetic coffee filter.
	 * When developing hallo, make sure to use the coffee filter.
	 *
	 * @param ViewHandlerInterface $viewHandler view handler
	 * @param Boolean $useCoffee whether assetic is set up to use coffee script
	 */
	public function __construct(ContainerInterface $container, ViewHandlerInterface $viewHandler)
	{
		$this->viewHandler = $viewHandler;
		$this->container = $container;
	}
	
	/**
	 * Render js for VIE and a semantic editor.
	 *
	 * Hallo is a submodule of this bundle and available after right after you
	 * followed the installation instructions.
	 * To use aloha, you need to download the zip, as explained in step 8 of
	 * the README.
	 *
	 * @param string $editor the name of the editor to load, currently hallo and aloha are supported
	 */
	public function includeJSFilesAction($version = null)
	{
		$version = $version ?: $this->container->getParameter('webit_ext_js.version');
		
		$view = new View();
		$view->setData(array('version'=>$version));
		$view->setTemplate('WebitExtJsBundle::javascripts.html.twig');
		
		return $this->viewHandler->handle($view);
	}
	
	public function includeCSSFilesAction($version = null)
	{
		$version = $version ?: $this->container->getParameter('webit_ext_js.version');
	
		$view = new View();
		$view->setData(array('version'=>$version));
		
		$view->setTemplate('WebitExtJsBundle::stylesheets.html.twig');
	
		return $this->viewHandler->handle($view);
	}
}
?>
