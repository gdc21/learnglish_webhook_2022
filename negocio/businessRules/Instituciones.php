<?php 
	require_once __DIR__ . '/../../persistencia/dao/DaoLG00027.php';
	class Instituciones {
		private $crud;

		public function __construct() {
			$this->crud = new DaoLG00027();
		}

		/**
		 * Metodo para registrar instituciones
		 */
		public function agregarInstitucion($lg00027) {
			// print_r($lg00027);
			return $this->crud->create($lg00027);
		}

		/**
		 * Metodo para eliminar una institucion
		 * Unicamente cambia el valor de la columna a 0
		 */

		public function actualizarInstitucion($lg00027, $id) {
			return $this->crud->update($lg00027, $id);
		}

		public function validarUsuario($lg00027) {
			$active = ( object ) [
				"LGF0270024" => $lg00027->LGF0270024,
				"LGF0270025" => $lg00027->LGF0270025 
			];

			if ($this->crud->read ( $active )) {
				if ($res = $this->crud->read ( $lg00027 )) {
					return $res;
				} else {
					return 1;
				}
			} else {
				return 2;
			}
		}

		public function obtenInstitucion($lg00027="",$total=false) {
			return $this->crud->read($lg00027,$total);
		}
	}