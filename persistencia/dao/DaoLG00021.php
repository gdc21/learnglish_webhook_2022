<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00021.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00021 extends UniversalDatabase{
	public function create($lg00021){
		$data = $this->cleanEntity($lg00021);
		return $this->doGeneralInsert('lg00021', $data);
	}

	public function read($lg00021=''){
		if(!empty($lg00021)){
			$lg00021 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00021));
		}

		return $this->doGeneralSelect('lg00021', $lg00021);
	}

	public function update($lg00021a,$lg00021b){
		$data = $this->cleanEntity($lg00021a);
		$condition = $this->cleanEntity($lg00021b);
		return $this->doGeneralUpdate('lg00021',$data,$condition);
	}

	public function delete($lg00021){
		$data = $this->cleanEntity($lg00021);
		return $this->doGeneralDelete('lg00021', $data);
	}

}
