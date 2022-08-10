<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00021.php';
class RespuestasEvaluacion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00021();
	}
	
	/**
	 * Metodo para actualizar RespuestasEvaluacion
	 * 
	 * @param entity_lg00021 $lg00021a:
	 *        	informacion a actualizar
	 *        	entity_lg00021 $lg00021b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarRespuestasEvaluacion($lg00021a, $lg00021b) {
		return $this->crud->update ( $lg00021a, $lg00021b );
	}
	
	/**
	 * Metodo para agregar un nuevo RespuestasEvaluacion
	 * 
	 * @param entity_lg00021 $lg00021:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarRespuestasEvaluacion($lg00021) {
		return $this->crud->create ( $lg00021 );
	}
	
	/**
	 * Metodo para obtener RespuestasEvaluacion
	 * 
	 * @param entity_lg00021 $lg00021:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenRespuestasEvaluacion ($lg00021 = "", $total = false) {
		return $this->crud->read ( $lg00021, $total );
	}
	
	/**
	 * Metodo para eliminar RespuestasEvaluacion
	 * entity_lg00021 $lg00021: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaRespuestasEvaluacion($lg00021) {
		return $this->crud->delete ( $lg00021 );
	}
}
?>