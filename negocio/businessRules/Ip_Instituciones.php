<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00017.php';

class Ip_Instituciones
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00017();
	}

	/**
	 * Metodo para actualizar IpInstituciones
	 * @param entity_nm00017 $nm00017a: informacion a actualizar
	 * 		  entity_nm00017 $nm00017b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarIpInstituciones($nm00017a,$nm00017b)
	{
		return $this->crud->update($nm00017a, $nm00017b);
	}

	/**
	 * Metodo para agregar un nuevo IpInstituciones
	 * @param entity_nm00017 $nm00017: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarIpInstituciones($nm00017)
	{
		return $this->crud->create($nm00017);
	}

	/**
	 * Metodo para obtener IpInstitucioness
	 * @param entity_nm00017 $nm00017: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenIpInstituciones($nm00017="",$total=false)
	{
		return $this->crud->read($nm00017,$total);
	}

	/**
	 * Metodo para eliminar IpInstituciones
	 * 		  entity_nm00017 $nm00017: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaIpInstituciones($nm00017)
	{
		return $this->crud->delete($nm00017);
	}

}