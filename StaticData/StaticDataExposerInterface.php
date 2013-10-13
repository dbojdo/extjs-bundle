<?php 
namespace Webit\Bundle\ExtJsBundle\StaticData;

interface StaticDataExposerInterface {
	/**
	 * @return array<key, data>
	 */
	public function getExposedData();
}
