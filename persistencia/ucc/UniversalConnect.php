<?php
include_once('IConnectInfo.php');

class UniversalConnect implements IConnectInfo
{
	private static $server=IConnectInfo::HOST;
	private static $currentDB= IConnectInfo::DBNAME;
	private static $user= IConnectInfo::UNAME;
	private static $pass= IConnectInfo::PW;
	private static $hookup;
	
	private static $serverRemote=IConnectInfo::REMOTEHOST;
	private static $userRemote=IConnectInfo::UNAMERHOST;
	private static $passRemote=IConnectInfo::PWRHOST;
	private static $portHRemote=IConnectInfo::PORTRHOST;
	private static $portRemote=IConnectInfo::PORTRTHOST;
		
	
	private static $serverRemoteDB=IConnectInfo::REMOTEHOSTM;
	private static $currentRemoteDB= IConnectInfo::DBNAMERM;
	private static $userRemoteM= IConnectInfo::UNAMERHOSTM;
	private static $passRemoteM= IConnectInfo::PWRHOSTM;
	
	
	private static $ssh_conn;
	private static $ssh_auth;
	private static $ssh_tunnel;
	private static $hookupRemote;
	private static $socket;
	
	private static $closeConnectRem;
	
	
	
	
	public function doConnectRem()
	{
		self::$hookup=mysqli_connect(self::$server, self::$user, self::$pass, self::$currentDB);
		if(self::$hookup)
		{
			//echo "Successful connection to MySQL Local <br />";
		}
		elseif (mysqli_connect_error(self::$hookup)) 
		{
    		//echo('Here is why it failed: '  . mysqli_connect_error());
		}
		return self::$hookup;
	}
	
	public static function doConnect(){
				if( ENV == "PROD"){
					//shell_exec("ssh -f -L 3307:".self::$serverRemoteDB.":3306 ".self::$userRemote."@".self::$serverRemote." sleep 120 >> logfile");
					self::$hookupRemote=mysqli_connect(self::$serverRemoteDB, self::$userRemoteM, self::$passRemoteM, self::$currentRemoteDB, self::$portRemote);
					
					if(self::$hookupRemote)
					{
						//echo "Conexion a MySQL Remoto satisfactoria <br />";
					}
					elseif (mysqli_connect_error(self::$hookupRemote))
					{
						echo('Here is why it failed: '  . mysqli_connect_error());
					}
					return self::$hookupRemote;
				}else{
					self::$hookup=mysqli_connect(self::$server, self::$user, self::$pass, self::$currentDB);
					if(self::$hookup)
					{
						//echo "Successful connection to MySQL Local <br />";
					}
					elseif (mysqli_connect_error(self::$hookup))
					{
						echo('Here is why it failed: '  . mysqli_connect_error());
					}
					return self::$hookup;
				}
			
	}
	public function closeConnectRem(){
		ini_set('display_errors', '1');
		
		try {
		
		self::$closeConnectRem = ssh2_exec(self::$ssh_conn, 'exit');		
		self::$ssh_conn = NULL;
		
		}catch (Exception $e){
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}				
		
		if(self::$ssh_conn){
			echo "Conexion SSH satisfactoria  <br />";
		}else{
			echo "Termina conexion.";
		}
				
		
		
	}
}
?>