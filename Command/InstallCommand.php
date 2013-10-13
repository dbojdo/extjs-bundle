<?php
namespace Webit\Bundle\ExtJsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends ContainerAwareCommand {
	/**
	 * 
	 * @var string
	 */
	protected $version;
	
	protected $downloadUrl;
	
	protected function configure() {
		parent::configure();
		
		$this->setName('webit:extjs:install')
					->addOption('sourceFile','sf',InputOption::VALUE_OPTIONAL,'ExtJS library source file')
					->setDescription('Download and install ExtJS library');
	}
	
	private function getAssetDir() {
		return $this->getContainer()->getParameter('kernel.root_dir').'/../web/js';
	}
	
	protected function initialize(InputInterface $input, OutputInterface $output) {
		$version = $input->getOption('version') ?: $this->getContainer()->getParameter('webit_ext_js.version');
		$this->version = $version;
		
		$sourceFile = $input->getOption('sourceFile');
		if($sourceFile) {
			if(is_file($sourceFile) == false) {
				throw new \RuntimeException('ExtJS Library Source file does\'t exist');
			}
			$this->downloadUrl = $sourceFile;
		} else {
			$arDownloadUrl = $this->getContainer()->getParameter('webit_ext_js.download_url');
			if(!$sourceFile && key_exists($this->version,$arDownloadUrl) == false) {
				throw new \RuntimeException('Cannot find url for required version: '.$this->version);
			}	
			$this->downloadUrl = $arDownloadUrl[$this->version];
		}
	}
		
	protected function execute(InputInterface $input, OutputInterface $output) {
		$url = $this->downloadUrl;
		
		$output->writeln(sprintf('Downloading <comment>ExtJS %s</comment> library from <comment>%s</comment> to <comment>%s</comment>', $this->version,$url,$this->getAssetDir()));
		
		$path = $this->download($url);
		if(!$path) {
			throw new \RuntimeException('Cannot download ExtJS library');
		}
		
		$output->writeln(sprintf('Extracting ExtJS library to <comment>%s</comment>', $this->getAssetDir()));
		$this->extract($path);
	}
	
  private function download($url) {
  	$path = $this->getAssetDir() . '/extjs.zip';
  	
		if(file_put_contents($path, file_get_contents($url))) {
			return $path;
		}
		
		return false;
  }
  
  private function extract($path) {
  	$zip = new \ZipArchive();
  	$zip->open($path);
  	$zip->extractTo($this->getAssetDir());
  	
  	rename($this->getAssetDir() . '/'. $zip->getNameIndex(0), $this->getAssetDir() . '/extjs-'.$this->version);
  	
  	unlink($path);
  }
}
?>
