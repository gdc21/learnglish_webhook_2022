<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00036.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00036 extends UniversalDatabase{
		public function create($lg00036){
			$data = $this->cleanEntity($lg00036);
			return $this->doGeneralInsert('lg00036', $data);
		}

		public function read($lg00036 = '', $count = false) {
			if (! empty ( $lg00036 )) {
				$lg00036 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00036 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00036', $lg00036 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00036a,$lg00036b){
			$data = $this->cleanEntity($lg00036a);
			$condition = $this->cleanEntity($lg00036b);
			return $this->doGeneralUpdate('lg00036',$data,$condition);
		}

		public function delete($lg00036){
			$data = $this->cleanEntity($lg00036);
			return $this->doGeneralDelete('lg00036', $data);
		}
	}