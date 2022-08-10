<?php
require_once __DIR__ .'/../../persistencia/dao/DaoEM00027.php';

class SolicitudTrial
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoEM00027();
	}

	/**
	 * Metodo para actualizar SolicitudTrial
	 * @param entity_em00027 $em00027a: informacion a actualizar
	 * 		  entity_em00027 $em00027b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarSolicitudTrial($em00027a,$em00027b)
	{
		return $this->crud->update($em00027a, $em00027b);
	}

	/**
	 * Metodo para agregar un nuevo SolicitudTrial
	 * @param entity_em00027 $em00027: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarSolicitudTrial($em00027)
	{
		return $this->crud->create($em00027);
	}

	/**
	 * Metodo para obtener SolicitudTrials
	 * @param entity_em00027 $em00027: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenSolicitudTrial($em00027="",$total=false)
	{
		return $this->crud->read($em00027,$total);
	}

	/**
	 * Metodo para eliminar SolicitudTrial
	 * 		  entity_em00027 $em00027: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaSolicitudTrial($em00027)
	{
		return $this->crud->delete($em00027);
	}

}