<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00022.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00022 extends UniversalDatabase{
	public function create($lg00022){
		$data = $this->cleanEntity($lg00022);
		return $this->doGeneralInsert('lg00022', $data);
	}

	public function read($lg00022=''){
		if(!empty($lg00022)){
			$lg00022 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00022));
		}

		return $this->doGeneralSelect('lg00022', $lg00022);
	}

	public function update($lg00022a,$lg00022b){
		$data = $this->cleanEntity($lg00022a);
		$condition = $this->cleanEntity($lg00022b);
		return $this->doGeneralUpdate('lg00022',$data,$condition);
	}

	public function delete($lg00022){
		$data = $this->cleanEntity($lg00022);
		return $this->doGeneralDelete('lg00022', $data);
	}

}
