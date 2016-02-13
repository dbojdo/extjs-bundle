<?php
/**
 * File Bar.php
 * Created at: 2016-02-13 04-37
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\ExtJsBundle\Chart\Series;

use JMS\Serializer\Annotation as JMS;

class Bar extends Series
{
    /**
     * @var float
     * @JMS\Type("double")
     * @JMS\SerializedName("xPadding")
     * @JMS\Groups({"chartInfo"})
     */
    private $xPadding;

    /**
     * @var float
     * @JMS\Type("double")
     * @JMS\SerializedName("yPadding")
     * @JMS\Groups({"chartInfo"})
     */
    private $yPadding;

    /**
     * @var bool
     * @JMS\Type("boolean")
     * @JMS\SerializedName("column")
     * @JMS\Groups({"chartInfo"})
     */
    private $column = false;

    /**
     * @return float
     */
    public function getXPadding()
    {
        return $this->xPadding;
    }

    /**
     * @param float $xPadding
     */
    public function setXPadding($xPadding)
    {
        $this->xPadding = $xPadding;
    }

    /**
     * @return float
     */
    public function getYPadding()
    {
        return $this->yPadding;
    }

    /**
     * @param float $yPadding
     */
    public function setYPadding($yPadding)
    {
        $this->yPadding = $yPadding;
    }

    /**
     * @return boolean
     */
    public function isColumn()
    {
        return $this->column;
    }

    /**
     * @param boolean $column
     */
    public function setColumn($column)
    {
        $this->column = (bool) $column;
    }
}
