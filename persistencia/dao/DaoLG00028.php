<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00028.php';
/**
*
* GENERADO AUTOMATICAMENTE
* FECHA: 10/01/2017
*/

class DaoLG00028 extends UniversalDatabase{
	public function create($lg00028){
		$data = $this->cleanEntity($lg00028);
		return $this->doGeneralInsert('lg00028', $data);
	}

	/*public function read($lg00028=''){
		if(!empty($lg00028)){
			$lg00028 = 'WHERE '.$this->getStringConditions($this->cleanEntity($lg00028));
		}

		return $this->doGeneralSelect('lg00028', $lg00028);
	}*/
	public function read($lg00028 = '', $count = false) {
		if (! empty ( $lg00028 )) {
			$lg00028 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00028 ) );
		}
		$res = $this->doGeneralSelect ( 'lg00028', $lg00028 );
		if ($count) {
			return $this->numRows;
		}
		return $res;
	}

	public function update($lg00028a,$lg00028b){
		$data = $this->cleanEntity($lg00028a);
		$condition = $this->cleanEntity($lg00028b);
		return $this->doGeneralUpdate('lg00028',$data,$condition);
	}

	public function delete($lg00028){
		$data = $this->cleanEntity($lg00028);
		return $this->doGeneralDelete('lg00028', $data);
	}

}
