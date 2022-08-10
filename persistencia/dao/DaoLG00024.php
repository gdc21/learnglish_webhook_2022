<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00024.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00024 extends UniversalDatabase{
	public function create($lg00024){
		$data = $this->cleanEntity($lg00024);
		return $this->doGeneralInsert('lg00024', $data);
	}

	public function read($lg00024=''){
		if(!empty($lg00024)){
			$lg00024 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00024));
		}

		return $this->doGeneralSelect('lg00024', $lg00024);
	}

	public function update($lg00024a,$lg00024b){
		$data = $this->cleanEntity($lg00024a);
		$condition = $this->cleanEntity($lg00024b);
		return $this->doGeneralUpdate('lg00024',$data,$condition);
	}

	public function delete($lg00024){
		$data = $this->cleanEntity($lg00024);
		return $this->doGeneralDelete('lg00024', $data);
	}

}
