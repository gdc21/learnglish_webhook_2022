<?php
require_once __DIR__ .'/../../persistencia/dao/DaoLG00043.php';

class Accesomodulos
{
	private $crud;
	/**
	 * Inicializacion del objeto
	 *
	 */
	public function __construct(){
		$this->crud = new DaoLG00043();
	}

	public function actualizarAccesomodulos($nm00043a,$nm00043b)
	{
		return $this->crud->update($nm00043a, $nm00043b);
	}

	public function agregarAccesomodulos($nm00043)
	{
		return $this->crud->create($nm00043);
	}

	public function obtenAccesomodulos($nm00043="",$total=false)
	{
		return $this->crud->read($nm00043,$total);
	}

	public function eliminaAccesomodulos($nm00043)
	{
		return $this->crud->delete($nm00043);
	}

}