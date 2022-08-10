<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00014.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00014 extends UniversalDatabase{
	public function create($lg00014){
		$data = $this->cleanEntity($lg00014);
		return $this->doGeneralInsert('lg00014', $data);
	}

	public function read($lg00014=''){
		if(!empty($lg00014)){
			$lg00014 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00014));
		}

		return $this->doGeneralSelect('lg00014', $lg00014);
	}

	public function update($lg00014a,$lg00014b){
		$data = $this->cleanEntity($lg00014a);
		$condition = $this->cleanEntity($lg00014b);
		return $this->doGeneralUpdate('lg00014',$data,$condition);
	}

	public function delete($lg00014){
		$data = $this->cleanEntity($lg00014);
		return $this->doGeneralDelete('lg00014', $data);
	}

}
