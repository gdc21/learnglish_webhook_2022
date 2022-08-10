<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00021.php';

class Estados
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00021();
	}

	/**
	 * Metodo para actualizar Estados
	 * @param entity_nm00021 $nm00021a: informacion a actualizar
	 * 		  entity_nm00021 $nm00021b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarEstado($nm00021a,$nm00021b)
	{
		return $this->crud->update($nm00021a, $nm00021b);
	}

	/**
	 * Metodo para agregar un nuevo Estados
	 * @param entity_nm00021 $nm00021: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarEstado($nm00021)
	{
		return $this->crud->create($nm00021);
	}

	/**
	 * Metodo para obtener Estadoss
	 * @param entity_nm00021 $nm00021: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenEstado($nm00021="",$total=false)
	{
		return $this->crud->read($nm00021,$total);
	}

	/**
	 * Metodo para eliminar Estados
	 * 		  entity_nm00021 $nm00021: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaEstado($nm00021)
	{
		return $this->crud->delete($nm00021);
	}

}