<?php
class LogController{
	
	public function logAccesoUser($login=true){
		$res =$this->getInformation();
		$lg00026=new entity_lg00026();
		$lg00026->LGF0260002 = isset($_SESSION["idUsuario"])?intval($_SESSION["idUsuario"]):" ";
		$lg00026->LGF0260003 =$res["date"];
		$lg00026->LGF0260004 = $res["session_id"];
		$lg00026->LGF0260005 = $res["ip"];
		$lg00026->LGF0260006 = $res["name"]."-".$res["version"] ;
		$lg00026->LGF0260007 = $res['platform'];
		if($login){
			$lg00026->LGF0260008 = 1;
		}else{
			$lg00026->LGF0260008 = 0;
		}
		// (new LogUsoUsuarios())->agregarLogUsoUsuarios($lg00026);
	}
	
	
	private function logAccesos($idInstitucion,$nombreScritp,$nombreAccion){
		$infoServer = array();
		$infoServer["HTTP_USER_AGENT"]=(isset($_SERVER["HTTP_USER_AGENT"])?$_SERVER["HTTP_USER_AGENT"]:"");
		$infoServer["SERVER_NAME"]=(isset($_SERVER["SERVER_NAME"])?$_SERVER["SERVER_NAME"]:"");
		$infoServer["SERVER_ADDR"]=(isset($_SERVER["SERVER_ADDR"])?$_SERVER["SERVER_ADDR"]:"");
		$infoServer["REMOTE_HOST"]=(isset($_SERVER["REMOTE_HOST"])?$_SERVER["REMOTE_HOST"]:"");
		$infoServer["REMOTE_ADDR"]=(isset($_SERVER["REMOTE_ADDR"])?$_SERVER["REMOTE_ADDR"]:"");
		$infoServer["REDIRECT_URL"]=(isset($_SERVER["REDIRECT_URL"])?$_SERVER["REDIRECT_URL"]:"");
		$infoServer["QUERY_STRING"]=(isset($_SERVER["QUERY_STRING"])?$_SERVER["QUERY_STRING"]:"");
		$infoServer["REQUEST_URI"]=(isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:"");
		if(isset($_POST)){
			$infoServer["POST_VALUES"]=(isset($_POST)?$_POST:"");
		}
		$res =$this->getInformation();
		$entity=new entity_lg00009();
		$entity->LGF0090002 = $res["date"];
		$entity->LGF0090003 = $res["ip"];
		$entity->LGF0090004 = $res["name"]."-".$res["version"] ;
		$entity->LGF0090005 = $res['platform'];
		$entity->LGF0090006 = $res["device"];
		$entity->LGF0090007 = $res["session_id"];
		$entity->LGF0090008 = isset($_SESSION["idUsuario"])?intval($_SESSION["idUsuario"]):" ";
		$entity->LGF0090009 = empty($idInstitucion)?" ":$idInstitucion;
		$entity->LGF0090010 = $nombreScritp;
		$entity->LGF0090011 = $nombreAccion;
// 		$entity->NMF0120013 = print_r($infoServer,true);
		return $entity;
	}
	public function registraAcceso($idInstitucion,$nombreScritp,$nombreAccion){
		/*$entity = $this->logAccesos($idInstitucion, $nombreScritp, $nombreAccion);
		(new LogAccesos())->agregarLogAccesos($entity);*/
	}
	
