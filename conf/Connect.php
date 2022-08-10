<?php
include_once __DIR__ . '/IConecction.php';
class Connect implements IConecction{
	public function init(IConecction $clase,IConecction $clase2){
		$prop = NULL;
		$clase2->configure($prop);
		if($prop){
			define('SERV_SMTP', $prop[0]);
			define('USER_SMTP', $prop[1]);
			define('PDW_SMTP', $prop[2]);
			define('SMTP_TYPE', $prop[3]);
			define('PORT_SMTP', $prop[4]);
			define('SERV_SQL', $prop[5]);
			define('SERV_USER_SQL', $prop[6]);
			define('SERV_PDW_SQL', $prop[7]);
			define('USER_SQL', $prop[8]);
			define('PDW_SQL', $prop[9]);
			define('BD_SQL', $prop[10]);
			define('PORT_SQL', $prop[4]);
		}else{
			//include __DIR__."/../TextController.php";
			//echo utf8_decode (TextController::cargaTexto("error","error","Error"));
		}
	}
	public function configure(&$prop){
			
	}
}

?>