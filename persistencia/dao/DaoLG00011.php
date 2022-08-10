<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00011.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00011 extends UniversalDatabase{
	public function create($lg00011){
		$data = $this->cleanEntity($lg00011);
		return $this->doGeneralInsert('lg00011', $data);
	}

	public function read($lg00011=''){
		if(!empty($lg00011)){
			$lg00011 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00011));
		}

		return $this->doGeneralSelect('lg00011', $lg00011);
	}

	public function update($lg00011a,$lg00011b){
		$data = $this->cleanEntity($lg00011a);
		$condition = $this->cleanEntity($lg00011b);
		return $this->doGeneralUpdate('lg00011',$data,$condition);
	}

	public function delete($lg00011){
		$data = $this->cleanEntity($lg00011);
		return $this->doGeneralDelete('lg00011', $data);
	}

}
