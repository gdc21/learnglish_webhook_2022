<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00008.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00008 extends UniversalDatabase{
	public function create($lg00008){
		$data = $this->cleanEntity($lg00008);
		return $this->doGeneralInsert('lg00008', $data);
	}

	public function read($lg00008=''){
		if(!empty($lg00008)){
			$lg00008 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00008));
		}

		return $this->doGeneralSelect('lg00008', $lg00008);
	}

	public function update($lg00008a,$lg00008b){
		$data = $this->cleanEntity($lg00008a);
		$condition = $this->cleanEntity($lg00008b);
		return $this->doGeneralUpdate('lg00008',$data,$condition);
	}

	public function delete($lg00008){
		$data = $this->cleanEntity($lg00008);
		return $this->doGeneralDelete('lg00008', $data);
	}

}
