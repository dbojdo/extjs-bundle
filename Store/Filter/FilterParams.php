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
		return $this->params['case_sensitive'];
	}
	
	public function getLikeWildcard() {
		return $this->params['like_wildcard'];
	}
	
	public function getNegation() {
		return $this->params['negation'];
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
