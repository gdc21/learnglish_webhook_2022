<?php
class SniffClient
{
	private $userAgent="";
	private $device = '';
	protected $deviceList = array(
			'mobile'	 => array('iphone', 'android', 'blackberry'),
			//'tablet' => array('ipad', 'trident', 'kindle_fire', 'silk', 'opera')
			'tablet' => array('ipad', 'kindle_fire', 'silk', 'opera')
	);
	private function searchDevice($groupDevice){
		foreach ($this->deviceList[ $groupDevice ] as $key => $type) {
			if( stripos($this->userAgent, $type) ){
				$this->device = $groupDevice;
				break;
			}
		}
	}
	private function whatDevice(){
		foreach ( $this->deviceList as $groupDevice => $value ) {
			$this->searchDevice( $groupDevice );
			if($this->device != '') break;
		}
	}
	private function createObjectDevice(){
		switch ($this->device) {
			case 'mobile':
				define('RESOURCE',"phone");
				break;
			case 'tablet':
				define('RESOURCE',"tablet");
				break;

			default:
				define('RESOURCE',"desktop");
				break;
		}
	}
	function __construct(){
		$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->whatDevice();
		$this->createObjectDevice();

	}
	function __destruct(){
	}
}
?>