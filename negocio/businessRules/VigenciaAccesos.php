<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00030.php';

class VigenciaAccesos
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00030();
	}

	/**
	 * Metodo para actualizar VigenciaAccesos
	 * @param entity_em00030 $em00030a: informacion a actualizar
	 * 		  entity_em00030 $em00030b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarVigenciaAccesos($em00030a,$em00030b)
	{
		return $this->crud->update($em00030a, $em00030b);
	}

	/**
	 * Metodo para agregar un nuevo VigenciaAccesos
	 * @param entity_em00030 $em00030: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarVigenciaAccesos($em00030)
	{
		return $this->crud->create($em00030);
	}

	/**
	 * Metodo para obtener VigenciaAccesoss
	 * @param entity_em00030 $em00030: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenVigenciaAccesos($em00030="",$total=false)
	{
		return $this->crud->read($em00030,$total);
	}

	/**
	 * Metodo para eliminar VigenciaAccesos
	 * 		  entity_em00030 $em00030: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaVigenciaAccesos($em00030)
	{
		return $this->crud->delete($em00030);
	}

}