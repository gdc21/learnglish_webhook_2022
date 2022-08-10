<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00026.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00026 extends UniversalDatabase{
	public function create($lg00026){
		$data = $this->cleanEntity($lg00026);
		return $this->doGeneralInsert('lg00026', $data);
	}

	public function read($lg00026=''){
		if(!empty($lg00026)){
			$lg00026 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00026));
		}

		return $this->doGeneralSelect('lg00026', $lg00026);
	}

	public function update($lg00026a,$lg00026b){
		$data = $this->cleanEntity($lg00026a);
		$condition = $this->cleanEntity($lg00026b);
		return $this->doGeneralUpdate('lg00026',$data,$condition);
	}

	public function delete($lg00026){
		$data = $this->cleanEntity($lg00026);
		return $this->doGeneralDelete('lg00026', $data);
	}

}
