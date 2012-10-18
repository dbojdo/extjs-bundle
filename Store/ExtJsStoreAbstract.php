<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollectionInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollectionInterface;

/**
 * 
 * @author dbojdo
 * 
 */
abstract class ExtJsStoreAbstract implements ExtJsStoreInterface {
	protected $options;
	
	public function __construct(array $options = array()) {
		$resolver = new OptionsResolver();
		$this->setDefaultOptions($resolver);
		
		$this->options = $resolver->resolve($options);
	}
	
	public function getOption($option) {
		$arOption = explode('.',$option);
		
		$optFound = $this->options;
		foreach($arOption as $opt) {
			if(key_exists($opt, $optFound)) {
				$optFound = $optFound[$opt];
			} else {
				throw new \InvalidArgumentException('Unknown option: ' . $option);
			}
		}
		return $optFound;
	}
	
	protected function setDefaultOptions(OptionsResolverInterface $resolver) {
		
		$resolver->setRequired(array(
				'proxy',
				'reader',
				'writer'
		));
	
		$resolver->setDefaults(array(
				'proxy'=>array(
						'type'=>'webitrest',
						'appendId'=>false
				),
				'reader'=>array(
					'type' => 'json',
					'root' => null,
				),
				'writer'=>array(
						'type'=>'json',
						'root'=>null,
						'writeAllFields'=>true,
						'allowSingle'=>false
				)
		));
	}
	
	/**
	 *
	 * @param mixed $queryParams
	 * @param FilterCollectionInterface $filters
	 * @param SorterCollectionInterface $sorters
	 * @param int $page
	 * @param int $limit
	 * @param int $offset
	 * @return ExtJsJsonInterface
	 */
	public function getModelList($queryParams, FilterCollectionInterface $filters, SorterCollectionInterface $sorters, $page = null, $limit = null, $offset = null) {
		throw new \RuntimeException('Model list loading is not supported for this store');
	}
	
	/**
	 *
	 * @param mixed $id
	 * @param mixde $queryParams
	 * @return ExtJsJsonInterface
	 */
	public function loadModel($id, $queryParams) {
		throw new \RuntimeException('Model loading is not supported for this store');
	}
	
	/**
	 *
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function createModels(\Traversable $modelListData) {
		throw new \RuntimeException('Multi create is not supported for this store');
	}
	
	/**
	 *
	 * @param mixed $model
	 * @return ExtJsJsonInterface
	 */
	public function createModel($model) {
		throw new \RuntimeException('Single create is not supported for this store');
	}
	
	/**
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function updateModels(\Traversable $modelListData) {
		throw new \RuntimeException('Multi update is not supported for this store');
	}
	
	/**
	 *
	 * @param mixed $model
	 * @return ExtJsJsonInterface
	 */
	public function updateModel($model) {
		throw new \RuntimeException('Single update is not supported for this store');
	}
	
	/**
	 *
	 * @param \Traversable $modelListData
	 * @return ExtJsJsonInterface
	 */
	public function deleteModels(\Traversable $modelListData) {
		throw new \RuntimeException('Multi delete is not supported for this store');
	}
	
	/**
	 *
	 * @param mixed $id
	 * @return ExtJsJsonInterface
	 */
	public function deleteModel($id) {
		throw new \RuntimeException('Single delete is not supported for this store');
	}
	
	public function getDataClass() {
		return null;
	}
}
?>
