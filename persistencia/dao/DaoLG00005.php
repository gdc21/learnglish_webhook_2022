<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00005.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00005 extends UniversalDatabase{
	public function create($lg00005){
		$data = $this->cleanEntity($lg00005);
		return $this->doGeneralInsert('lg00005', $data);
	}

	public function read($lg00005=''){
		if(!empty($lg00005)){
			$lg00005 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00005));
		}

		return $this->doGeneralSelect('lg00005', $lg00005);
	}

	public function update($lg00005a,$lg00005b){
		$data = $this->cleanEntity($lg00005a);
		$condition = $this->cleanEntity($lg00005b);
		return $this->doGeneralUpdate('lg00005',$data,$condition);
	}

	public function delete($lg00005){
		$data = $this->cleanEntity($lg00005);
		return $this->doGeneralDelete('lg00005', $data);
	}

}
