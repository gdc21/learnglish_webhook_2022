<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00038.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00038 extends UniversalDatabase{
		public function create($lg00038){
			$data = $this->cleanEntity($lg00038);
			return $this->doGeneralInsert('lg00038', $data);
		}

		public function read($lg00038 = '', $count = false) {
			if (! empty ( $lg00038 )) {
				$lg00038 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00038 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00038', $lg00038 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00038a,$lg00038b){
			$data = $this->cleanEntity($lg00038a);
			$condition = $this->cleanEntity($lg00038b);
			return $this->doGeneralUpdate('lg00038',$data,$condition);
		}

		public function delete($lg00038){
			$data = $this->cleanEntity($lg00038);
			return $this->doGeneralDelete('lg00038', $data);
		}
        
	}