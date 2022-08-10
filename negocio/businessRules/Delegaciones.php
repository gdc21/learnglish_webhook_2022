<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00022.php';

class Delegaciones
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00022();
	}

	/**
	 * Metodo para actualizar Delegacion
	 * @param entity_nm00022 $nm00022a: informacion a actualizar
	 * 		  entity_nm00022 $nm00022b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarDelegacion($nm00022a,$nm00022b)
	{
		return $this->crud->update($nm00022a, $nm00022b);
	}

	/**
	 * Metodo para agregar un nuevo Delegacion
	 * @param entity_nm00022 $nm00022: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarDelegacion($nm00022)
	{
		return $this->crud->create($nm00022);
	}

	/**
	 * Metodo para obtener Delegacions
	 * @param entity_nm00022 $nm00022: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenDelegacion($nm00022="",$total=false)
	{
		return $this->crud->read($nm00022,$total);
	}

	/**
	 * Metodo para eliminar Delegacion
	 * 		  entity_nm00022 $nm00022: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaDelegacion($nm00022)
	{
		return $this->crud->delete($nm00022);
	}

}