<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00046.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00046 extends UniversalDatabase{
		public function create($lg00046){
			$data = $this->cleanEntity($lg00046);
			return $this->doGeneralInsert('lg00046', $data);
		}

		public function read($lg00046 = '', $count = false) {
			if (! empty ( $lg00046 )) {
				$lg00046 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00046 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00046', $lg00046 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00046a,$lg00046b){
			$data = $this->cleanEntity($lg00046a);
			$condition = $this->cleanEntity($lg00046b);
			return $this->doGeneralUpdate('lg00046',$data,$condition);
		}

		public function delete($lg00046){
			$data = $this->cleanEntity($lg00046);
			return $this->doGeneralDelete('lg00046', $data);
		}
        
	}