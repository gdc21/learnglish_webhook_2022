<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00025.php';
class CatalogoTipoPregunta {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00025();
	}
	
	/**
	 * Metodo para actualizar CatalogoTipoPregunta
	 * 
	 * @param entity_lg00025 $lg00025a:
	 *        	informacion a actualizar
	 *        	entity_lg00025 $lg00025b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarCatalogoTipoPregunta($lg00025a, $lg00025b) {
		return $this->crud->update ( $lg00025a, $lg00025b );
	}
	
	/**
	 * Metodo para agregar un nuevo CatalogoTipoPregunta
	 * 
	 * @param entity_lg00025 $lg00025:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarCatalogoTipoPregunta($lg00025) {
		return $this->crud->create ( $lg00025 );
	}
	
	/**
	 * Metodo para obtener CatalogoTipoPregunta
	 * 
	 * @param entity_lg00025 $lg00025:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenCatalogoTipoPregunta ($lg00025 = "", $total = false) {
		return $this->crud->read ( $lg00025, $total );
	}
	
	/**
	 * Metodo para eliminar CatalogoTipoPregunta
	 * entity_lg00025 $lg00025: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaCatalogoTipoPregunta($lg00025) {
		return $this->crud->delete ( $lg00025 );
	}
}
?>

