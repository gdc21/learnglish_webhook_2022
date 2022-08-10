<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00016.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00016 extends UniversalDatabase{
	public function create($lg00016){
		$data = $this->cleanEntity($lg00016);
		return $this->doGeneralInsert('lg00016', $data);
	}

	public function read($lg00016=''){
		if(!empty($lg00016)){
			$lg00016 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00016));
		}

		return $this->doGeneralSelect('lg00016', $lg00016);
	}

	public function update($lg00016a,$lg00016b){
		$data = $this->cleanEntity($lg00016a);
		$condition = $this->cleanEntity($lg00016b);
		return $this->doGeneralUpdate('lg00016',$data,$condition);
	}

	public function delete($lg00016){
		$data = $this->cleanEntity($lg00016);
		return $this->doGeneralDelete('lg00016', $data);
	}

}
