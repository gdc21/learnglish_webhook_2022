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

if (isset($_SERVER['HTTPS'])) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
//echo $_SERVER['REQUEST_SCHEME'];
//die;
$directoryPadre = dirname(__DIR__);
$segments = explode( DIRECTORY_SEPARATOR, $directoryPadre);
$carpetaProyecto = $segments[ count($segments) -1 ];

$requestUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $requestUrl );
$dossier = empty($segments[1]) ? "": $segments[1];
$url = $protocol . $_SERVER["SERVER_NAME"] . '/';
if( is_array( $segments ) && in_array( $carpetaProyecto, $segments ) ) {
    foreach( $segments as $path ) {
        if( $path != '' ) {
            $url .= $path.'/';
            if( $path == $carpetaProyecto ) {
                break;
            }
        }
    }
}
$segments = $url;
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
#define("ODA",dirname(__DIR__) . "/portal/oda/");
define("ODA",CONTEXT."portal/oda/");
//Carpeta de acceso a archivos y recursos de lecciones adicionales al objeto oda
#########################################################
# SECCION PRUEBAS
//Carpeta donde se encuentran los Objetos
#define("ODA_REL", "https://learnglishpro.com/portal/oda/");
define("ODA_REL",CONTEXT."portal/oda/");
define("ARCHIVO_FISICO", CONTEXT."portal/archivos/");
#define("ARCHIVO_FISICO", "https://learnglishpro.com/portal/archivos/");
#########################################################

//Se define una carpeta temporal, donde el administrador podra dar de alta PDS.
/*****Encriptacion****************/
define('ENCRYPTION_KEY', 'd0b7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca286');
?>