	//http://php.net/manual/en/function.get-browser.php#101125
	//Se agrego la deteccion de dispositivos, IP, SESSION ID
	private function getInformation()
	{
		if(isset($_SERVER['HTTP_USER_AGENT'])){
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "Unknown";
		$ub = "Unknown";
		
		if (preg_match('/rim|bb/i', $u_agent)) {
			$platform = 'BlackBerry';
		}else
		if (preg_match('/Windows phone/i', $u_agent)) {
			$platform = 'Windows Phone';
		}else
		if (preg_match('/silk/i', $u_agent)) {
			$platform = 'Amazon Kindle';
		}else
		if (preg_match('/ipad/i', $u_agent)) {
			$platform = 'ipad';
		}else
		if (preg_match('/iphone/i', $u_agent)) {
			$platform = 'iphone';
		}else
		if (preg_match('/Android|android/i', $u_agent)) {
			$platform = 'android';
		}else
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
	
		// Next get the name of the useragent yes seperately and for good reason
		/*if((preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) || preg_match('/Windows/i',$u_agent) )
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		else*/
		
		preg_match('/MSIE (.*?);/', $u_agent, $matches);
		if(count($matches)<2){
			preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
		}
		
			
		if(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
	
		if(count($matches)>1){
			$pattern = "";
			$version = $matches[1];
			$bname = 'Internet Explorer';
			$ub = "MSIE";
			switch(true){
				case ($version<=8):
					$version = "IE 8";
					//IE 8 or under!
					break;
			
				case ($version==9 ):
					$version = "IE 9";
				break;
				case( $version==10):
					$version = "IE 10";
					break;
			
				case ($version==11):
					$version = "IE 11";
					break;
			
				default:
					//You get the idea
			}
	}else{
		// finally get the correct version number
		$known = array('Version', $ub, 'other','rv');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
	
		// see how many we have
		if(!empty($matches['version'])){
			$i = count($matches['browser']);
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}
		}else{
			$version == null;
		}
		
	
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		
	}
	}
		
		$ip="Unknown";
// 		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
// 			$ip = $_SERVER['HTTP_CLIENT_IP'];
// 		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
// 			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
// 		} else {
// 			$ip = $_SERVER['REMOTE_ADDR'];
// 		}
		$ip = $this->get_ip_address();
		
		$deviceList = array(
				'mobile'	 => array('iphone', 'android', 'blackberry'),
				//'tablet' => array('ipad', 'trident', 'kindle_fire', 'silk', 'opera')
				'tablet' => array('ipad', 'kindle_fire', 'silk', 'opera')
		);
		$device = "DESCONOCIDO";
		foreach ( $deviceList as $groupDevice => $value ) {
			foreach ($deviceList[ $groupDevice ] as $key => $type) {
				if( stripos($u_agent, $type) ){
					$device = $groupDevice;
					break;
				}
			}
			if($device != '') 
				break;
		}
		switch ($device) {
			case 'mobile':
				$device="phone";
				break;
			case 'tablet':
				$device="tablet";
				break;
			default:
				$device="desktop";
				break;
		}
		
	
		
		
		return array(
				'ip'=>$ip,
				'date'=>date("Y-m-d H:i:s"),
				'session_id'=>session_id(),
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern,
				'device' 	=> $device
		);
	}
	
	
		
		private function get_ip_address() {
			$ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
			foreach ($ip_keys as $key) {
				if (array_key_exists($key, $_SERVER) === true) {
					foreach (explode(',', $_SERVER[$key]) as $ip) {
						// trim for safety measures
						$ip = trim($ip);
						// attempt to validate IP
						if ($this->validate_ip($ip)) {
							return $ip;
						}
					}
				}
			}
		
			return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
		}
		
		
		/**
		 * Ensures an ip address is both a valid IP and does not fall within
		 * a private network range.
		 */
		private function validate_ip($ip)
		{
			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
				return false;
			}
			return true;
		}
	
// 		public function logUsuarioActivo($idInstitucion){
// 			include_once MODEL."UsuarioActivo.php";
// 			include_once ENTITY."entity_bt00059.php";
// 			$info =$this->getInformation();
// 			$model = new UsuarioActivo();
// 			error_reporting(0);
// 			$res = $model->getUsuarioActivo(isset($_SESSION["userid"])?intval($_SESSION["userid"]):" ");
// 			error_reporting(-1);
// 			$entity = new entity_bt00059;
// 			if($res == 0){
// 				$entity->BTF0590001=" ";
// 				$entity->BTF0590002 = isset($_SESSION["userid"])?intval($_SESSION["userid"]):" ";
// 				$entity->BTF0590003 = $idInstitucion;
// 				$entity->BTF0590004=session_id();
// 				error_reporting(0);
// 				$model->agregarActivos($entity);
// 				error_reporting(-1);
// 			}else{
// 				$entity->BTF0590001=$res[0][0];
// 				$entity->BTF0590002 = $res[0][1];
// 				$entity->BTF0590003 = $res[0][2];
// 				$entity->BTF0590004=$res[0][3];
// 				$entity->BTF0590005=date("Y-m-d H:i:s");
// 				$entity->BTF0590006=$res[0][5];
// 				error_reporting(0);
// 				$model->modificarActivos($entity);
// 				error_reporting(-1);
// 			}
// 		}

}
?>