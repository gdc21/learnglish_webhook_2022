<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00033.php';
class PasswordReset {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00033 ();
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
	public function actualizarPassUsuario($lg00001a, $lg00001b) {
		return $this->crud->update ( $lg00001a, $lg00001b );
	}
	
	/**
	 * Metodo para agregar un nuevo usuario
	 * 
	 * @param entity_lg00001 $lg00033:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarPassUsuario($lg00033) {
		return $this->crud->create ( $lg00033 );
	}

	public function obtenerPassUsuario($lg00033 = "", $total = false) {
		return $this->crud->read ( $lg00033, $total );
	}
}