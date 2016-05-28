<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Axis;

use JMS\Serializer\Annotation as JMS;

class Category extends Axis
{
    public function __construct()
    {
        //parent::__construct();
        $this->type = 'Category';
        $this->position = self::POSITION_BOTTOM;
    }
}
