<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Axis;

use JMS\Serializer\Annotation as JMS;

class Axis
{
    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';
    const POSITION_TOP = 'top';
    const POSITION_BOTTOM = 'bottom';

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("type")
     * @JMS\Groups({"chartInfo"})
     */
    protected $type;

    /**
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\SerializedName("fields")
     * @JMS\Groups({"chartInfo"})
     */
    protected $fields = array();

    /**
     * @JMS\SerializedName("label")
     * @JMS\Groups({"chartInfo"})
     */
    protected $label = array();

    /**
     * @JMS\Type("boolean")
     * @JMS\SerializedName("adjustEnd")
     * @JMS\Groups({"chartInfo"})
     */
    protected $adjustEnd;

    /**
     *
     * @var integer
     * @JMS\Type("integer")
     * @JMS\SerializedName("dashSize")
     * @JMS\Groups({"chartInfo"})
     */
    protected $dashSize;

    /**
     * @JMS\SerializedName("grid")
     * @JMS\Groups({"chartInfo"})
     */
    protected $grid; // object

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("length")
     * @JMS\Groups({"chartInfo"})
     */
    protected $length;

    /**
     *
     * @var integer
     * @JMS\Type("integer")
     * @JMS\SerializedName("majorTickSteps")
     * @JMS\Groups({"chartInfo"})
     */
    protected $majorTickSteps; // number

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("minorTickSteps")
     * @JMS\Groups({"chartInfo"})
     */
    protected $minorTickSteps;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("position")
     * @JMS\Groups({"chartInfo"})
     */
    protected $position;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("title")
     * @JMS\Groups({"chartInfo"})
     */
    protected $title;

    /**
     *
     * @var integer
     * @JMS\Type("integer")
     * @JMS\SerializedName("width")
     * @JMS\Groups({"chartInfo"})
     */
    protected $width;

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getAdjustEnd()
    {
        return $this->adjustEnd;
    }

    public function setAdjustEnd($adjustEnd)
    {
        $this->adjustEnd = $adjustEnd;
    }

    public function getDashSize()
    {
        return $this->dashSize;
    }

    public function setDashSize($dashSize)
    {
        $this->dashSize = $dashSize;
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function setGrid($grid)
    {
        $this->grid = $grid;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getMajorTickSteps()
    {
        return $this->majorTickSteps;
    }

    public function setMajorTickSteps($majorTickSteps)
    {
        $this->majorTickSteps = $majorTickSteps;
    }

    public function getMinorTickSteps()
    {
        return $this->minorTickSteps;
    }

    public function setMinorTickSteps($minorTickSteps)
    {
        $this->minorTickSteps = $minorTickSteps;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }
}
