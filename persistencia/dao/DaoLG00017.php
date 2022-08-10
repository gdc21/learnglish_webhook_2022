<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00017.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00017 extends UniversalDatabase{
	public function create($lg00017){
		$data = $this->cleanEntity($lg00017);
		return $this->doGeneralInsert('lg00017', $data);
	}

	public function read($lg00017=''){
		if(!empty($lg00017)){
			$lg00017 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00017));
		}

		return $this->doGeneralSelect('lg00017', $lg00017);
	}

	public function update($lg00017a,$lg00017b){
		$data = $this->cleanEntity($lg00017a);
		$condition = $this->cleanEntity($lg00017b);
		return $this->doGeneralUpdate('lg00017',$data,$condition);
	}

	public function delete($lg00017){
		$data = $this->cleanEntity($lg00017);
		return $this->doGeneralDelete('lg00017', $data);
	}

}
