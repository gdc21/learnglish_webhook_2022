<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00044.php';
class EvaluacionDocumentos {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00044();
	}


    public function verificarDocumentosYspeakCargado($lg00044 = "", $total = false){
        return $this->crud->read ( $lg00044, $total );
    }

	public function actualizarDocumentosYspeakCargado($lg00044a, $lg00044b) {
		return $this->crud->update ( $lg00044a, $lg00044b );
	}

	public function agregarDocumentosYspeakCargado($lg00044) {
		return $this->crud->create ( $lg00044 );
	}

	public function eliminaDocumentosYspeakCargado($lg00044) {
		return $this->crud->delete ( $lg00044 );
	}
}
?>