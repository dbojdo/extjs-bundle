<?php
namespace Webit\Bundle\ExtJsBundle\Store\Filter;

interface FilterInterface
{
    const COMPARISION_NOT = 'not';
    const COMPARISION_EQUAL = 'eq';
    const COMPARISION_GREATER = 'gt';
    const COMPARISION_LESS = 'lt';
    const COMPARISION_GREATER_OR_EQUAL = 'gte';
    const COMPARISION_LESS_OR_EQUAL = 'lte';

    const COMPARISION_NULL = 'null';

    const COMPARISION_DESCENDANT = 'desc';
    const COMPARISION_CHILD = 'child';
    const COMPARISION_DESCENDANT_OR_EQUAL = 'desce';
    const COMPARISION_CHILD_OR_EQUAL = 'childe';

    const TYPE_BOOLEAN = 'boolean';
    const TYPE_STRING = 'string';
    const TYPE_NUMERIC = 'numeric';
    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';
    const TYPE_LIST = 'list';
    const TYPE_NODE = 'node';

    /**
     * @return string
     */
    public function getProperty();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getComparision();

    /**
     * @return FilterParamsInterface
     */
    public function getParams();
}
