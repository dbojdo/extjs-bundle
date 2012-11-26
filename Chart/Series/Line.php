<?php
namespace Webit\Bundle\ExtJsBundle\Chart\Series;
use JMS\SerializerBundle\Annotation as JMS;
class Line extends Series {	
	/**
   * @JMS\Type("boolean")
	 * @JMS\SerializedName("fill")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $fill;
	
	/**
	 * 
	 * @var array
	 * @JMS\Type("array")
	 * @JMS\SerializedName("markerConfig")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $markerConfig = array();

	/**
	 * 
	 * @var unknown_type
	 * @JMS\Type("integer")
	 * @JMS\SerializedName("selectionTolerance")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $selectionTolerance;

	/**
	 * 
	 * @var unknown_type
	 * @JMS\Type("boolean")
	 * @JMS\SerializedName("showMarkers")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $showMarkers;

	/**
	 * 
	 * @var unknown_type
	 * @JMS\Type("boolean")
	 * @JMS\SerializedName("smooth")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $smooth;
 
	/**
	 * 
	 * @var unknown_type
	 * @JMS\Type("array")
	 * @JMS\SerializedName("style")
	 * @JMS\Groups({"chartInfo"})
	 */
	protected $style;
	
	public function __construct() {
//		parent::__construct();
		
		$this->type = 'line';
	}
	
	public function getFill(){
		return $this->fill;
	}
	
	public function setFill($fill){
		$this->fill = $fill;
	}
	
	public function getMarkerConfig(){
		return $this->markerConfig;
	}
	
	public function setMarkerConfig($markerConfig){
		$this->markerConfig = $markerConfig;
	}
	
	public function getSelectionTolerance(){
		return $this->selectionTolerance;
	}
	
	public function setSelectionTolerance($selectionTolerance){
		$this->selectionTolerance = $selectionTolerance;
	}
	
	public function getShowMarkers(){
		return $this->showMarkers;
	}
	
	public function setShowMarkers($showMarkers){
		$this->showMarkers = $showMarkers;
	}
	
	public function getSmooth(){
		return $this->smooth;
	}
	
	public function setSmooth($smooth){
		$this->smooth = $smooth;
	}
	
	public function getStyle(){
		return $this->style;
	}
	
	public function setStyle($style){
		$this->style = $style;
	}
}
?>
