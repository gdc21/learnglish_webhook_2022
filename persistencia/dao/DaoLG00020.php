<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00020.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00020 extends UniversalDatabase{
	public function create($lg00020){
		$data = $this->cleanEntity($lg00020);
		return $this->doGeneralInsert('lg00020', $data);
	}

	public function read($lg00020=''){
		if(!empty($lg00020)){
			$lg00020 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00020));
		}

		return $this->doGeneralSelect('lg00020', $lg00020);
	}

	public function update($lg00020a,$lg00020b){
		$data = $this->cleanEntity($lg00020a);
		$condition = $this->cleanEntity($lg00020b);
		return $this->doGeneralUpdate('lg00020',$data,$condition);
	}

	public function delete($lg00020){
		$data = $this->cleanEntity($lg00020);
		return $this->doGeneralDelete('lg00020', $data);
	}

}
