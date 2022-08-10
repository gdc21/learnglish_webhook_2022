<?php
include_once('UniversalConnect.php');

class ConnectClient
{
	private $hookup;
	public function __construct()
		{
			//One line for entire connection operation
			$this->hookup=UniversalConnect::doConnect();
		}
}
$worker=new ConnectClient();

class ConnectClientSSH
{
	private $hookupRemote;	
	public function __construct()
	{
		//One line for entire connection operation
		
		$this->hookupRemote=UniversalConnect::doConnectRem();
	}
}

class CloseClientSSH{
	
	private $closeCR;
	public function  __construct()
	{
		$this->closeCR=UniversalConnect::closeConnectRem();
	}
}


$workerRemote = new ConnectClientSSH();

#$closeWR = new CloseClientSSH();

?>