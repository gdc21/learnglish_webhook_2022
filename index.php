<?php
session_start();
//var_dump( $_SERVER );
//die;
//Necesario para localizar la carpeta padre y generar el CONTEXT
$carpetaPadre = dirname(__FILE__);
//El archivo Init, configura todas las rutas.
include_once 'conf/Init.php';
// Incluimos el archivo Route.php para empezar la ejecucion del sistema
include_once 'conf/Route.php';

//Archivos de funciones utiles en multiples archivos
include_once 'conf/Helpers.php';

#SistemaDeCache::getInstance()->hazAlgo(); // Uso de sistema de cache
#SistemaDeCache::getInstance()->limpiarTodaLaCache();
include_once 'conf/SistemaDeCache.php';
// Se crea un objeto
$route = new Route;
// Se llama al metodo action
$route -> action();
?>