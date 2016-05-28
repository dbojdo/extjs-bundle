<?php
namespace Webit\Bundle\ExtJsBundle\Store;

use Webit\Bundle\ExtJsBundle\Store\Sorter\SorterCollectionInterface;
use Webit\Bundle\ExtJsBundle\Store\Filter\FilterCollectionInterface;

interface ExtJsChartStoreInterface
{
    /**
     *
     * @param string $option
     * @return mixed
     */
    public function getOption($option);

    /**
     *
     * @param unknown_type $queryParams
     * @param FilterCollectionInterface $filters
     * @param SorterCollectionInterface $sorters
     * @param int $page
     * @param int $limit
     * @param int $offset
     * @return ExtJsJsonInterface
     */
    public function loadData(
        $queryParams,
        FilterCollectionInterface $filters,
        SorterCollectionInterface $sorters,
        $page = null,
        $limit = null,
        $offset = null
    );
}
