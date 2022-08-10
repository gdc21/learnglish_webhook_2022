<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00020.php';
class CatalogoPreguntasEval {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00020();
	}
	
	/**
	 * Metodo para actualizar CatalogoPreguntasEval
	 * 
	 * @param entity_lg00020 $lg00020a:
	 *        	informacion a actualizar
	 *        	entity_lg00020 $lg00020b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarCatalogoPreguntasEval($lg00020a, $lg00020b) {
		return $this->crud->update ( $lg00020a, $lg00020b );
	}
	
	/**
	 * Metodo para agregar un nuevo CatalogoPreguntasEval
	 * 
	 * @param entity_lg00020 $lg00020:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarCatalogoPreguntasEval($lg00020) {
		return $this->crud->create ( $lg00020 );
	}
	
	/**
	 * Metodo para obtener CatalogoPreguntasEval
	 * 
	 * @param entity_lg00020 $lg00020:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenCatalogoPreguntasEval ($lg00020 = "", $total = false) {
		return $this->crud->read ( $lg00020, $total );
	}
	
	/**
	 * Metodo para eliminar CatalogoPreguntasEval
	 * entity_lg00020 $lg00020: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaCatalogoPreguntasEval($lg00020) {
		return $this->crud->delete ( $lg00020 );
	}
}
?>
