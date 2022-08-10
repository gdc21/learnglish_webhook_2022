<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00010.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00010 extends UniversalDatabase{
	public function create($lg00010){
		$data = $this->cleanEntity($lg00010);
		return $this->doGeneralInsert('lg00010', $data);
	}

	public function read($lg00010=''){
		if(!empty($lg00010)){
			$lg00010 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00010));
		}

		return $this->doGeneralSelect('lg00010', $lg00010);
	}

	public function update($lg00010a,$lg00010b){
		$data = $this->cleanEntity($lg00010a);
		$condition = $this->cleanEntity($lg00010b);
		return $this->doGeneralUpdate('lg00010',$data,$condition);
	}

	public function delete($lg00010){
		$data = $this->cleanEntity($lg00010);
		return $this->doGeneralDelete('lg00010', $data);
	}

}
