<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00023.php';
class DetalleResultadosEvaluacion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00023();
	}
	
	/**
	 * Metodo para actualizar DetalleResultadosEvaluacion
	 * 
	 * @param entity_lg00023 $lg00023a:
	 *        	informacion a actualizar
	 *        	entity_lg00023 $lg00023b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarDetalleResultadosEvaluacion($lg00023a, $lg00023b) {
		return $this->crud->update ( $lg00023a, $lg00023b );
	}
	
	/**
	 * Metodo para agregar un nuevo DetalleResultadosEvaluacion
	 * 
	 * @param entity_lg00023 $lg00023:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarDetalleResultadosEvaluacion($lg00023) {
		return $this->crud->create ( $lg00023 );
	}
	
	/**
	 * Metodo para obtener DetalleResultadosEvaluacion
	 * 
	 * @param entity_lg00023 $lg00023:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenDetalleResultadosEvaluacion ($lg00023 = "", $total = false) {
		return $this->crud->read ( $lg00023, $total );
	}
	
	/**
	 * Metodo para eliminar DetalleResultadosEvaluacion
	 * entity_lg00023 $lg00023: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaDetalleResultadosEvaluacion($lg00023) {
		return $this->crud->delete ( $lg00023 );
	}
}
?>
