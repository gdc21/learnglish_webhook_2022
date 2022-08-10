<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00013.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00013 extends UniversalDatabase{
	public function create($lg00013){
		$data = $this->cleanEntity($lg00013);
		return $this->doGeneralInsert('lg00013', $data);
	}

	public function read($lg00013=''){
		if(!empty($lg00013)){
			$lg00013 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00013));
		}

		return $this->doGeneralSelect('lg00013', $lg00013);
	}

	public function update($lg00013a,$lg00013b){
		$data = $this->cleanEntity($lg00013a);
		$condition = $this->cleanEntity($lg00013b);
		return $this->doGeneralUpdate('lg00013',$data,$condition);
	}

	public function delete($lg00013){
		$data = $this->cleanEntity($lg00013);
		return $this->doGeneralDelete('lg00013', $data);
	}

}
