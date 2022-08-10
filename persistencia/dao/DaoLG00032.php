<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00032.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class DaoLG00032 extends UniversalDatabase{
		public function create($lg00032){
			$data = $this->cleanEntity($lg00032);
			return $this->doGeneralInsert('lg00032', $data);
		}

		public function read($lg00032 = '', $count = false) {
			if (! empty ( $lg00032 )) {
				$lg00032 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00032 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00032', $lg00032 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00032a,$lg00032b){
			$data = $this->cleanEntity($lg00032a);
			$condition = $this->cleanEntity($lg00032b);
			return $this->doGeneralUpdate('lg00032',$data,$condition);
		}

		public function delete($lg00032){
			$data = $this->cleanEntity($lg00032);
			return $this->doGeneralDelete('lg00032', $data);
		}
	}