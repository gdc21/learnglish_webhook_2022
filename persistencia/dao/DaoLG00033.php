<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00033.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00033 extends UniversalDatabase{
		public function create($lg00033){
			$data = $this->cleanEntity($lg00033);
			return $this->doGeneralInsert('lg00033', $data);
		}

		public function read($lg00033 = '', $count = false) {
			if (! empty ( $lg00033 )) {
				$lg00033 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00033 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00033', $lg00033 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00033a,$lg00033b){
			$data = $this->cleanEntity($lg00033a);
			$condition = $this->cleanEntity($lg00033b);
			return $this->doGeneralUpdate('lg00033',$data,$condition);
		}

		public function delete($lg00033){
			$data = $this->cleanEntity($lg00033);
			return $this->doGeneralDelete('lg00033', $data);
		}
	}