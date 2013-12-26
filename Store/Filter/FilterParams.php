<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

use JMS\Serializer\Annotation as JMS;

/**
 * 
 * @author dbojdo
 *
 */
class FilterParams implements FilterParamsInterface {
	/**
	 * @var string
	 * @JMS\Type("array")
	 */
	protected $params = array(
		'case_sensitive'=>false,
		'like_wildcard'=>FilterParamsInterface::LIKE_WILDCARD_NONE,
		'negation'=>false
	);
	
	public function __construct(array $params = null) {
		if($params) {
			$this->params = array_replace($this->params, $params);
		}
	}
	
	public function getCaseSensitive() {
		return isset($this->params['case_sensitive']) ? $this->params['case_sensitive'] : false;
	}
	
	public function getLikeWildcard() {
		return isset($this->params['like_wildcard']) ? $this->params['like_wildcard'] : FilterParamsInterface::LIKE_WILDCARD_NONE;
	}
	
	public function getNegation() {
		return isset($this->params['negation']) ? $this->params['negation'] : false;
	}
	
	public function setCaseSensitive($caseSensitive) {
		$this->params['case_sensitive'] = (bool) $caseSensitive;
	}
	
	public function setLikeWildcard($likeWildcard) {
		$this->params['like_wildcard'] = $likeWildcard;
	}
	
	public function setNegation($negation) {
		$this->params['negation'] = (bool) $negation;
	}
}
?>
