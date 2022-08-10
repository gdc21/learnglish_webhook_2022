<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00029.php';

class Url_Instituciones
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00029();
	}

	/**
	 * Metodo para actualizar UrlInstituciones
	 * @param entity_nm00029 $nm00029a: informacion a actualizar
	 * 		  entity_nm00029 $nm00029b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarUrlInstituciones($nm00029a,$nm00029b)
	{
		return $this->crud->update($nm00029a, $nm00029b);
	}

	/**
	 * Metodo para agregar un nuevo UrlInstituciones
	 * @param entity_nm00029 $nm00029: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarUrlInstituciones($nm00029)
	{
		return $this->crud->create($nm00029);
	}

	/**
	 * Metodo para obtener UrlInstitucioness
	 * @param entity_nm00029 $nm00029: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenUrlInstituciones($nm00029="",$total=false)
	{
		return $this->crud->read($nm00029,$total);
	}

	/**
	 * Metodo para eliminar UrlInstituciones
	 * 		  entity_nm00029 $nm00029: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaUrlInstituciones($nm00029)
	{
		return $this->crud->delete($nm00029);
	}

}