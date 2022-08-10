<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00002.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00002 extends UniversalDatabase{
	public function create($lg00002){
		$data = $this->cleanEntity($lg00002);
		return $this->doGeneralInsert('lg00002', $data);
	}

	public function read($lg00002=''){
		if(!empty($lg00002)){
			$lg00002 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00002));
		}

		return $this->doGeneralSelect('lg00002', $lg00002);
	}

	public function update($lg00002a,$lg00002b){
		$data = $this->cleanEntity($lg00002a);
		$condition = $this->cleanEntity($lg00002b);
		return $this->doGeneralUpdate('lg00002',$data,$condition);
	}

	public function delete($lg00002){
		$data = $this->cleanEntity($lg00002);
		return $this->doGeneralDelete('lg00002', $data);
	}

}
