<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00009.php';
class LogAccesos {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00009();
	}
	
	/**
	 * Metodo para actualizar LogAccesos
	 * 
	 * @param entity_lg00009 $lg00009a:
	 *        	informacion a actualizar
	 *        	entity_lg00009 $lg00009b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarLogAccesos($lg00009a, $lg00009b) {
		return $this->crud->update ( $lg00009a, $lg00009b );
	}
	
	/**
	 * Metodo para agregar un nuevo LogAccesos
	 * 
	 * @param entity_lg00009 $lg00009:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarLogAccesos($lg00009) {
		return $this->crud->create ( $lg00009 );
	}
	
	/**
	 * Metodo para obtener LogAccesoss
	 * 
	 * @param entity_lg00009 $lg00009:
	 *        	condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenLogAccesos($lg00009 = "", $total = false) {
		return $this->crud->read ( $lg00009, $total );
	}
	
	/**
	 * Metodo para eliminar LogAccesos
	 * entity_lg00009 $lg00009: condion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaLogAccesos($lg00009) {
		return $this->crud->delete ( $lg00009 );
	}
}