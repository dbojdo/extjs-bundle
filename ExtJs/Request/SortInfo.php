<?php
namespace Webit\Bundle\ExtJsBundle\ExtJs\Request;

use JMS\Serializer\Annotation as JMS;

class SortInfo
{
    /**
     * @JMS\Type("string")
     * @var string
     */
    protected $field;

    /**
     *
     * @JMS\Type("string")
     */
    protected $direction;

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
