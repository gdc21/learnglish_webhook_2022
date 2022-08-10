<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00004.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00004 extends UniversalDatabase{
	public function create($lg00004){
		$data = $this->cleanEntity($lg00004);
		return $this->doGeneralInsert('lg00004', $data);
	}

	public function read($lg00004=''){
		if(!empty($lg00004)){
			$lg00004 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00004));
		}

		return $this->doGeneralSelect('lg00004', $lg00004);
	}

	public function update($lg00004a,$lg00004b){
		$data = $this->cleanEntity($lg00004a);
		$condition = $this->cleanEntity($lg00004b);
		return $this->doGeneralUpdate('lg00004',$data,$condition);
	}

	public function delete($lg00004){
		$data = $this->cleanEntity($lg00004);
		return $this->doGeneralDelete('lg00004', $data);
	}

}
