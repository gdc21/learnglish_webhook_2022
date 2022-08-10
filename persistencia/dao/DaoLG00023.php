<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00023.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00023 extends UniversalDatabase{
	public function create($lg00023){
		$data = $this->cleanEntity($lg00023);
		return $this->doGeneralInsert('lg00023', $data);
	}

	public function read($lg00023=''){
		if(!empty($lg00023)){
			$lg00023 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00023));
		}

		return $this->doGeneralSelect('lg00023', $lg00023);
	}

	public function update($lg00023a,$lg00023b){
		$data = $this->cleanEntity($lg00023a);
		$condition = $this->cleanEntity($lg00023b);
		return $this->doGeneralUpdate('lg00023',$data,$condition);
	}

	public function delete($lg00023){
		$data = $this->cleanEntity($lg00023);
		return $this->doGeneralDelete('lg00023', $data);
	}

}
