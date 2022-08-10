<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00012.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00012 extends UniversalDatabase{
	public function create($lg00012){
		$data = $this->cleanEntity($lg00012);
		return $this->doGeneralInsert('lg00012', $data);
	}

	public function read($lg00012=''){
		if(!empty($lg00012)){
			$lg00012 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00012));
		}

		return $this->doGeneralSelect('lg00012', $lg00012);
	}

	public function update($lg00012a,$lg00012b){
		$data = $this->cleanEntity($lg00012a);
		$condition = $this->cleanEntity($lg00012b);
		return $this->doGeneralUpdate('lg00012',$data,$condition);
	}

	public function delete($lg00012){
		$data = $this->cleanEntity($lg00012);
		return $this->doGeneralDelete('lg00012', $data);
	}

}
