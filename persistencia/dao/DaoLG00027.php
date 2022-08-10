<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00027.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00027 extends UniversalDatabase{
	public function create($lg00027){
		$data = $this->cleanEntity($lg00027);
		return $this->doGeneralInsert('lg00027', $data);
	}

	public function read($lg00027=''){
		if(!empty($lg00027)){
			$lg00027 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00027));
		}

		return $this->doGeneralSelect('lg00027', $lg00027);
	}

	public function update($lg00027a,$lg00027b){
		$data = $this->cleanEntity($lg00027a);
		$condition = $this->cleanEntity($lg00027b);
		return $this->doGeneralUpdate('lg00027',$data,$condition);
	}

	public function delete($lg00027){
		$data = $this->cleanEntity($lg00027);
		return $this->doGeneralDelete('lg00027', $data);
	}

}
