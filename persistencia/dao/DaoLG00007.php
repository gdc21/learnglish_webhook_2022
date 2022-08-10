<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00007.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00007 extends UniversalDatabase{
	public function create($lg00007){
		$data = $this->cleanEntity($lg00007);
		return $this->doGeneralInsert('lg00007', $data);
	}

	public function read($lg00007=''){
		if(!empty($lg00007)){
			$lg00007 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00007));
		}

		return $this->doGeneralSelect('lg00007', $lg00007);
	}

	public function update($lg00007a,$lg00007b){
		$data = $this->cleanEntity($lg00007a);
		$condition = $this->cleanEntity($lg00007b);
		return $this->doGeneralUpdate('lg00007',$data,$condition);
	}

	public function delete($lg00007){
		$data = $this->cleanEntity($lg00007);
		return $this->doGeneralDelete('lg00007', $data);
	}

}
