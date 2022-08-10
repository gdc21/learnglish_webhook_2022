<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00006.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00006 extends UniversalDatabase{
	public function create($lg00006){
		$data = $this->cleanEntity($lg00006);
		return $this->doGeneralInsert('lg00006', $data);
	}

	public function read($lg00006=''){
		if(!empty($lg00006)){
			$lg00006 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00006));
		}

		return $this->doGeneralSelect('lg00006', $lg00006);
	}

	public function update($lg00006a,$lg00006b){
		$data = $this->cleanEntity($lg00006a);
		$condition = $this->cleanEntity($lg00006b);
		return $this->doGeneralUpdate('lg00006',$data,$condition);
	}

	public function delete($lg00006){
		$data = $this->cleanEntity($lg00006);
		return $this->doGeneralDelete('lg00006', $data);
	}

}
