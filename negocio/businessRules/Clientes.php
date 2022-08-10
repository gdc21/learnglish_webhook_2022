<?php
	require_once __DIR__ .'/../../persistencia/dao/DaoLG00028.php';

	class Clientes {
		private $crud;
		/**
		 * Inicializacion del objeto
		 *
		 */
		public function __construct(){
			$this->crud = new DaoLG00028();
		}

		public function actualizar($lg00028a,$lg00028b) {
			return $this->crud->update($lg00028a, $lg00028b);
		}

		public function addCliente($lg00028) {
			return $this->crud->create($lg00028);
		}

		public function obtenClientes($lg00028="",$total=false) {
			return $this->crud->read($lg00028,$total);
		}

		public function validarUsuario($lg00028) {
			$active = ( object ) [
				"LGF0280019" => $lg00028->LGF0280019,
				"LGF0280020" => $lg00028->LGF0280020 
			];

			if ($this->crud->read ( $active )) {
				if ($res = $this->crud->read ( $lg00028 )) {
					return $res;
				} else {
					return 1;
				}
			} else {
				return 2;
			}
		}

		/*public function obtenContenidoPaginacion($lg00028="",$limit) {
			return $this->crud->getToPagination($lg00028,$limit);
		}*/

		/*public function eliminaInstitucion($lg00028) {
			return $this->crud->delete($lg00028);
		}*/
	}