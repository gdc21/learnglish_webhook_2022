<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00017.php';
class Seccion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00017();
	}
	
	/**
	 * Metodo para actualizar Seccion
	 * 
	 * @param entity_lg00017 $lg00017a:
	 *        	informacion a actualizar
	 *        	entity_lg00017 $lg00017b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarSeccion($lg00017a, $lg00017b) {
		return $this->crud->update ( $lg00017a, $lg00017b );
	}
	
	/**
	 * Metodo para agregar un nuevo Seccion
	 * 
	 * @param entity_lg00017 $lg00017:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarSeccion($lg00017) {
		return $this->crud->create ( $lg00017 );
	}
	
	/**
	 * Metodo para obtener Seccion
	 * 
	 * @param entity_lg00017 $lg00017:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenSeccion($lg00017 = "", $total = false) {
		return $this->crud->read ( $lg00017, $total );
	}
	
	/**
	 * Metodo para eliminar Seccion
	 * entity_lg00017 $lg00017: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaSeccion($lg00017) {
		return $this->crud->delete ( $lg00017 );
	}
}
?>