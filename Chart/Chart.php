<?php
namespace Webit\Bundle\ExtJsBundle\Chart;

use Webit\Bundle\ExtJsBundle\Chart\Axis\Axis;
use Webit\Bundle\ExtJsBundle\Chart\Series\Series;
use JMS\Serializer\Annotation as JMS;

/**
 *
 * @author dbojdo
 *
 */
class Chart
{
    /**
     * Theme constants
     */
    const THEME_BASE = 'Base';
    const THEME_GREEN = 'Green';
    const THEME_SKY = 'Sky';
    const THEME_RED = 'Red';
    const THEME_PURPLE = 'Purple';
    const THEME_BLUE = 'Blue';
    const THEME_YELLOW = 'Yellow';
    const THEME_CATEGORY1 = 'Category1';
    const THEME_CATEGORY2 = 'Category2';
    const THEME_CATEGORY3 = 'Category3';
    const THEME_CATEGORY4 = 'Category4';
    const THEME_CATEGORY5 = 'Category5';
    const THEME_CATEGORY6 = 'Category6';

    /**
     *
     * @var string
     * @JMS\Type("string")
     * @JMS\SerializedName("xtype")
     * @JMS\Groups({"chartInfo"})
     */
    protected $xtype = 'chart';

    /**
     *
     * @var string
     * @JMS\Type("string")
     * @JMS\SerializedName("cls")
     * @JMS\Groups({"chartInfo"})
     */
    protected $cls;

    /**
     *
     * @var string
     * @JMS\Type("string")
     * @JMS\SerializedName("itemId")
     * @JMS\Groups({"chartInfo"})
     */
    protected $itemId;

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("animate")
     * @JMS\Groups({"chartInfo"})
     */
    protected $animate;

    /**
     * @JMS\Type("array")
     * @JMS\SerializedName("axes")
     * @JMS\Groups({"chartInfo"})
     */
    protected $axes = array();

    protected $background;

    protected $gradients = array();

    protected $insetPadding = 10;

    /**
     * @var Legend
     * @JMS\Type("Webit\Bundle\ExtJsBundle\Chart\Legend")
     * @JMS\SerializedName("legend")
     * @JMS\Groups({"chartInfo"})
     */
    protected $legend;

    /**
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\SerializedName("series")
     * @JMS\Groups({"chartInfo"})
     */
    protected $series = array();

    /**
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\SerializedName("store")
     * @JMS\Groups({"chartInfo"})
     */
    protected $store = array();

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("theme")
     * @JMS\Groups({"chartInfo"})
     */
    protected $theme = self::THEME_BASE;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("width")
     * @JMS\Groups({"chartInfo"})
     */
    protected $width;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("height")
     * @JMS\Groups({"chartInfo"})
     */
    protected $height;

    public function __construct()
    {
        $this->legend = new Legend();
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function getAnimate()
    {
        return $this->animate;
    }

    public function setAnimate($animate)
    {
        $this->animate = $animate;
    }

    public function getAxes()
    {
        return $this->axes;
    }

    public function setAxes(array $axes)
    {
        $this->axes = $axes;
    }

    public function addAxe(Axis $axe)
    {
        $this->axes[] = $axe;
    }

    public function getBackground()
    {
        return $this->background;
    }

    public function setBackground($background)
    {
        $this->background = $background;
    }

    public function getGradients()
    {
        return $this->gradients;
    }

    public function setGradients($gradients)
    {
        $this->gradients = $gradients;
    }

    public function getInsetPadding()
    {
        return $this->insetPadding;
    }

    public function setInsetPadding($insetPadding)
    {
        $this->insetPadding = $insetPadding;
    }

    public function getLegend()
    {
        return $this->legend;
    }

    public function setLegend($legend)
    {
        $this->legend = $legend;
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries(array $series)
    {
        $this->series = $series;
    }

    public function addSeries(Series $series)
    {
        $this->series[] = $series;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function setStore($store)
    {
        $this->store = $store;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    public function getXtype()
    {
        return $this->xtype;
    }

    public function setXtype($xtype)
    {
        $this->xtype = $xtype;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getCls()
    {
        return $this->cls;
    }

    public function setCls($cls)
    {
        $this->cls = $cls;
    }
}
