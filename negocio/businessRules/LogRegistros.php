<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00036.php';
class LogRegistros {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00036();
	}
	
	/**
	 * Metodo para actualizar LogRegistros
	 * 
	 * @param entity_lg00036 $lg00036a:
	 *        	informacion a actualizar
	 *        	entity_lg00036 $lg00036b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarLogRegistros($lg00036a, $lg00036b) {
		return $this->crud->update ( $lg00036a, $lg00036b );
	}
	
	/**
	 * Metodo para agregar un nuevo LogRegistros
	 * 
	 * @param entity_lg00036 $lg00036:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarLogRegistros($lg00036) {
		return $this->crud->create ( $lg00036 );
	}
	
	/**
	 * Metodo para obtener LogRegistross
	 * 
	 * @param entity_lg00036 $lg00036:
	 *        	condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenLogRegistros($lg00036 = "", $total = false) {
		return $this->crud->read ( $lg00036, $total );
	}
	
	/**
	 * Metodo para eliminar LogRegistros
	 * entity_lg00036 $lg00036: condion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaLogRegistros($lg00036) {
		return $this->crud->delete ( $lg00036 );
	}
}