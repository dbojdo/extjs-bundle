<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Axis;
use JMS\Serializer\Annotation as JMS;

class Time extends Numeric
{
    /**
     *
     * @var string
     * @JMS\Type("string")
     * @JMS\SerializedName("dateFormat")
     * @JMS\Groups({"chartInfo"})
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     *
     * @var \DateTime
     * @JMS\SerializedName("fromDate")
     * @JMS\Groups({"chartInfo"})
     */
    protected $fromDate;

    /**
     *
     * @var \DateTime
     * @JMS\SerializedName("toDate")
     * @JMS\Groups({"chartInfo"})
     */
    protected $toDate;

    /**
     *
     * @var string
     * @JMS\Type("array")
     * @JMS\SerializedName("fields")
     * @JMS\Groups({"chartInfo"})
     */
    protected $fields = array();

    /**
     *
     * @var array
     * @JMS\Type("array")
     * @JMS\SerializedName("step")
     * @JMS\Groups({"chartInfo"})
     *  def = array('d',1)
     */
    protected $step = array();

    public function __construct()
    {
        parent::__construct();

        $this->type = 'Time';
        $this->constrain = false;
    }

    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    public function setFields(array $fields)
    {
        $this->fields = array_pop($fields);
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    public function getFromDate()
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTime $fromDate)
    {
        $this->fromDate = $fromDate;
    }

    public function getToDate()
    {
        return $this->toDate;
    }

    public function setToDate(\DateTime $toDate)
    {
        $this->toDate = $toDate;
    }

    public function getStep()
    {
        return $this->step;
    }

    public function setStep($step)
    {
        $this->step = $step;
    }
}
