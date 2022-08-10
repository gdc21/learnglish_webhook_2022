<?php
include_once __DIR__ . '/Cache/Cache.php';

class SistemaDeCache {

    private static $instance;

    public static function getInstance(){
        if (!self::$instance instanceof self) {
            Cache::configure(array(
                'cache_dir' => dirname(__DIR__) . '/Cache/carpetaAlmacenamientoCache',
                'expires' => 5 // minutos
            ));
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function verificaSiEstaEnCacheYretornaData($query){
        return Cache::get($query);
    }

    public function guardaUnElementoEnCache($md5Query, $data = []){
        Cache::put($md5Query, $data);
    }

    public function limpiarTodaLaCache(){
        Cache::flush();
    }

}