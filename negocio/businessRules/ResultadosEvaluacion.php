<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00022.php';
class ResultadosEvaluacion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00022();
	}
	
	/**
	 * Metodo para actualizar ResultadosEvaluacion
	 * 
	 * @param entity_lg00022 $lg00022a:
	 *        	informacion a actualizar
	 *        	entity_lg00022 $lg00022b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarResultadosEvaluacion($lg00022a, $lg00022b) {
		return $this->crud->update ( $lg00022a, $lg00022b );
	}
	
	/**
	 * Metodo para agregar un nuevo ResultadosEvaluacion
	 * 
	 * @param entity_lg00022 $lg00022:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarResultadosEvaluacion($lg00022) {
		return $this->crud->create ( $lg00022 );
	}
	
	/**
	 * Metodo para obtener ResultadosEvaluacion
	 * 
	 * @param entity_lg00022 $lg00022:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenResultadosEvaluacion ($lg00022 = "", $total = false) {
		return $this->crud->read ( $lg00022, $total );
	}
	
	/**
	 * Metodo para eliminar ResultadosEvaluacion
	 * entity_lg00022 $lg00022: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaResultadosEvaluacion($lg00022) {
		return $this->crud->delete ( $lg00022 );
	}
}
?>

