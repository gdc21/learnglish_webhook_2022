<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00043.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00043 extends UniversalDatabase{
		public function create($lg00043){
			$data = $this->cleanEntity($lg00043);
			return $this->doGeneralInsert('lg00043', $data);
		}

		public function read($lg00043 = '', $count = false) {
			if (! empty ( $lg00043 )) {
				$lg00043 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00043 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00043', $lg00043 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00043a,$lg00043b){
			$data = $this->cleanEntity($lg00043a);
			$condition = $this->cleanEntity($lg00043b);
			return $this->doGeneralUpdate('lg00043',$data,$condition);
		}

		public function delete($lg00043){
			$data = $this->cleanEntity($lg00043);
			return $this->doGeneralDelete('lg00043', $data);
		}
        
	}