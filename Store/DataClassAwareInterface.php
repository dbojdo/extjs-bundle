<?php
namespace Webit\Bundle\ExtJsBundle\Store;

interface DataClassAwareInterface {
    
    /**
     * 
     * @param string $dataClass
     */
    public function setDataClass($dataClass);
}
