<?php
namespace Webit\Bundle\ExtJsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;

class GenerateAppCommand extends ContainerAwareCommand {
	/**
	 * 
	 * @var string
	 */
	protected $bundleName;
	
	/**
	 * 
	 * @var Bundle
	 */
	protected $bundle;

	protected function configure() {
		parent::configure();
		$this->setName('webit:extjs:generate:app')
			->addArgument('bundle_name',InputArgument::REQUIRED)
					->setDescription('Generate ExtJS application\'s skeleton for given Bundle');
	}
	
	private function getAssetDir() {
		return __DIR__ . '/../Resources/public';
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::initialize()
	 */
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$this->bundleName = $input->getArgument('bundle_name');
	
		$kernel = $this->getApplication()->getKernel();
		$this->bundle = $kernel->getBundle($this->bundleName);
	}
	
	protected function execute(InputInterface $input, OutputInterface $output) {		
		$appDir = $this->createApplicationDirectory();
		$this->createSkeleton($appDir);
	}
	
	private function createApplicationDirectory() {
		$bundleDir = $this->bundle->getPath();
		$appDir = $bundleDir . '/Resources/public/'.$this->getContainer()->getParameter('webit_ext_js.js_root_dir');
		
		$this->createDir($appDir);
		
		return $appDir;
	}
	
  private function createSkeleton($appDir) {
  	$arDir = array('/app/view','/app/model','/app/controller','/app/store');
  	
  	foreach($arDir as $dir) {
  		$this->createDir($appDir . $dir);	
  	}
		
  	// app.js
  	file_put_contents($appDir . '/app.js', $this->renderAppData());

  	// app/view/Viewport.js
  	file_put_contents($appDir .'/app/view/Viewport.js',$this->renderViewport());
  }
  
  private function renderAppData() {
  	$appNameGen = $this->getContainer()->get('webit_ext_js.extjs_app_name_generator');
  	$appName = $appNameGen->getExtJsAppName($this->bundleName);
  	
  	$appFolder = '/bundles/'.mb_strtolower($appName) . '/js/app';
  	
  	$extjsSubclassesProvider = $this->getContainer()->get('webit_ext_js.extjs_document_classes_provider');
  	$extjsSubclasses = $extjsSubclassesProvider->getExtJsDocumentClasses($this->bundle);
  	
  	$view = View::create();
  	$view->setData(array('appName'=>$appName,'appFolder'=>$appFolder,'extjsSubclasses'=>$extjsSubclasses));
  	$view->setTemplate('WebitExtJsBundle:_commandGenerateApp:app.js.twig');
  	
  	$vh = $this->getContainer()->get('fos_rest.view_handler');
  	return $vh->renderTemplate($view,'js');
  }
  
  private function renderViewport() {
  	$appNameGen = $this->getContainer()->get('webit_ext_js.extjs_app_name_generator');
  	$appName = $appNameGen->getExtJsAppName($this->bundleName);
  	
  	$view = View::create();
  	$view->setData(array('appName'=>$appName));
  	$view->setTemplate('WebitExtJsBundle:_commandGenerateApp:viewport.js.twig');
  	 
  	$vh = $this->getContainer()->get('fos_rest.view_handler');
  	return $vh->renderTemplate($view,'js');
  }
  
  private function createDir($dir) {
  	@mkdir($dir,0755, true);
  	if(is_dir($dir) == false) {
  		throw new \RuntimeException('Cannot create directory: ' . $dir);
  	}
  }
}
?>
