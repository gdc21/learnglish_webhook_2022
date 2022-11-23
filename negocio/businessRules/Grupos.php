<?php
	require_once __DIR__ .'/../../persistencia/dao/DaoLG00029.php';

	class Grupos extends UniversalDatabase {
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

        public function cuentaAlumnosGrupo($id_grupo){
            $this->query = "select count(LGF0010001) as total_alumnos from lg00001 
                            where LGF0010039 = ".$id_grupo;

            return $this->doSelect();
        }

        public function elimina_alumno_grupo($id_grupo, $id_alumno){
            $this->query = "UPDATE lg00001 set LGF0010039 = null
                            WHERE LGF0010039 = ".$id_grupo." and LGF0010001 = ".$id_alumno;

            return $this->doSingleQuery();
        }
	}