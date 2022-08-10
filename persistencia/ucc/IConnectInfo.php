<?php
//Filename: IConnectInfo.php
//Substitute your connect info
interface IConnectInfo
{
	
	// MYSQL
	//Modificación temporal	
	const HOST =SERV_SQL;
	const UNAME =USER_SQL;
	const PW =PDW_SQL;
	const DBNAME = BD_SQL;
	
// 	const HOST ="10.10.10.53";
// 	const UNAME =USER_SQL;
// 	const PW = "GDC2878*";
// 	const DBNAME = BD_SQL;
	
	// TCP over SSH
	const REMOTEHOST = SERV_SQL;
	const UNAMERHOST = SERV_USER_SQL;
	const PWRHOST = SERV_PDW_SQL;
	const PORTRHOST = "22";
	const PORTRTHOST = PORT_SQL;
	
	// MYSQL over TUNNEL SSH2
	const REMOTEHOSTM = "127.0.0.1";
	const UNAMERHOSTM = USER_SQL;
	const PWRHOSTM = PDW_SQL;
	//const PWRHOSTM = "root";
	const DBNAMERM = BD_SQL;
	
	public static function doConnect();
	public function doConnectRem();
	public function closeConnectRem();
}

?>