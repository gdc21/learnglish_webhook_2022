<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00014.php';
class Nivel {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00014();
	}
	
	/**
	 * Metodo para actualizar Nivel
	 * 
	 * @param entity_lg00014 $lg00014a:
	 *        	informacion a actualizar
	 *        	entity_lg00014 $lg00014b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarNivel($lg00014a, $lg00014b) {
		return $this->crud->update ( $lg00014a, $lg00014b );
	}
	
	/**
	 * Metodo para agregar un nuevo Nivel
	 * 
	 * @param entity_lg00014 $lg00014:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarNivel($lg00014) {
		return $this->crud->create ( $lg00014 );
	}
	
	/**
	 * Metodo para obtener Nivel
	 * 
	 * @param entity_lg00014 $lg00014:
	 *        	condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenNivel($lg00014 = "", $total = false) {
		return $this->crud->read ( $lg00014, $total );
	}
	
	/**
	 * Metodo para eliminar Nivel
	 * entity_lg00014 $lg00014: condion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaNivel($lg00014) {
		return $this->crud->delete ( $lg00014 );
	}
}
?>