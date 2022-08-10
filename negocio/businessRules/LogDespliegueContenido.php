<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00014.php';

class LogDespliegueContenido
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00014();
	}

	/**
	 * Metodo para actualizar LogDespliegueContenido
	 * @param entity_nm00014 $nm00014a: informacion a actualizar
	 * 		  entity_nm00014 $nm00014b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogDespliegueContenido($nm00014a,$nm00014b)
	{
		return $this->crud->update($nm00014a, $nm00014b);
	}

	/**
	 * Metodo para agregar un nuevo LogDespliegueContenido
	 * @param entity_nm00014 $nm00014: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogDespliegueContenido($nm00014)
	{
		return $this->crud->create($nm00014);
	}

	/**
	 * Metodo para obtener LogDespliegueContenidos
	 * @param entity_nm00014 $nm00014: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogDespliegueContenido($nm00014="",$total=false)
	{
		return $this->crud->read($nm00014,$total);
	}

	/**
	 * Metodo para eliminar LogDespliegueContenido
	 * 		  entity_nm00014 $nm00014: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogDespliegueContenido($nm00014)
	{
		return $this->crud->delete($nm00014);
	}

}