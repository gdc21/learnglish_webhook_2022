<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00004.php';

class Usuario_Permisos
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00004();
	}

	/**
	 * Metodo para actualizar usuarioPermisos
	 * @param entity_NM00004 $NM00004a: informacion a actualizar
	 * 		  entity_NM00004 $NM00004b: condion para afectar a determinados registros
	 * @return ID nuevo registro |false: error
	 *
	 */
	public function actualizarUsarioPermisos($NM00004a,$NM00004b)
	{
		return $this->crud->update($NM00004a, $NM00004b);
	}

	/**
	 * Metodo para agregar un nuevo permiso
	 * @param entity_NM00004 $NM00004: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarUsuarioPermisos($NM00004)
	{
		return $this->crud->create($NM00004);
	}

	/**
	 * Metodo para obtener permisos
	 * @param entity_NM00004 $NM00004: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenUsuarioPermisos($NM00004="",$total=false)
	{
		return $this->crud->read($NM00004,$total);
	}

	/**
	 * Metodo para obtener permisos para paginacion
	 * @param entity_NM00004 $NM00004: condion para afectar a determinado registro
	 * 		  limit: array con llaves start y finish, indican inicio y fin del limite respectivamente
	 * @return arreglo con registros|false: error
	 *
	 */
	public function obtenContenidoPaginacion($NM00004="",$limit)
	{
		return $this->crud->getToPagination($NM00004,$limit);
	}

	/**
	 * Metodo para eliminar usuarioPermisos
	 * 		  entity_NM00004 $NM00004: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaUsuarioPermisos($NM00004)
	{
		return $this->crud->delete($NM00004);
	}

}