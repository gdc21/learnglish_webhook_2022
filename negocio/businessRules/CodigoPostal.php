<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00018.php';

class CodigoPostal
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00018();
	}

	/**
	 * Metodo para actualizar CodigoPostal
	 * @param entity_nm00018 $nm00018a: informacion a actualizar
	 * 		  entity_nm00018 $nm00018b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarCodigoPostal($nm00018a,$nm00018b)
	{
		return $this->crud->update($nm00018a, $nm00018b);
	}

	/**
	 * Metodo para agregar un nuevo CodigoPostal
	 * @param entity_nm00018 $nm00018: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarCodigoPostal($nm00018)
	{
		return $this->crud->create($nm00018);
	}

	/**
	 * Metodo para obtener CodigoPostals
	 * @param entity_nm00018 $nm00018: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenCodigoPostal($nm00018="",$total=false)
	{
		return $this->crud->read($nm00018,$total);
	}

	/**
	 * Metodo para eliminar CodigoPostal
	 * 		  entity_nm00018 $nm00018: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaCodigoPostal($nm00018)
	{
		return $this->crud->delete($nm00018);
	}

}