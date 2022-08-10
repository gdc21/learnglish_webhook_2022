<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00024.php';
class CatalogoVersiones {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00024();
	}
	
	/**
	 * Metodo para actualizar CatalogoVersiones
	 * 
	 * @param entity_lg00024 $lg00024a:
	 *        	informacion a actualizar
	 *        	entity_lg00024 $lg00024b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarCatalogoVersiones($lg00024a, $lg00024b) {
		return $this->crud->update ( $lg00024a, $lg00024b );
	}
	
	/**
	 * Metodo para agregar un nuevo CatalogoVersiones
	 * 
	 * @param entity_lg00024 $lg00024:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarCatalogoVersiones($lg00024) {
		return $this->crud->create ( $lg00024 );
	}
	
	/**
	 * Metodo para obtener CatalogoVersiones
	 * 
	 * @param entity_lg00024 $lg00024:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenCatalogoVersiones ($lg00024 = "", $total = false) {
		return $this->crud->read ( $lg00024, $total );
	}
	
	/**
	 * Metodo para eliminar CatalogoVersiones
	 * entity_lg00024 $lg00024: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaCatalogoVersiones($lg00024) {
		return $this->crud->delete ( $lg00024 );
	}
}
?>
