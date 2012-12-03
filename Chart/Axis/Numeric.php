<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Axis;
use JMS\Serializer\Annotation as JMS;
class Numeric extends Axis {
	/**
	 * 
	 * @var bool
	 * @JMS\Type("boolean")
	 * @JMS\SerializedName("adjustMaximumByMajorUnit")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $adjustMaximumByMajorUnit;
	
	/**
	 * @JMS\Type("boolean")
	 * @JMS\SerializedName("adjustMinimumByMajorUnit")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $adjustMinimumByMajorUnit;

	/**
   * @JMS\Type("boolean")
	 * @JMS\SerializedName("constrain")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $constrain;

	/**
   * @JMS\Type("integer")
	 * @JMS\SerializedName("decimals")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $decimals;
	
	/**
   * @JMS\Type("double")
	 * @JMS\SerializedName("maximum")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $maximum;
	
	/**
   * @JMS\Type("double")
	 * @JMS\SerializedName("minimum")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $minimum;
	
	public function __construct() {
		//parent::__construct();
		$this->type = 'Numeric';
		$this->position = self::POSITION_LEFT;
	}
	
	public function getAdjustMaximumByMajorUnit(){
		return $this->adjustMaximumByMajorUnit;
	}

	public function setAdjustMaximumByMajorUnit($adjustMaximumByMajorUnit){
		$this->adjustMaximumByMajorUnit = $adjustMaximumByMajorUnit;
	}

	public function getAdjustMinimumByMajorUnit(){
		return $this->adjustMinimumByMajorUnit;
	}

	public function setAdjustMinimumByMajorUnit($adjustMinimumByMajorUnit){
		$this->adjustMinimumByMajorUnit = $adjustMinimumByMajorUnit;
	}

	public function getConstrain(){
		return $this->constrain;
	}

	public function setConstrain($constrain){
		$this->constrain = $constrain;
	}

	public function getDecimals(){
		return $this->decimals;
	}

	public function setDecimals($decimals){
		$this->decimals = $decimals;
	}

	public function getMaximum(){
		return $this->maximum;
	}

	public function setMaximum($maximum){
		$this->maximum = $maximum;
	}

	public function getMinimum(){
		return $this->minimum;
	}

	public function setMinimum($minimum){
		$this->minimum = $minimum;
	}
}
?>