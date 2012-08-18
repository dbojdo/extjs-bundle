<?php
namespace Webit\Bundle\ExtJsBundle\Command;

use Webit\Bundle\ExtJsBundle\ExtJs\FormElementsMap;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\ODM\PHPCR\DocumentManager;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use Webit\Bundle\ExtJsBundle\ExtJs\TypeConverter\PHPCR;
 
class GenerateStoresCommand extends ContainerAwareCommand {
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
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::configure()
	 */
	protected function configure() {
		parent::configure();
		$this->setName('webit:extjs:generate:stores')
			->addArgument('bundle_name',InputArgument::REQUIRED)
					->setDescription('Generate ExtJS data stores (from entities and documents) for given Bundle');
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
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Console\Command.Command::execute()
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {	
		$documentClassesProvider = $this->getContainer()->get('webit_ext_js.extjs_document_classes_provider');
		
		$arClasses = $documentClassesProvider->getExtJsDocumentClasses($this->bundle);
		foreach($arClasses as $phpClass=>$extjsSubclass) {
			$subclassDir = $this->getExtJsClassDir($extjsSubclass);
			$this->createDir($subclassDir);
			
			file_put_contents($subclassDir . $this->getExtJsClassFilename($extjsSubclass), $this->renderModel($phpClass,$extjsSubclass));
		}
		
		$output->writeln('<info>Forms have been successfully created</info>');
	}
	
	/**
	 * 
	 * @param string $extjsSubclass
	 * @return string
	 */
	private function getExtJsClassDir($extjsSubclass) {
		$arSubclass = explode('.',$extjsSubclass);
		array_pop($arSubclass);
		
		$dir = $this->bundle->getPath() .'/Resources/public' . $this->getContainer()->getParameter('webit_ext_js.js_root_dir') . '/app/store/';
		$dir .= implode('/',$arSubclass) . '/';
		
		return $dir;
	}
	
	/**
	 * 
	 * @param string $extjsSubclass
	 * @return string
	 */
	private function getExtJsClassFilename($extjsSubclass) {
		$arSubclass = explode('.',$extjsSubclass);
		$name = array_pop($arSubclass) . '.js';
		
		return $name;
	}
	
	/**
	 * 
	 * @param string $phpClass
	 * @param string $extjsSubclass
	 * 
	 */
	private function renderModel($phpClass,$extjsSubclass) {
		$appNameGenerator = $this->getContainer()->get('webit_ext_js.extjs_app_name_generator'); 
		$appName = $appNameGenerator->getExtJsAppName($this->bundleName);
		
		$view = View::create();
		$view->setData(array('appName'=>$appName,'extjsSubclass'=>$extjsSubclass));
		$view->setTemplate('WebitExtJsBundle:_commandGenerateStores:store.js.twig');
		 
		$vh = $this->getContainer()->get('fos_rest.view_handler');
		return $vh->renderTemplate($view,'js');
	}
  
	/**
	 * Creates given directory
	 * @param string $dir
	 * @throws \RuntimeException
	 */
  private function createDir($dir) {
  	@mkdir($dir,0755, true);
  	if(is_dir($dir) == false) {
  		throw new \RuntimeException('Cannot create directory: ' . $dir);
  	}
  }
}
?>
