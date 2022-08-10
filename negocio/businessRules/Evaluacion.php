<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00019.php';
class Evaluacion {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00019();
	}


    public function verificarDocumentosYspeakCargado(){
        return $this->crud->read ( $lg00019, $total );
    }
	
	/**
	 * Metodo para actualizar Evaluacion
	 * 
	 * @param entity_lg00019 $lg00019a:
	 *        	informacion a actualizar
	 *        	entity_lg00019 $lg00019b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarEvaluacion($lg00019a, $lg00019b) {
		return $this->crud->update ( $lg00019a, $lg00019b );
	}
	
	/**
	 * Metodo para agregar un nuevo Evaluacion
	 * 
	 * @param entity_lg00019 $lg00019:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarEvaluacion($lg00019) {
		return $this->crud->create ( $lg00019 );
	}
	
	/**
	 * Metodo para obtener Evaluacion
	 * 
	 * @param entity_lg00019 $lg00019:
	 *        	condicion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenEvaluacion ($lg00019 = "", $total = false) {
		return $this->crud->read ( $lg00019, $total );
	}
	
	/**
	 * Metodo para eliminar Evaluacion
	 * entity_lg00019 $lg00019: condicion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaEvaluacion($lg00019) {
		return $this->crud->delete ( $lg00019 );
	}
}
?>