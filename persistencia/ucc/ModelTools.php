<?php
class ModelTools
{
	/**
	 * Funcion para limpiar un objeto Entity
	 * @param Entity $entity
	 * @return Array $entity
	 */
	public function cleanEntity($entity){
		//Eliminamos los atributos vacios
		$entity = (object) array_filter((array) $entity, function ($val) {
			return !is_null($val);
		});
	
        //Regresamos la estructura del Entity en forma de array
        return get_object_vars($entity);
	}
	
	/**
	 * Funcion para limpiar un objeto Entity
	 * @param Entity $entity
	 * @return Array $entity
	 */
	public function cleanWhereConditional($condition){
		if(strstr($condition, "WHERE ORDER"))
			return str_replace("WHERE ORDER","ORDER",$condition);
		
		return strcmp($condition, "WHERE ") === 0 ? "" : $condition;
	}
	
	public function getStringConditions($condition){
		//Limpiamos los parametros que usaremos de filtro
		$cond = '';
		$order = '';
		
		foreach($condition as $key => $val){
			if(strpos($val,"NOT_(") !== false){
				$cond .= "$key NOT IN (".str_replace("NOT_(","",$val).") AND ";
			}elseif(strpos($val,"IN_(") !== false){
				$cond .= "$key IN (".str_replace("IN_(","",$val).") AND ";
			}elseif(strpos($val,"LIKE_OR_") !== false){
				$cond .= "$key LIKE ('%".str_replace("LIKE_OR_","",$val)."%') COLLATE utf8_general_ci OR  ";
			}elseif(strpos($val,"LIKE_") !== false){
				$cond .= "$key LIKE ('%".str_replace("LIKE_","",$val)."%') AND ";
			}elseif(strpos($val,"NOT_NULL_") !== false){
				$cond .= "$key IS NOT NULL AND ";
			}elseif(strpos($val,"NULL_") !== false){
				$cond .= "$key IS NULL AND ";
			}elseif(strpos($val,"ODESC") !== false){
				$order .= empty($order) ? $key.' DESC' : ','.$key.' DESC';
			}elseif(strpos($val,"OASC") !== false){
				$order .= empty($order) ? $key.' ASC' : ','.$key.' ASC';
			}else{
				$cond .= "$key = '$val' AND ";
			}
		}
		if(empty($order))
			return substr($cond, 0, -4);
		
		return substr($cond, 0, -4) . 'ORDER BY '. $order;
	}
	
	public function getStringFechas($campo,$fecha){
		$stringFechas = "";
		if(array_key_exists('start', $fecha)){
			if(array_key_exists('finish', $fecha)){
				$stringFechas = " convert($campo,date) BETWEEN convert('".$fecha['start']."',date) AND convert('".$fecha['finish']."',date)";
			}else{
				$stringFechas = " convert($campo,date)=convert('".$fecha['start']."',date)";
			}
		}
		return $stringFechas;
	}
	
	public function getStringKeyValue($data){
		//Filtramos los campos a ser actualizados
		$values = '';
		foreach($data as $key => $val){
			if($val === 'curdate'){
				$values .= $key .'= NOW(),';
			}else{
				$values .= "$key = '$val',";
			}
		}
		return substr($values, 0, -1);
	}
	
	public function getStringLimits($limit){
		$stringLimits = "";
		if(array_key_exists('start', $limit) && array_key_exists('finish', $limit)){
			$stringLimits = ' LIMIT '.$limit['start'].','.$limit['finish'];
		}
		return $stringLimits;
	}
	
	public function getStringValue($data){
		$values = '';
		foreach($data as $key => $val){
			if($val === 'curdate'){
				$values .= 'NOW(),';
			}else{
				$values .= "'$val',";
			}
		}
		return substr($values, 0, -1);
	}
	
	public function getStringPDOSignParameter($data){
		//Obtenemos la referencia para el PDO: "?,?,?"
		return substr( str_repeat("?,", count($data)), 0, -1);
	}
}