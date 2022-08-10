<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00024.php';

class LogUsoPaginas
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00024();
	}

	/**
	 * Metodo para actualizar LogUsoPaginas
	 * @param entity_nm00024 $nm00024a: informacion a actualizar
	 * 		  entity_nm00024 $nm00024b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogUsoPaginas($nm00024a,$nm00024b)
	{
		return $this->crud->update($nm00024a, $nm00024b);
	}

	/**
	 * Metodo para agregar un nuevo LogUsoPaginas
	 * @param entity_nm00024 $nm00024: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogUsoPaginas($nm00024)
	{
		return $this->crud->create($nm00024);
	}

	/**
	 * Metodo para obtener LogUsoPaginass
	 * @param entity_nm00024 $nm00024: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogUsoPaginas($nm00024="",$total=false)
	{
		return $this->crud->read($nm00024,$total);
	}

	/**
	 * Metodo para eliminar LogUsoPaginas
	 * 		  entity_nm00024 $nm00024: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogUsoPaginas($nm00024)
	{
		return $this->crud->delete($nm00024);
	}

}