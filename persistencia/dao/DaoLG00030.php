<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00030.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class DaoLG00030 extends UniversalDatabase{
		public function create($lg00030){
			$data = $this->cleanEntity($lg00030);
			return $this->doGeneralInsert('lg00030', $data);
		}

		public function read($lg00030 = '', $count = false) {
			if (! empty ( $lg00030 )) {
				$lg00030 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00030 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00030', $lg00030 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00030a,$lg00030b){
			$data = $this->cleanEntity($lg00030a);
			$condition = $this->cleanEntity($lg00030b);
			return $this->doGeneralUpdate('lg00030',$data,$condition);
		}

		public function delete($lg00030){
			$data = $this->cleanEntity($lg00030);
			return $this->doGeneralDelete('lg00030', $data);
		}
	}