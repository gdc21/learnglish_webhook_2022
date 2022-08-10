<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00040.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00040 extends UniversalDatabase{
		public function create($lg00040){
			$data = $this->cleanEntity($lg00040);
			return $this->doGeneralInsert('lg00040', $data);
		}

		public function read($lg00040 = '', $count = false) {
			if (! empty ( $lg00040 )) {
				$lg00040 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00040 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00040', $lg00040 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00040a,$lg00040b){
			$data = $this->cleanEntity($lg00040a);
			$condition = $this->cleanEntity($lg00040b);
			return $this->doGeneralUpdate('lg00040',$data,$condition);
		}

		public function delete($lg00040){
			$data = $this->cleanEntity($lg00040);
			return $this->doGeneralDelete('lg00040', $data);
		}

	}