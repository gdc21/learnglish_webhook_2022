<?php
// $conf =  array(
// 		"ip servidor aplicacion",
// 		"usuario servidor aplicacion",
// 		"contraseña servidor aplicacion",
// 		"protocolo de envio de correo",
// 		"puerto para el envio de correo",
// 		"IP servidor base de datos",
// 		"usuario servidor base de datos",
// 		"contraseña servidor base de datos",
// 		"usuario base de datos",
// 		"contraseña base de datps",
// 		"nombre base de datos",
// 		"puerto base de datos"
// );

	class conf{
		public function configure($env,&$conf){
			if($env == "QA"){
				$conf =  array(
						"localhost",
						"root",
						'Srv20LeAp17$',
						"smtp",
						"423",
						"10.10.10.129",
						"root",
						'Srv20LeBd17$',
						"root",
						'BD$L34rngl1sh2017',
						"lg222016_27112020",
						"3306"
				);
			}
			
		if($env == "DEV"){
				$conf =  array(
						"localhost",
						"root",
						'Srv20LeAp17$',
						"smtp",
						"423",
						"10.10.10.129",
						"root",
						'Srv20LeBd17$',
						"root",
						'BD$L34rngl1sh2017',
						"lg222016_27112020",
						"3306"
				);
			}
			
		if($env == "PROD"){
				$conf = array(
						"10.10.10.128",
						"root",
						'Srv20LeAp17$',
						"smtp",
						"423",
						"10.10.10.129",
						"gdc",
						'L34rngl1shBd$2017',
						"gdc",
						'L34rngl1sh$BD2017',
						"proni_seiem",
						"3306"
				);
			}
		}
	}
?>
