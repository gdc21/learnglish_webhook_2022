<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00037.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00037 extends UniversalDatabase{
		public function create($lg00037){
			$data = $this->cleanEntity($lg00037);
			return $this->doGeneralInsert('lg00037', $data);
		}

		public function read($lg00037 = '', $count = false) {
			if (! empty ( $lg00037 )) {
				$lg00037 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00037 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00037', $lg00037 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00037a,$lg00037b){
			$data = $this->cleanEntity($lg00037a);
			$condition = $this->cleanEntity($lg00037b);
			return $this->doGeneralUpdate('lg00037',$data,$condition);
		}

		public function delete($lg00037){
			$data = $this->cleanEntity($lg00037);
			return $this->doGeneralDelete('lg00037', $data);
		}

		public function checkTeacher( $group ) {
			$this->query = "SELECT count(*) AS num FROM lg00037 t1 INNER JOIN lg00001 t2 
			ON t2.LGF0010039 = t1.LGF0370003 AND t2.LGF0010007 = 6 AND t2.LGF0010039 = '".$group."';";
			return $this->doSelect ();
		}
	}