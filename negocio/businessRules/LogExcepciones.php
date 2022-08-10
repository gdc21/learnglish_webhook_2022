<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00015.php';

class LogExcepciones
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00015();
	}

	/**
	 * Metodo para actualizar LogExcepciones
	 * @param entity_nm00015 $nm00015a: informacion a actualizar
	 * 		  entity_nm00015 $nm00015b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogExcepciones($nm00015a,$nm00015b)
	{
		return $this->crud->update($nm00015a, $nm00015b);
	}

	/**
	 * Metodo para agregar un nuevo LogExcepciones
	 * @param entity_nm00015 $nm00015: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogExcepciones($nm00015)
	{
		return $this->crud->create($nm00015);
	}

	/**
	 * Metodo para obtener LogExcepcioness
	 * @param entity_nm00015 $nm00015: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogExcepciones($nm00015="",$total=false)
	{
		return $this->crud->read($nm00015,$total);
	}

	/**
	 * Metodo para eliminar LogExcepciones
	 * 		  entity_nm00015 $nm00015: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogExcepciones($nm00015)
	{
		return $this->crud->delete($nm00015);
	}

}