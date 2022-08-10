<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00015.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00015 extends UniversalDatabase{
	public function create($lg00015){
		$data = $this->cleanEntity($lg00015);
		return $this->doGeneralInsert('lg00015', $data);
	}

	public function read($lg00015=''){
		if(!empty($lg00015)){
			$lg00015 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00015));
		}

		return $this->doGeneralSelect('lg00015', $lg00015);
	}

	public function update($lg00015a,$lg00015b){
		$data = $this->cleanEntity($lg00015a);
		$condition = $this->cleanEntity($lg00015b);
		return $this->doGeneralUpdate('lg00015',$data,$condition);
	}

	public function delete($lg00015){
		$data = $this->cleanEntity($lg00015);
		return $this->doGeneralDelete('lg00015', $data);
	}

}
