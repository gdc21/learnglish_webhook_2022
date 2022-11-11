<?php
	require_once __DIR__ .'/../../persistencia/dao/DaoLG00029.php';

	class Grupos {
		private $crud;
		/**
		 * Inicializacion del objeto
		 *
		 */
		public function __construct(){
			$this->crud = new DaoLG00029();
		}

		public function updateGrupo($lg00029a,$lg00029b) {
			return $this->crud->update($lg00029a, $lg00029b);
		}

		public function addGrupo($lg00029) {
			return $this->crud->create($lg00029);
		}

		public function obtenGrupo($lg00029="",$total=false) {
			return $this->crud->read($lg00029,$total);
		}

        public function eliminaGrupo($lg00029)
        {
            return $this->crud->delete($lg00029);
        }
	}