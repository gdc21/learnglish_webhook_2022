<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00009.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00009 extends UniversalDatabase{
	public function create($lg00009){
		$data = $this->cleanEntity($lg00009);
		return $this->doGeneralInsert('lg00009', $data);
	}

	public function read($lg00009=''){
		if(!empty($lg00009)){
			$lg00009 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00009));
		}

		return $this->doGeneralSelect('lg00009', $lg00009);
	}

	public function update($lg00009a,$lg00009b){
		$data = $this->cleanEntity($lg00009a);
		$condition = $this->cleanEntity($lg00009b);
		return $this->doGeneralUpdate('lg00009',$data,$condition);
	}

	public function delete($lg00009){
		$data = $this->cleanEntity($lg00009);
		return $this->doGeneralDelete('lg00009', $data);
	}

}
