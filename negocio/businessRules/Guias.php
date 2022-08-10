<?php
require_once __DIR__ .'/../../persistencia/dao/DaoLG00031.php';

class Guias
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoLG00031();
	}

	/**
	 * Metodo para actualizar Colonia
	 * @param entity_lg00031 $lg00031a: informacion a actualizar
	 * 		  entity_lg00031 $lg00031b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarGuia($lg00031a,$lg00031b)
	{
		return $this->crud->update($lg00031a, $lg00031b);
	}

	/**
	 * Metodo para agregar un nuevo Colonia
	 * @param entity_lg00031 $lg00031: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarGuia($lg00031)
	{
		return $this->crud->create($lg00031);
	}

	/**
	 * Metodo para obtener Guias
	 * @param entity_lg00031 $lg00031: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenGuia($lg00031="",$total=false)
	{
		return $this->crud->read($lg00031,$total);
	}

	/**
	 * Metodo para eliminar Colonia
	 * 		  entity_lg00031 $lg00031: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaGuia($lg00031)
	{
		return $this->crud->delete($lg00031);
	}

}