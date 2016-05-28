<?php
namespace Webit\Bundle\ExtJsBundle\Store\Sorter;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Tools\Data\SorterCollection as DataSorterCollection;
use Webit\Tools\Data\Sorter as DataSorter;

/**
 *
 * @author dbojdo
 * @method SorterInterface get()
 */
class SorterCollection extends ArrayCollection implements SorterCollectionInterface
{

    /**
     *
     * @param string $property
     * @return SorterInterface|NULL
     */
    public function getSorter($property)
    {
        foreach ($this as $item) {
            if ($item->getProperty() == $property) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return \Webit\Tools\Data\SorterCollection
     */
    public function toDataSorterCollection()
    {
        $collection = new DataSorterCollection();
        /** @var DataSorter $sorter */
        foreach ($this as $sorter) {
            $collection->addSorter(new DataSorter($sorter->getProperty(), $sorter->getDirection()));
        }

        return $collection;
    }
}
