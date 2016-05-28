<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

interface TreeStoreInterface
{
    /**
     *
     * @param string $id
     */
    public function loadNode($id = null);
}
