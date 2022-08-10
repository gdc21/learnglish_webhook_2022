<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00020.php';

class Ciudades
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00020();
	}

	/**
	 * Metodo para actualizar Ciudades
	 * @param entity_nm00020 $nm00020a: informacion a actualizar
	 * 		  entity_nm00020 $nm00020b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarCiudad($nm00020a,$nm00020b)
	{
		return $this->crud->update($nm00020a, $nm00020b);
	}

	/**
	 * Metodo para agregar un nuevo Ciudades
	 * @param entity_nm00020 $nm00020: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarCiudad($nm00020)
	{
		return $this->crud->create($nm00020);
	}

	/**
	 * Metodo para obtener Ciudadess
	 * @param entity_nm00020 $nm00020: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenCiudad($nm00020="",$total=false)
	{
		return $this->crud->read($nm00020,$total);
	}

	/**
	 * Metodo para eliminar Ciudades
	 * 		  entity_nm00020 $nm00020: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaCiudad($nm00020)
	{
		return $this->crud->delete($nm00020);
	}

}