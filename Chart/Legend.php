<?php
namespace Webit\Bundle\ExtJsBundle\Chart;

use JMS\Serializer\Annotation as JMS;

class Legend
{
    const POSITION_BOTTOM = 'bottom';
    const POSITION_TOP = 'top';
    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';
    const POSITION_FLOAT = 'float';

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("boxFill")
     * @JMS\Groups({"chartInfo"})
     */
    protected $boxFill;

    /**
     *
     * @var unknown_type
     * @JMS\Type("string")
     * @JMS\SerializedName("boxStroke")
     * @JMS\Groups({"chartInfo"})
     */
    protected $boxStroke;

    /**
     *
     * @var
     * @JMS\Type("string")
     * @JMS\SerializedName("boxStrokeWidth")
     * @JMS\Groups({"chartInfo"})
     */
    protected $boxStrokeWidth;

    /**
     *
     * @var unknown_type
     * @JMS\Type("integer")
     * @JMS\SerializedName("boxZIndex")
     * @JMS\Groups({"chartInfo"})
     */
    protected $boxZIndex;

    /**
     *
     * @var unknown_type
     * @JMS\Type("integer")
     * @JMS\SerializedName("itemSpacing")
     * @JMS\Groups({"chartInfo"})
     */
    protected $itemSpacing;

    /**
     *
     * @var
     * @JMS\Type("string")
     * @JMS\SerializedName("labelColor")
     * @JMS\Groups({"chartInfo"})
     */
    protected $labelColor;

    /**
     *
     * @var
     * @JMS\Type("string")
     * @JMS\SerializedName("labelFont")
     * @JMS\Groups({"chartInfo"})
     */
    protected $labelFont;

    /**
     *
     * @var unknown_type
     * @JMS\Type("integer")
     * @JMS\SerializedName("padding")
     * @JMS\Groups({"chartInfo"})
     */
    protected $padding;

    /**
     *
     * @var unknown_type
     * @JMS\Type("string")
     * @JMS\SerializedName("position")
     * @JMS\Groups({"chartInfo"})
     */
    protected $position;

    /**
     *
     * @var unknown_type
     * @JMS\Type("boolean")
     * @JMS\SerializedName("udpate")
     * @JMS\Groups({"chartInfo"})
     */
    protected $update;

    /**
     *
     * @var unknown_type
     * @JMS\Type("boolean")
     * @JMS\SerializedName("visible")
     * @JMS\Groups({"chartInfo"})
     */
    protected $visible;

    /**
     *
     * @var unknown_type
     * @JMS\Type("integer")
     * @JMS\SerializedName("x")
     * @JMS\Groups({"chartInfo"})
     */
    protected $x;

    /**
     *
     * @var unknown_type
     * @JMS\Type("integer")
     * @JMS\SerializedName("y")
     * @JMS\Groups({"chartInfo"})
     */
    protected $y;

    public function getBoxFill()
    {
        return $this->boxFill;
    }

    public function setBoxFill($boxFill)
    {
        $this->boxFill = $boxFill;
    }

    public function getBoxStroke()
    {
        return $this->boxStroke;
    }

    public function setBoxStroke($boxStroke)
    {
        $this->boxStroke = $boxStroke;
    }

    public function getBoxStrokeWidth()
    {
        return $this->boxStrokeWidth;
    }

    public function setBoxStrokeWidth($boxStrokeWidth)
    {
        $this->boxStrokeWidth = $boxStrokeWidth;
    }

    public function getBoxZIndex()
    {
        return $this->boxZIndex;
    }

    public function setBoxZIndex($boxZIndex)
    {
        $this->boxZIndex = $boxZIndex;
    }

    public function getItemSpacing()
    {
        return $this->itemSpacing;
    }

    public function setItemSpacing($itemSpacing)
    {
        $this->itemSpacing = $itemSpacing;
    }

    public function getLabelColor()
    {
        return $this->labelColor;
    }

    public function setLabelColor($labelColor)
    {
        $this->labelColor = $labelColor;
    }

    public function getLabelFont()
    {
        return $this->labelFont;
    }

    public function setLabelFont($labelFont)
    {
        $this->labelFont = $labelFont;
    }

    public function getPadding()
    {
        return $this->padding;
    }

    public function setPadding($padding)
    {
        $this->padding = $padding;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function setUpdate($update)
    {
        $this->update = $update;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getX()
    {
        return $this->x;
    }

    public function setX($x)
    {
        $this->x = $x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function setY($y)
    {
        $this->y = $y;
    }
}
