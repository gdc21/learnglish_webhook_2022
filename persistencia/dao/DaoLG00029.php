<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00029.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class DaoLG00029 extends UniversalDatabase{
		public function create($lg00029){
			$data = $this->cleanEntity($lg00029);
			return $this->doGeneralInsert('lg00029', $data);
		}

		public function read($lg00029 = '', $count = false) {
			if (! empty ( $lg00029 )) {
				$lg00029 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00029 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00029', $lg00029 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00029a,$lg00029b){
			$data = $this->cleanEntity($lg00029a);
			$condition = $this->cleanEntity($lg00029b);
			return $this->doGeneralUpdate('lg00029',$data,$condition);
		}

		public function delete($lg00029){
			$data = $this->cleanEntity($lg00029);
			return $this->doGeneralDelete('lg00029', $data);
		}
	}