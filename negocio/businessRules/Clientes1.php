<?php
require_once __DIR__ .'/../../persistencia/dao/DaoLG00027.php';

class Clientes
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoLG00027();
	}

	/**
	 * Metodo para actualizar institucion
	 * @param entity_lg00027 $lg00027a: informacion a actualizar
	 * 		  entity_lg00027 $lg00027b: condion para afectar a determinados registros
	 * @return ID nueva institucion |false: error
	 *
	 */
	public function actualizarInstitucion($lg00027a,$lg00027b)
	{
		return $this->crud->update($lg00027a, $lg00027b);
	}

	/**
	 * Metodo para agregar un nuevo institucion
	 * @param entity_lg00027 $lg00027: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarInstitucion($lg00027)
	{
		return $this->crud->create($lg00027);
	}

	/**
	 * Metodo para obtener Institucions
	 * @param entity_lg00027 $lg00027: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenInstitucion($lg00027="",$total=false)
	{
		return $this->crud->read($lg00027,$total);
	}

	/**
	 * Metodo para obtener Instituciones para paginacion
	 * @param entity_lg00027 $lg00027: condion para afectar a determinado registro
	 * 		  limit: array con llaves start y finish, indican inicio y fin del limite respectivamente
	 * @return arreglo con registros|false: error
	 *
	 */
	public function obtenContenidoPaginacion($lg00027="",$limit)
	{
		return $this->crud->getToPagination($lg00027,$limit);
	}

	/**
	 * Metodo para eliminar Institucion
	 * 		  entity_lg00027 $lg00027: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaInstitucion($lg00027)
	{
		return $this->crud->delete($lg00027);
	}

}