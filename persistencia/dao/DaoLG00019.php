<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00019.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00019 extends UniversalDatabase{
	public function create($lg00019){
		$data = $this->cleanEntity($lg00019);
		return $this->doGeneralInsert('lg00019', $data);
	}

	public function read($lg00019=''){
		if(!empty($lg00019)){
			$lg00019 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00019));
		}

		return $this->doGeneralSelect('lg00019', $lg00019);
	}

	public function update($lg00019a,$lg00019b){
		$data = $this->cleanEntity($lg00019a);
		$condition = $this->cleanEntity($lg00019b);
		return $this->doGeneralUpdate('lg00019',$data,$condition);
	}

	public function delete($lg00019){
		$data = $this->cleanEntity($lg00019);
		return $this->doGeneralDelete('lg00019', $data);
	}

}
