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
    private $xPadding = 0;

    /**
     * @var float
     * @JMS\Type("double")
     * @JMS\SerializedName("yPadding")
     * @JMS\Groups({"chartInfo"})
     */
    private $yPadding = 10;

    /**
     * @var
     * @JMS\Type("double")
     * @JMS\SerializedName("gutter")
     * @JMS\Groups({"chartInfo"})
     */
    private $gutter = 38.2;

    /**
     * @var bool
     * @JMS\Type("boolean")
     * @JMS\SerializedName("column")
     * @JMS\Groups({"chartInfo"})
     */
    private $column = false;

    /**
     * @var array
     * @JMS\Type("array")
     * @JMS\SerializedName("style")
     * @JMS\Groups({"chartInfo"})
     */
    private $style = array();

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
        $this->column = (bool)$column;
    }

    /**
     * @return float
     */
    public function getGutter()
    {
        return $this->gutter;
    }

    /**
     * @param float $gutter
     */
    public function setGutter($gutter)
    {
        $this->gutter = $gutter;
    }

    /**
     * @return array
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param array $style
     */
    public function setStyle(array $style)
    {
        $this->style = $style;
    }
}
