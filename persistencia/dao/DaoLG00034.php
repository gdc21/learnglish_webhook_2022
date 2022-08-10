<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00034.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00034 extends UniversalDatabase{
		public function create($lg00034){
			$data = $this->cleanEntity($lg00034);
			return $this->doGeneralInsert('lg00034', $data);
		}

		public function read($lg00034 = '', $count = false) {
			if (! empty ( $lg00034 )) {
				$lg00034 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00034 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00034', $lg00034 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00034a,$lg00034b){
			$data = $this->cleanEntity($lg00034a);
			$condition = $this->cleanEntity($lg00034b);
			return $this->doGeneralUpdate('lg00034',$data,$condition);
		}

		public function delete($lg00034){
			$data = $this->cleanEntity($lg00034);
			return $this->doGeneralDelete('lg00034', $data);
		}
	}