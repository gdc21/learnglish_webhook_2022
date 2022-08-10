<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00018.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00018 extends UniversalDatabase{
	public function create($lg00018){
		$data = $this->cleanEntity($lg00018);
		return $this->doGeneralInsert('lg00018', $data);
	}

	public function read($lg00018=''){
		if(!empty($lg00018)){
			$lg00018 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00018));
		}

		return $this->doGeneralSelect('lg00018', $lg00018);
	}

	public function update($lg00018a,$lg00018b){
		$data = $this->cleanEntity($lg00018a);
		$condition = $this->cleanEntity($lg00018b);
		return $this->doGeneralUpdate('lg00018',$data,$condition);
	}

	public function delete($lg00018){
		$data = $this->cleanEntity($lg00018);
		return $this->doGeneralDelete('lg00018', $data);
	}

}
