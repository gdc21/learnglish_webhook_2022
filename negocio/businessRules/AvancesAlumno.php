<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00041.php';
class AvancesAlumno {
	private $crud;

	public function __construct() {
		$this->crud = new DaoLG00041 ();
	}

	/*public function actualizarAccesoLeccion($lg00001a, $lg00001b) {
		return $this->crud->update ( $lg00001a, $lg00001b );
	}*/

	public function agregarAvance($lg00041) {
		return $this->crud->create ( $lg00041 );
	}

	public function obtenerAvancesAlumno($lg00041 = "", $total = false) {
		return $this->crud->read ( $lg00041, $total );
	}

    /*public function eliminaAccesoLeccion($lg00041) {
        return $this->crud->delete ( $lg00041 );
    }*/

}