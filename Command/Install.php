<?php
namespace Webit\Bundle\ExtJsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Install extends ContainerAwareCommand {
  public function download() {
  	$url = $this->container->getParameter('webit_extjs.download_url');
  	
  }
}
?>
