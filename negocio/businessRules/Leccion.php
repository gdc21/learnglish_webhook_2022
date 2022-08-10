<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00016.php';
class Leccion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00016();
	}
	
	/**
	 * Metodo para actualizar Leccion
	 * 
	 * @param entity_lg00016 $lg00016a:
	 *        	informacion a actualizar
	 *        	entity_lg00016 $lg00016b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarLeccion($lg00016a, $lg00016b) {
		return $this->crud->update ( $lg00016a, $lg00016b );
	}
	
	/**
	 * Metodo para agregar un nuevo Leccion
	 * 
	 * @param entity_lg00016 $lg00016:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarLeccion($lg00016) {
		return $this->crud->create ( $lg00016 );
	}
	
	/**
	 * Metodo para obtener Leccion
	 * 
	 * @param entity_lg00016 $lg00016:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenLeccion($lg00016 = "", $total = false) {
		return $this->crud->read ( $lg00016, $total );
	}
	
	/**
	 * Metodo para eliminar Leccion
	 * entity_lg00016 $lg00016: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaLeccion($lg00016) {
		return $this->crud->delete ( $lg00016 );
	}
}
?>