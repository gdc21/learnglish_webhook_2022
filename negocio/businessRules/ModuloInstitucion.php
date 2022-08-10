<?php
	require_once __DIR__ .'/../../persistencia/dao/DaoLG00030.php';

	class ModuloInstitucion {
		private $crud;
		/**
		 * Inicializacion del objeto
		 *
		 */
		public function __construct(){
			$this->crud = new DaoLG00030();
		}

		public function updateModuloInst($lg00030a,$lg00030b) {
			return $this->crud->update($lg00030a, $lg00030b);
		}

		public function addModuloInst($lg00030) {
			return $this->crud->create($lg00030);
		}

		public function obtenModuloInst($lg00030="",$total=false) {
			return $this->crud->read($lg00030,$total);
		}

		/**
		 * Elimna la relacion de un modulo con la institucion
		 */
		public function eliminaModulo($lg00030) {
			return $this->crud->delete($lg00030);
		}
	}