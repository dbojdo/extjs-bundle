<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Series;
use JMS\Serializer\Annotation as JMS;
class Series {
	/**
	 * 
	 * @var boolean
	 * @JMS\Type("boolean")
	 * @JMS\SerializedName("highlight")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $highlight;
	
	/**
   * @JMS\Type("array")
	 * @JMS\SerializedName("shadowAttributes")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $shadowAttributes = array();
	
	/**
   * @JMS\Type("boolean")
	 * @JMS\SerializedName("showInLegend")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $showInLegend;

	/**
   * @JMS\Type("array")
	 * @JMS\SerializedName("tips")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $tips = array();
	
	/**
   * @JMS\Type("string")
	 * @JMS\SerializedName("title")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $title;

	/**
   * @JMS\Type("string")
	 * @JMS\SerializedName("type")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $type;
	
	/**
   * @JMS\Type("string")
	 * @JMS\SerializedName("xField")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $xField;
	
	/**
   * @JMS\Type("string")
	 * @JMS\SerializedName("yField")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $yField;
	
	/**
	 * @JMS\Type("string")
	 * @JMS\SerializedName("axis")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $axis;
	
	/**
	 * @JMS\Type("array")
	 * @JMS\SerializedName("label")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $label;
	
	public function getHighlight(){
		return $this->highlight;
	}
	
	public function setHighlight($highlight){
		$this->highlight = $highlight;
	}
	
	public function getShadowAttributes(){
		return $this->shadowAttributes;
	}
	
	public function setShadowAttributes($shadowAttributes){
		$this->shadowAttributes = $shadowAttributes;
	}
	
	public function getShowInLegend(){
		return $this->showInLegend;
	}
	
	public function setShowInLegend($showInLegend){
		$this->showInLegend = $showInLegend;
	}
	
	public function getTips(){
		return $this->tips;
	}
	
	public function setTips($tips){
		$this->tips = $tips;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setType($type){
		$this->type = $type;
	}
	
	public function setXField($xField) {
		return $this->xField = $xField;
	}
	
	public function getXField() {
		return $this->xField;
	}
	
	public function setYField($yField) {
		return $this->yField = $yField;
	}
	
	public function getYField() {
		return $this->yField;
	}
	
	public function setAxis($axis) {
		$this->axis = $axis;
	}
	
	public function getAxis() {
		return $this->axis;
	}
	
	public function setLabel($label) {
		$this->label = $label;
	}
	
	public function getLabel() {
		return $this->label;
	}
}
?>