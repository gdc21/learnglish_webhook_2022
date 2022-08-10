<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00018.php';
class EstructuraNavegacion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00018();
	}
	
	/**
	 * Metodo para actualizar EstructuraNavegacion
	 * 
	 * @param entity_lg00018 $lg00018a:
	 *        	informacion a actualizar
	 *        	entity_lg00018 $lg00018b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarEstructuraNavegacion($lg00018a, $lg00018b) {
		return $this->crud->update ( $lg00018a, $lg00018b );
	}
	
	/**
	 * Metodo para agregar un nuevo EstructuraNavegacion
	 * 
	 * @param entity_lg00018 $lg00018:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarEstructuraNavegacion($lg00018) {
		return $this->crud->create ( $lg00018 );
	}
	
	/**
	 * Metodo para obtener EstructuraNavegacion
	 * 
	 * @param entity_lg00018 $lg00018:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenEstructuraNavegacion ($lg00018 = "", $total = false) {
		return $this->crud->read ( $lg00018, $total );
	}
	
	/**
	 * Metodo para eliminar EstructuraNavegacion
	 * entity_lg00018 $lg00018: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaEstructuraNavegacion($lg00018) {
		return $this->crud->delete ( $lg00018 );
	}
}
?>