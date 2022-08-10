<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00019.php';

class Paises
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00019();
	}

	/**
	 * Metodo para actualizar Paises
	 * @param entity_nm00019 $nm00019a: informacion a actualizar
	 * 		  entity_nm00019 $nm00019b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarPais($nm00019a,$nm00019b)
	{
		return $this->crud->update($nm00019a, $nm00019b);
	}

	/**
	 * Metodo para agregar un nuevo Paises
	 * @param entity_nm00019 $nm00019: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarPais($nm00019)
	{
		return $this->crud->create($nm00019);
	}

	/**
	 * Metodo para obtener Paisess
	 * @param entity_nm00019 $nm00019: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenPais($nm00019="",$total=false)
	{
		return $this->crud->read($nm00019,$total);
	}

	/**
	 * Metodo para eliminar Paises
	 * 		  entity_nm00019 $nm00019: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaPais($nm00019)
	{
		return $this->crud->delete($nm00019);
	}

}