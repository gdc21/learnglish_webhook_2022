<?php
include_once __DIR__ . '/IConecction.php';
class doConecction implements IConecction{
	
	private static $ENV=IConecction::ENV;
	private static $info = false;
	
	public function init(IConecction $clase,IConecction $clase2){

		if(!defined ("ENV")){
			$clase->init($clase,$clase2);
		}
		
	}
	
	public function configure(&$prop)
	{
		include_once __DIR__ . '/conf.php';
		ini_set("display_errors","0");
		$venv = new conf();
		define("ENV",self::$ENV);
		$venv->configure(self::$ENV, $prop);
		ini_set("display_errors","1");
	}
}