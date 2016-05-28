<?php
namespace Webit\Bundle\ExtJsBundle\TreeStore;

use JMS\Serializer\Annotation as JMS;
use Doctrine\Common\Collections\ArrayCollection;

class TreeNodeData
{
    /**
     *
     * @var mixed
     */
    public $id;

    /**
     *
     * @var string
     * @JMS\Type("string")
     */
    public $text;

    /**
     *
     * @var mixed
     */
    public $parentId;

    /**
     *
     * @var int
     * @JMS\Type("integer")
     */
    public $index;

    /**
     *
     * @var int
     * @JMS\Type("integer")
     */
    public $depth = 0;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     */
    public $expanded = false;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     */
    public $expandable = true;

    /**
     * @var string
     */
    public $checked;

    /**
     * @var boolean
     * @JMS\Type("boolean")
     */
    public $leaf = false;

    /**
     *
     * @var string
     * @JMS\Type("string")
     */
    public $cls;

    /**
     *
     * @var string
     * @JMS\Type("string")
     */
    public $iconCls;

    /**
     *
     * @var string
     * @JMS\Type("string")
     */
    public $icon;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $root = false;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $isLast = false;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $isFirst = false;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $allowDrop = true;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $allowDrag = true;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $loaded = false;

    /**
     *
     * @var Boolean
     * @JMS\Type("boolean")
     */
    public $loading = false;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $href;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $hrefTarget;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $qtip;

    /**
     * @var string
     * @JMS\Type("string")
     */
    public $qtitle;

    /**
     * @var string
     * @JMS\Type("ArrayCollection<Webit\Bundle\ExtJsBundle\TreeStore\TreeNodeData>")
     */
    public $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function fromArray($arNode)
    {
        foreach ($arNode as $key => $value) {
            if ($key == 'children') {
                foreach ($arNode['children'] as $arChild) {
                    $child = new self();
                    $child->fromArray($arChild);
                    $this->children->add($child);
                }
            } else {
                $this->{$key} = $value;
            }
        }
    }
}
