<?php
	include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
	include_once __DIR__ . '/../../persistencia/entity/entity_lg00041.php';
	/**
	*
	* GENERADO AUTOMATICAMENTE
	* FECHA: 10/01/2017
	*/

	class Daolg00041 extends UniversalDatabase{
		public function create($lg00041){
            $yaHaSidoCreado = $this->read((object) array(
                "LGF0410002" => $lg00041->LGF0410002,
                "LGF0410003" => $lg00041->LGF0410003,
                "LGF0410004" => $lg00041->LGF0410004,
                "LGF0410005" => $lg00041->LGF0410005,
                "LGF0410006" => $lg00041->LGF0410006,
            ), $count = true);

            if($yaHaSidoCreado){
                return true;
            }

			$data = $this->cleanEntity($lg00041);
			return $this->doGeneralInsert('lg00041', $data);
		}

		public function read($lg00041 = '', $count = false) {
			if (! empty ( $lg00041 )) {
				$lg00041 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00041 ) );
			}
			$res = $this->doGeneralSelect ( 'lg00041', $lg00041 );
			if ($count) {
				return $this->numRows;
			}
			return $res;
		}

		public function update($lg00041a,$lg00041b){
			$data = $this->cleanEntity($lg00041a);
			$condition = $this->cleanEntity($lg00041b);
			return $this->doGeneralUpdate('lg00041',$data,$condition);
		}

		public function delete($lg00041){
			$data = $this->cleanEntity($lg00041);
			return $this->doGeneralDelete('lg00041', $data);
		}
	}