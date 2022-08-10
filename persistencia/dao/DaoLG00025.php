<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00025.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00025 extends UniversalDatabase{
	public function create($lg00025){
		$data = $this->cleanEntity($lg00025);
		return $this->doGeneralInsert('lg00025', $data);
	}

	public function read($lg00025=''){
		if(!empty($lg00025)){
			$lg00025 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00025));
		}

		return $this->doGeneralSelect('lg00025', $lg00025);
	}

	public function update($lg00025a,$lg00025b){
		$data = $this->cleanEntity($lg00025a);
		$condition = $this->cleanEntity($lg00025b);
		return $this->doGeneralUpdate('lg00025',$data,$condition);
	}

	public function delete($lg00025){
		$data = $this->cleanEntity($lg00025);
		return $this->doGeneralDelete('lg00025', $data);
	}

}
