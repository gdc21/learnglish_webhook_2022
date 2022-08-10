<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00039.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00039 extends UniversalDatabase{
		public function create($lg00039){
			$data = $this->cleanEntity($lg00039);
			return $this->doGeneralInsert('lg00039', $data);
		}

		public function read($lg00039 = '', $count = false) {
			if (! empty ( $lg00039 )) {
				$lg00039 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00039 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00039', $lg00039 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00039a,$lg00039b){
			$data = $this->cleanEntity($lg00039a);
			$condition = $this->cleanEntity($lg00039b);
			return $this->doGeneralUpdate('lg00039',$data,$condition);
		}

		public function delete($lg00039){
			$data = $this->cleanEntity($lg00039);
			return $this->doGeneralDelete('lg00039', $data);
		}

	}