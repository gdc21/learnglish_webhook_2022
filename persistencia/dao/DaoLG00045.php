<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00045.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00045 extends UniversalDatabase{
		public function create($lg00045){
			$data = $this->cleanEntity($lg00045);
			return $this->doGeneralInsert('lg00045', $data);
		}

		public function read($lg00045 = '', $count = false) {
			if (! empty ( $lg00045 )) {
				$lg00045 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00045 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00045', $lg00045 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00045a,$lg00045b){
			$data = $this->cleanEntity($lg00045a);
			$condition = $this->cleanEntity($lg00045b);
			return $this->doGeneralUpdate('lg00045',$data,$condition);
		}

		public function delete($lg00045){
			$data = $this->cleanEntity($lg00045);
			return $this->doGeneralDelete('lg00045', $data);
		}
        
	}