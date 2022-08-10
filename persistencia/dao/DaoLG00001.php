<?php
include_once __DIR__ . '/../../persistencia/ucc/UniversalDatabase.php';
include_once __DIR__ . '/../../persistencia/entity/entity_lg00001.php';
/**
 * GENERADO AUTOMATICAMENTE
 * FECHA: 10/01/2017
 */
class DaoLG00001 extends UniversalDatabase {
	public function create($lg00001) {
		$data = $this->cleanEntity ( $lg00001 );
		return $this->doGeneralInsert ( 'lg00001', $data );
	}
	public function read($lg00001 = '', $count = false) {
		if (! empty ( $lg00001 )) {
			$lg00001 = 'WHERE ' . $this->getStringConditions ( $this->cleanEntity ( $lg00001 ) );
		}
		$res = $this->doGeneralSelect ( 'lg00001', $lg00001 );
		if ($count) {
			return $this->numRows;
		}
		return $res;
	}
	public function update($lg00001a, $lg00001b) {
		$data = $this->cleanEntity ( $lg00001a );
		$condition = $this->cleanEntity ( $lg00001b );
		return $this->doGeneralUpdate ( 'lg00001', $data, $condition );
	}
	public function delete($lg00001) {
		$data = $this->cleanEntity ( $lg00001 );
		return $this->doGeneralDelete ( 'lg00001', $data );
	}
}
