<?php

// Se establece las rutas donde se encuentras las clases. Necesario para el autoload
set_include_path(get_include_path() .
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../negocio/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../negocio/Controller").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../negocio/Controller/core/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../negocio/businessRules/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../../../portal/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../../Observador/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../persistencia/entity/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../persistencia/ucc/").
PATH_SEPARATOR .
realpath(dirname(__FILE__) . "/../../mailt/")
);
include_once __DIR__."/doConecction.php";
include_once __DIR__."/Connect.php";
(new doConecction())->init((new Connect()),new doConecction());
// SniffClient determinara el tipo de recurso que utilizara el sistema
//include "SniffClient.php";
//$worker  = new SniffClient();

// Obtenemos el context. Es decir el nombre del dominio o subdominio para realizar la importacion de recursos
// mediante una ruta dinamica.
$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $_SERVER['REQUEST_URI_PATH']);
$carpetaPadre = explode('\\', $carpetaPadre);
$carpetaPadre = $carpetaPadre[count($carpetaPadre)-1] ."/";
$dossier = empty($segments[1])?"":$segments[1]."/";
if($dossier !== $carpetaPadre){
	$dossier="";
}
$port ="";
if($_SERVER['SERVER_PORT'] != "80"){
	$port = ":".$_SERVER['SERVER_PORT'];
}
$segments = "http://" . $_SERVER ["SERVER_NAME"] .$port. "/" . $dossier;
//Se define el context. Para la utlizacion de las rutas relativas
define('CONTEXT',$segments );
/******************************/
//Se el nombre del Sistema.
define("APP_NAME","LEARNGLISH");
//Ruta absoluta para llamar a las carpetas de controlador.
define('CONTROLLER',dirname(__FILE__)."/../negocio/Controller/");
//Ruts  absoluta que apunta a las clases de negocio del modelo.
define('MODEL',dirname(__FILE__)."/../negocio/businessRules/");
//Ruta absoluta que apunta a las clases entity del modelo
define('ENTITY',dirname(__FILE__) . "/../persistencia/entity/");
//Ruta absoluta que apunta a las clases entity del modelo
define('UCC',dirname(__FILE__) . "/../persistencia/ucc/");
//Ruta absoluta que apunta a las clases entity del dao
define('DAO',dirname(__FILE__) . "/../persistencia/dao/");
//Ruta relativa que apunta a la herramienta Bootstrap para la vista
define('BOOTSTRAP',CONTEXT."portal/bootstrap");
//Ruta relativa que apunta a la carpeta de componentes para la vista
define('COMPONENTES',CONTEXT."portal/componentes");
//Ruta absoluta que apunta a los elementos para el envio de mail
define('MAIL',dirname(__FILE__) . "/../negocio/mailt/");
//Ruta absoluta que apunta a las imagenes
define("IMG_REALPATH",dirname(__FILE__) . "/../portal/IMG/");
//Ruta relativa que apunta a las imagenes
define("IMG",CONTEXT."portal/IMG/");
//Carpeta para colocar otros recursos para la aplicacion (archivos)
define("RESOURCE_APP",dirname(__FILE__) . "/../portal/RESOURCE/");
//Carpeta donde se encuentran las ODAS _ Absoluto
define("ODA",dirname(__FILE__) . "/../portal/oda/");
//Carpeta donde se encuentran los Objetos
define("ODA_REL",CONTEXT. "portal/oda/");
//Se define una carpeta temporal, donde el administrador podra dar de alta PDS.
/*****Encriptacion****************/
define('ENCRYPTION_KEY', 'd0b7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca286');
?>
