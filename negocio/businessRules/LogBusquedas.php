<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00013.php';

class LogBusquedas
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00013();
	}

	/**
	 * Metodo para actualizar LogBusquedas
	 * @param entity_nm00013 $nm00013a: informacion a actualizar
	 * 		  entity_nm00013 $nm00013b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogBusquedas($nm00013a,$nm00013b)
	{
		return $this->crud->update($nm00013a, $nm00013b);
	}

	/**
	 * Metodo para agregar un nuevo LogBusquedas
	 * @param entity_nm00013 $nm00013: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogBusquedas($nm00013)
	{
		return $this->crud->create($nm00013);
	}

	/**
	 * Metodo para obtener LogBusquedass
	 * @param entity_nm00013 $nm00013: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogBusquedas($nm00013="",$total=false)
	{
		return $this->crud->read($nm00013,$total);
	}

	/**
	 * Metodo para eliminar LogBusquedas
	 * 		  entity_nm00013 $nm00013: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogBusquedas($nm00013)
	{
		return $this->crud->delete($nm00013);
	}

}