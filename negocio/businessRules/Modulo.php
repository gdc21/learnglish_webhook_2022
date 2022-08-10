<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00015.php';
class Modulo {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00015();
	}
	
	/**
	 * Metodo para actualizar Modulo
	 * 
	 * @param entity_lg00015 $lg00015a:
	 *        	informacion a actualizar
	 *        	entity_lg00015 $lg00015b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarModulo($lg00015a, $lg00015b) {
		return $this->crud->update ( $lg00015a, $lg00015b );
	}
	
	/**
	 * Metodo para agregar un nuevo Modulo
	 * 
	 * @param entity_lg00015 $lg00015:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarModulo($lg00015) {
		return $this->crud->create ( $lg00015 );
	}
	
	/**
	 * Metodo para obtener Modulo
	 * 
	 * @param entity_lg00015 $lg00015:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenModulo($lg00015 = "", $total = false) {
		return $this->crud->read ( $lg00015, $total );
	}
	
	/**
	 * Metodo para eliminar Modulo
	 * entity_lg00015 $lg00015: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaModulo($lg00015) {
		return $this->crud->delete ( $lg00015 );
	}
}
?>