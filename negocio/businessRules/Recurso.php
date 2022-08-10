<?php
require_once __DIR__ .'/../../persistencia/dao/DaoLG00032.php';

class Recurso
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoLG00032();
	}

	/**
	 * Metodo para actualizar Colonia
	 * @param entity_lg00032 $lg00032a: informacion a actualizar
	 * 		  entity_lg00032 $lg00032b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarRecurso($lg00032a,$lg00032b)
	{
		return $this->crud->update($lg00032a, $lg00032b);
	}

	/**
	 * Metodo para agregar un nuevo Colonia
	 * @param entity_lg00032 $lg00032: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarRecurso($lg00032)
	{
		return $this->crud->create($lg00032);
	}

	/**
	 * Metodo para obtener Recurso
	 * @param entity_lg00032 $lg00032: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenRecurso($lg00032="",$total=false)
	{
		return $this->crud->read($lg00032,$total);
	}

	/**
	 * Metodo para eliminar Colonia
	 * 		  entity_lg00032 $lg00032: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaRecurso($lg00032)
	{
		return $this->crud->delete($lg00032);
	}

}