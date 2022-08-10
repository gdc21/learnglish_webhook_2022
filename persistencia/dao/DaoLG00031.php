<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00031.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class DaoLG00031 extends UniversalDatabase{
		public function create($lg00031){
			$data = $this->cleanEntity($lg00031);
			return $this->doGeneralInsert('lg00031', $data);
		}

		public function read($lg00031 = '', $count = false) {
			if (! empty ( $lg00031 )) {
				$lg00031 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00031 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00031', $lg00031 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00031a,$lg00031b){
			$data = $this->cleanEntity($lg00031a);
			$condition = $this->cleanEntity($lg00031b);
			return $this->doGeneralUpdate('lg00031',$data,$condition);
		}

		public function delete($lg00031){
			$data = $this->cleanEntity($lg00031);
			return $this->doGeneralDelete('lg00031', $data);
		}
	}