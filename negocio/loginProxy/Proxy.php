<?php
include_once("ISubject.php");
include_once __DIR__ . '/../../persistencia/ucc/UniversalConnect.php';
include_once __DIR__ . '/../../negocio/businessRules/SignUsuario.php';
class Proxy implements ISubject
{
	private $tableMaster;
	private $hookup;
	private $logGood;
	private $realSubject;
	
	public function login($uNow,$pNow)
	{
		if(empty($uNow) && empty($pNow)){
			//echo "elements empty";
			return 0;
		}elseif($uNow===NULL || $pNow===NULL){
			//echo "elements empty";
			return 0;
		}
		$uname=$uNow;
		//$pw=sha1($pNow);
		$pw=$pNow;
		$conexion=new SignUsuario();
		return $conexion->loginUser($uname,$pw);
	}
}
?>