<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00042.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00042 extends UniversalDatabase{
		public function create($lg00042){
			$data = $this->cleanEntity($lg00042);
			return $this->doGeneralInsert('lg00042', $data);
		}

		public function read($lg00042 = '', $count = false) {
			if (! empty ( $lg00042 )) {
				$lg00042 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00042 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00042', $lg00042 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00042a,$lg00042b){
			$data = $this->cleanEntity($lg00042a);
			$condition = $this->cleanEntity($lg00042b);
			return $this->doGeneralUpdate('lg00042',$data,$condition);
		}

		public function delete($lg00042){
			$data = $this->cleanEntity($lg00042);
			return $this->doGeneralDelete('lg00042', $data);
		}
        
	}