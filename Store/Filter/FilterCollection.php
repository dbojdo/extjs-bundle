<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Tools\Data\FilterCollection as DataFilterCollection;
use Webit\Tools\Data\Filter as DataFilter;
use Webit\Tools\Data\FilterParams as DataFilterParams;

/**
 *
 * @author dbojdo
 * @method FilterInterface get()
 */
class FilterCollection extends ArrayCollection implements FilterCollectionInterface
{

    /**
     *
     * @param string $property
     * @return FilterInterface|NULL
     */
    public function getFilter($property)
    {
        foreach ($this as $item) {
            if ($item->getProperty() == $property) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return \Webit\Tools\Data\FilterCollection
     */
    public function toDataFilterCollection()
    {
        $collection = new DataFilterCollection();
        /** @var Filter $filter */
        foreach ($this as $filter) {
            $params = $filter->getParams();

            $dataParams = null;
            if ($params) {
                $dataParams = new DataFilterParams();
                $dataParams->setCaseSensitive($params->getCaseSensitive());
                $dataParams->setLikeWildcard($params->getLikeWildcard());
                $dataParams->setNegation($params->getNegation());
            }

            $dataFilter = new DataFilter($filter->getProperty(), $filter->getValue(), $dataParams);
            $dataFilter->setComparison($filter->getComparision());
            $collection->add($dataFilter);
        }

        return $collection;
    }
}
