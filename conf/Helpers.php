<?php
/** Retornara un array con las columnas especificadas como parametro y nombres opcionales
 * @param array $dataArray
 * @param array $columnas
 * @param array $nombresColumnas
 * @return array|string
 */
function pluck($dataArray, $columnas = [], $nombresColumnas = []){

    $data = [];
    if($nombresColumnas != [] && count($nombresColumnas) != count($columnas)){
        return "Verificar numero de columnas sean las mismas.";
    }
    $cambiarNombreColumnas = $nombresColumnas == [] ? 0:1;

    foreach ($dataArray as $keyDato => $dato){
        foreach ($columnas as $keyColumna => $columna){
            if($cambiarNombreColumnas){
                $data[$keyDato][$nombresColumnas[$keyColumna]] = $dato[$columna];
                continue;
            }
            $data[$keyDato][$columna] = $dato[$columna];
        }
    }
    return $data;
}

/** Verifica si se encuentra activo un modulo del sistema
 * @param $nombreModulo
 * @return bool
 */
function verificaModuloSistemaActivo($nombreModulo){
    $accesosModulosSistema = (new Accesomodulos ())->obtenAccesomodulos ((object) array(
        'LGF0430002' => $nombreModulo,
        'LGF0430005' => 1
    ));
    if(!empty($accesosModulosSistema)){
        return 1;
    }
    return 0;
}

function verificaModuloSistemaRetornoValor($nombreModulo){
    $accesosModulosSistema = (new Accesomodulos ())->obtenAccesomodulos ((object) array(
        'LGF0430002' => $nombreModulo,
        'LGF0430005' => 1
    ));
    if(!empty($accesosModulosSistema)){
        return $accesosModulosSistema[0]['LGF0430008'];
    }
    return 0;
}

function verificarClaveSistemaCache($clave){
    $accesosModulosSistema = (new Accesomodulos ())->obtenAccesomodulos (( object ) array (
        "LGF0430002" => 'SistemaCache',
        "LGF0430005" => '1',
        "LGF0430007" => $clave
    ) );

    if($accesosModulosSistema != null){
        return 1;
    }else{
        return 0;
    }
}