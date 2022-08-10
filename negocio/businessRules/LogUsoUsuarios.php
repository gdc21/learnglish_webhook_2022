<?php
require_once __DIR__ .'/../../persistencia/dao/DaoLG00026.php';

class LogUsoUsuarios
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoLG00026();
	}

	/**
	 * Metodo para actualizar LogUsoUsuarios
	 * @param entity_lg00026 $lg00026a: informacion a actualizar
	 * 		  entity_lg00026 $lg00026b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogUsoUsuarios($lg00026a,$lg00026b)
	{
		return $this->crud->update($lg00026a, $lg00026b);
	}

	/**
	 * Metodo para agregar un nuevo LogUsoUsuarios
	 * @param entity_lg00026 $lg00026: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogUsoUsuarios($lg00026)
	{
		return $this->crud->create($lg00026);
	}

	/**
	 * Metodo para obtener LogUsoUsuarios
	 * @param entity_lg00026 $lg00026: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogUsoUsuarios($lg00026="",$total=false)
	{
		return $this->crud->read($lg00026,$total);
	}

	/**
	 * Metodo para eliminar LogUsoUsuarios
	 * 		  entity_lg00026 $lg00026: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogUsoUsuarios($lg00026)
	{
		return $this->crud->delete($lg00026);
	}

}