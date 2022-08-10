<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00037.php';
class AccesoLecciones {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00037 ();
	}
	
	/**
	 * Metodo para actualizar usuario
	 * 
	 * @param entity_lg00001 $lg00001a:
	 *        	informacion a actualizar
	 *        	entity_lg00001 $lg00001b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarAccesoLeccion($lg00001a, $lg00001b) {
		return $this->crud->update ( $lg00001a, $lg00001b );
	}
	
	/**
	 * Metodo para agregar un nuevo usuario
	 * 
	 * @param entity_lg00001 $lg00037:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarAccesoLeccion($lg00037) {
		return $this->crud->create ( $lg00037 );
	}

	public function obtenerAccesoLeccion($lg00037 = "", $total = false) {
		return $this->crud->read ( $lg00037, $total );
	}

	public function eliminaAccesoLeccion($lg00037) {
		return $this->crud->delete ( $lg00037 );
	}

	public function validateAssignedTeacher( $idGroup ) {
		return $this->crud->checkTeacher($idGroup);
	}
}