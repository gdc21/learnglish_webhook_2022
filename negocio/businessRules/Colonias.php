<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00023.php';

class Colonias
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00023();
	}

	/**
	 * Metodo para actualizar Colonia
	 * @param entity_nm00023 $nm00023a: informacion a actualizar
	 * 		  entity_nm00023 $nm00023b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarColonia($nm00023a,$nm00023b)
	{
		return $this->crud->update($nm00023a, $nm00023b);
	}

	/**
	 * Metodo para agregar un nuevo Colonia
	 * @param entity_nm00023 $nm00023: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarColonia($nm00023)
	{
		return $this->crud->create($nm00023);
	}

	/**
	 * Metodo para obtener Colonias
	 * @param entity_nm00023 $nm00023: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenColonia($nm00023="",$total=false)
	{
		return $this->crud->read($nm00023,$total);
	}

	/**
	 * Metodo para eliminar Colonia
	 * 		  entity_nm00023 $nm00023: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaColonia($nm00023)
	{
		return $this->crud->delete($nm00023);
	}

}