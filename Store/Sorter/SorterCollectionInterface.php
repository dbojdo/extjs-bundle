<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

interface SorterCollectionInterface extends \Traversable
{
    /**
     *
     * @param string $property
     * @return SorterInterface|NULL
     */
    public function getSorter($property);


    /**
     * @return \Webit\Tools\Data\SorterCollection
     */
    public function toDataSorterCollection();
}
