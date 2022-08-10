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
						"usuario servidor aplicacion",
						'password',
						"smtp",
						"423",
						"db_server",
						"db_user",
						'db_password',
						"db_user",
						'db_password',
						"db_name",
						"3306"
				);
			}
			
		if($env == "DEV"){
				$conf =  array(
						"localhost",
						"usuario servidor aplicacion",
						'password',
						"smtp",
						"423",
						"db_server",
						"db_user",
						'db_password',
						"db_user",
						'db_password',
						"db_name",
						"3306"
				);
			}
			
		if($env == "PROD"){
				$conf = array(
						"localhost",
						"usuario servidor aplicacion",
						'password',
						"smtp",
						"423",
						"db_server",
						"db_user",
						'password',
						"db_user",
						'db_password',
						"db_name",
						"3306"
				);
			}
		}
	}
?>
