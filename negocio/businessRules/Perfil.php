<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00002.php';
class Perfil {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00002 ();
	}
	
	/**
	 * Metodo para actualizar perfil
	 * 
	 * @param entity_lg00002 $lg00002a:
	 *        	informacion a actualizar
	 *        	entity_lg00002 $lg00002b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarPerfil($lg00002a, $lg00002b) {
		return $this->crud->update ( $lg00002a, $lg00002b );
	}
	
	/**
	 * Metodo para agregar un nuevo perfil
	 * 
	 * @param entity_lg00002 $lg00002:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarPerfil($lg00002) {		
		return $this->crud->create ( $lg00002 );
	}
	
	/**
	 * Metodo para obtener perfiles
	 * 
	 * @param entity_lg00002 $lg00002:
	 *        	condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenPerfiles($lg00002 = "", $total = false) {
		return $this->crud->read ( $lg00002, $total );
	}

	/**
	 * Metodo para eliminar perfil
	 * entity_lg00002 $lg00002: condion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaPerfil($lg00002) {
		return $this->crud->delete ( $lg00002 );
	}
	

}