<?php
require_once __DIR__ .'/../../persistencia/dao/DaoNM00016.php';

class LogRechazosBusqueda
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoNM00016();
	}

	/**
	 * Metodo para actualizar LogRechazosBusqueda
	 * @param entity_nm00016 $nm00016a: informacion a actualizar
	 * 		  entity_nm00016 $nm00016b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *
	 */
	public function actualizarLogRechazosBusqueda($nm00016a,$nm00016b)
	{
		return $this->crud->update($nm00016a, $nm00016b);
	}

	/**
	 * Metodo para agregar un nuevo LogRechazosBusqueda
	 * @param entity_nm00016 $nm00016: informacion a almacenar
	 * @return true: agregado|false: error
	 *
	 */
	public function agregarLogRechazosBusqueda($nm00016)
	{
		return $this->crud->create($nm00016);
	}

	/**
	 * Metodo para obtener LogRechazosBusquedas
	 * @param entity_nm00016 $nm00016: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function obtenLogRechazosBusqueda($nm00016="",$total=false)
	{
		return $this->crud->read($nm00016,$total);
	}

	/**
	 * Metodo para eliminar LogRechazosBusqueda
	 * 		  entity_nm00016 $nm00016: condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *
	 */
	public function eliminaLogRechazosBusqueda($nm00016)
	{
		return $this->crud->delete($nm00016);
	}

}