<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00035.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00035 extends UniversalDatabase{
		public function create($lg00035){
			$data = $this->cleanEntity($lg00035);
			return $this->doGeneralInsert('lg00035', $data);
		}

		public function read($lg00035 = '', $count = false) {
			if (! empty ( $lg00035 )) {
				$lg00035 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00035 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00035', $lg00035 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00035a,$lg00035b){
			$data = $this->cleanEntity($lg00035a);
			$condition = $this->cleanEntity($lg00035b);
			return $this->doGeneralUpdate('lg00035',$data,$condition);
		}

		public function delete($lg00035){
			$data = $this->cleanEntity($lg00035);
			return $this->doGeneralDelete('lg00035', $data);
		}
	}