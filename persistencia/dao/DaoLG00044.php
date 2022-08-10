<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00044.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00044 extends UniversalDatabase{
		public function create($lg00044){
			$data = $this->cleanEntity($lg00044);
			return $this->doGeneralInsert('lg00044', $data);
		}

		public function read($lg00044 = '', $count = false) {
			if (! empty ( $lg00044 )) {
				$lg00044 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00044 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00044', $lg00044 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00044a,$lg00044b){
			$data = $this->cleanEntity($lg00044a);
			$condition = $this->cleanEntity($lg00044b);
			return $this->doGeneralUpdate('lg00044',$data,$condition);
		}

		public function delete($lg00044){
			$data = $this->cleanEntity($lg00044);
			return $this->doGeneralDelete('lg00044', $data);
		}
        
	}