<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00003.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00003 extends UniversalDatabase{
	public function create($lg00003){
		$data = $this->cleanEntity($lg00003);
		return $this->doGeneralInsert('lg00003', $data);
	}

	public function read($lg00003=''){
		if(!empty($lg00003)){
			$lg00003 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00003));
		}

		return $this->doGeneralSelect('lg00003', $lg00003);
	}

	public function update($lg00003a,$lg00003b){
		$data = $this->cleanEntity($lg00003a);
		$condition = $this->cleanEntity($lg00003b);
		return $this->doGeneralUpdate('lg00003',$data,$condition);
	}

	public function delete($lg00003){
		$data = $this->cleanEntity($lg00003);
		return $this->doGeneralDelete('lg00003', $data);
	}

}
