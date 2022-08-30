<?php
/**
 * Clase general para interaccion con la base de datos
 * 
 * Date: 17/03/2016
 * Author: Fabian Perez 
 * 
 */

require_once 'Database.php';
require_once 'ModelTools.php';

class UniversalDatabase extends ModelTools
{
	private $command;
	protected $query, 
			  $error,
			  $lastId,
			  $params = array();

  /**
   * Funcion general para insertar infroamcion a la base de datos
   * @param String table: nombre de la tabla a ser afectada
   * 		Array data: informacion a almacenar ej.- array(nombre_campo_tabla=>valor);
   * @return true|false
   *
   */
 	protected function doGeneralDelete($table,$condition){
  		$condition = $this->getStringConditions($condition);
  		$this->query = "DELETE FROM $table WHERE $condition";
        SistemaDeCache::getInstance()->limpiarTodaLaCache();
  		return $this->doSingleQuery();
  	}
  	
  /**
   * Funcion general para insertar infroamcion a la base de datos
   * @param String table: nombre de la tabla a ser afectada
   * 		Array data: informacion a almacenar ej.- array(nombre_campo_tabla=>valor);
   * @return true|false 
   *
   */
  	protected function doGeneralInsert($table,$data){
  		$values = $this->getStringValue($data);
  		$this->query = "INSERT INTO $table(".implode(",",array_keys($data)).") VALUES($values)";
  		// echo $this->query."<br>";
		$status = $this->doSingleQuery();
        SistemaDeCache::getInstance()->limpiarTodaLaCache();
		return Database::getInstance()->getDb()->lastInsertId();
		/*$this->lastId = Database::getInstance()->getDb()->lastInsertId();
		return $status;*/
  	}
  	
  	/**
  	 * Funcion general para buscar infroamcion en la base de datos
  	 * @param String table: nombre de la tabla en la que queremos buscar
  	 * 		  String condition: filtros para condicionar la query (campo de id)
  	 * @return array asociativo con la informacion disponible
  	 *
  	 */
  	protected function doGeneralSelect($table,$condition){
  		$condition =  $this->cleanWhereConditional($condition);
  		$this->query = "SELECT * FROM $table $condition";
  		return $this->doSelect();
  	}
  	
  	/**
  	 * Funcion general para insertar infroamcion a la base de datos
  	 * @param String table: nombre de la tabla a ser afectada
  	 * 		  String values: informacion a almacenar
  	 * 		  String condition: filtros para condicionar la query (campo de id)
  	 * @return true|false
  	 *
  	 */
  	protected function doGeneralUpdate($table,$values,$condition){
  		$values = $this->getStringKeyValue($values);
  		$condition = $this->getStringConditions($condition);
  		$this->query = "UPDATE $table SET $values WHERE $condition";
  		// echo $this->query."<br>";
        SistemaDeCache::getInstance()->limpiarTodaLaCache();
  		return $this->doSingleQuery();
  	}

    private function buscarEnArray($arrayElementosBuscar, $arrayBusqueda){
        foreach ($arrayElementosBuscar as $elemento){
            if(in_array($elemento, $arrayBusqueda)){
                return true;
            }
        }
        return false;
    }
	
	/**
	 * Funcion general para obtencion de informacion
	 * @return array asociativo con la informacion disponible
	 * 
	 */
	protected function doSelect(){
        #Sistema de cache para retorno de data y almacenamiento de la misma
        $debug2 = debug_backtrace (); 
        #Traza de funciones seguimiento
        $funcionesTraza = array_column($debug2, 'function');
        #Lista de funciones que no seran almacenadas en cache (intentos de acceso por ejemplo)
        $funcionesExcluidas = [
            'obtenerestadisticacliente',
            'listar_alumnos_grupo_especifico',
            'informacionGrupos',
            'gruposyprofesoresdeinstitucion',
            'asignaralumnosagrupodesdecurps',
            'actualizarLogRegistros',
            'agregarLogRegistros',
            'informacion',
            'informacion_usuario',
            'informacionUsuario',
            'login',
            'logout',
            'obtenUsuario',
            'ultimoAcceso',
            'validarUsuario',
            'obtenerAvancesAlumno',
            'evaluacionSeleccionarLeccionesAlumno',
            'obtenerEstadisticasEvaluacionesTrimestrales',
            'verificarNumeroDeIntentos',
            'guardarEvaluacionTrimestral',
            'obtenerEstadisticasEvaluacionesTrimestrales',
            'obtenerEstadisticasAlumnosInstitucion',
            'primary',
            'secundary',
            'preschool',
            'means',
            'navegar',
            'mostrarObjetos',
            'getEvaluacion',
            'obtenAccesomodulos',
            'verificarDocumentosYspeakCargado',
            'existe_evaluacion_hecha',
            'obtenerResumenAvancesLecciones'

        ];
        #Verificar si existe una funcion a excluir de la lista $funcionesTraza
        $esFuncionAexcluirDeCache = $this->buscarEnArray($funcionesExcluidas, $funcionesTraza);
        #Si Se excluye hace el proceso de caching
        if(!$esFuncionAexcluirDeCache){
            $md5Query = md5($this->query);
            #echo "Hare este query: ".$this->query."<hr>";
            $data = SistemaDeCache::getInstance()->verificaSiEstaEnCacheYretornaData(
                $md5Query
            );
        }else{
            $data = 0;
        }

        if( !$data ){
            //Lanzamos la query y validamos que no regrese falso (falso: error en consultar la BD)
            if($this->error = $this->make()) {
                return false;
            }
            #echo ">Tuve que consultar query: ".$this->query."<br>$md5Query<hr>";
            $this->numRows = $this->command->rowCount();
            $data = $this->command->fetchAll(PDO::FETCH_ASSOC);
            if(!$esFuncionAexcluirDeCache) {
                SistemaDeCache::getInstance()->guardaUnElementoEnCache(
                    $md5Query, $data
                );
            }
            return $data;
        }else{
            #echo "Ya tengo cache del query: ".$md5Query."<hr>";
        }
        return $data;
	}
	
	/**
	 * Funcion general para insertar infroamcion a la base de datos
	 * @return array asociativo con la informacion disponible
	 *
	 */
	protected function doSingleQuery(){
		//Lanzamos la query y validamos que no regrese falso (falso: error en consultar la BD)
		if($this->error = $this->make())
			return false;
	
		return true;
	}
	
	/**
	 * Funcion general para obtencion de informacion de un registro en particular
	 * @return array asociativo con la informacion disponible
	 *
	 */
	protected function getById(){
		//Lanzamos la query y validamos que no regrese falso (falso: error en consultar la BD)
		if($this->error = $this->make())
			return false;
	
		//Regresamos el retultado obtenido
		return $this->command->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * Funcion general para lanzar query's
	 *
	 */
	private function make(){
		try {
			// Preparar sentencia
			$this->command = Database::getInstance()->getDb()->prepare($this->query);
			// Ejecutar sentencia preparada
			$this->command->execute($this->params);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}
}