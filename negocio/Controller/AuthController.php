<?php
class AuthController extends Controller_Learnglish {
	public $EXITO_LOGIN = "Login exitoso.";
	public $ERROR_USUARIO_LOGIN = "El usuario no existe.";
	public $ERROR_USUARIO_REGISTRO = "El nombre de usuario ya existe.";
	public $ERROR_CONTRASENIA_LOGIN = "Contraseña Incorrecta.";
	public $ERROR_CLIENTE_NO_VIGENTE = "El cliente al que pertenece no se encuentra vigente.";
	public $ERROR_LIMITE_CLIENTE = "El cliente ha llegado al limite de licencias.";
	public $ERROR_CLIENTE_DESHABILITADO = "El cliente al que pertenece a sido deshabilitado.";
	public $ERROR_CUENTA_DESHABILITADO = "La cuenta a sido deshabilitada.";
	private $perfiles = array (
			"0" => "Administrador",
			"1" => "Infantil",
			"2" => "Juvenil",
			"3" => "Profesor",
			"4" => "Papás" 
	);
	public $aclAllow = array (
			array (
					"class" => "Administrador",
					"actions" => "all" 
			),
			array (
					"class" => "Home",
					"actions" => "contenido" 
			) 
	);
	public function __construct() {
		parent::__construct ();
		// $this->loginIP ();
		// $this->loginURL ();
	}
	
	/**
	 * Metodo que supervisa que el acceso a los elementos de administrador y al contenido sea
	 * de acuerdo a las reglas especificadas
	 *
	 * @param unknown $controller        	
	 * @param unknown $action        	
	 */
	public function proxyAuth($controller, $action) {
		// Habilitamos que el usuario pueda accerder a todo el informacion controller y al index del home
		if (strtolower ( $controller ) == "informacioncontroller" || (strtolower ( $controller ) == "homecontroller" && strtolower ( $action ) == "index")) {
			return;
		}
		// Habilitamos la autenticacion
		if ((strtolower ( $controller ) == "authcontroller" || strtolower ( $controller ) == "ajaxauthcontroller") && strtolower ( $action ) == "login") {
			return;
		}
		
		if (strtolower ( $controller ) == "homecontroller" && (! isset ( $_SESSION ["userLogged"] ))) {
			$this->Redirect ();
		}
		
		if (strtolower ( $controller ) == "admincontroller" && (! isset ( $_SESSION ["userLogged"] ))) {
			$this->Redirect ();
		}
	}
	
	/**
	 * Funcion que se encarga de realizar login a los usuarios que acceden
	 * mediante una IP especifica
	 */
	private function loginIP() {
		if (isset ( $_SESSION ["userLogged"] )) {
			return;
		}
		$nm00017 = new entity_nm00017 ();
		$nm00017->NMF0170003 = $this->getIPLogin ();
		$nm00017->NMF0170011 = 1;
		$ip = (new Ip_Instituciones ())->obtenIpInstituciones ( $nm00017 );
		
		if (! empty ( $ip ) && ! empty ( $nm00017->NMF0170003 )) {
			if (! $this->valida_estado_cliente ( $ip [0] ["NMF0170002"] )) {
				// $this->renderJSON(array("error"=>$this->ERROR_CLIENTE_DESHABILITADO));
				return;
			}
			
			if (! $this->valida_vigencia_cliente ( $ip [0] ["NMF0170002"] )) {
				// $this->renderJSON(array("error"=>$this->ERROR_CLIENTE_NO_VIGENTE));
				return;
			}
			$_SESSION ["userLogged"] = true;
			$_SESSION ["idInstitucion"] = $ip [0] ["NMF0170002"];
			$_SESSION ["tipoSesion"] = 2;
			$this->Redirect ();
		}
	}
	
	/**
	 * Funcion que se encarga de realizar login a los usuarios que acceden
	 * a EcoMundos mediente una pagina web externa
	 */
	private function loginURL() {
		if (isset ( $_SESSION ["userLogged"] )) {
			return;
		}
		
		$url = $this->getURLLogin ();
		if(empty($url)){
			return;
		}
		$lg00027 = new entity_lg00027 ();
		$lg00027->LGF0270020 = "LIKE_" . $url;
		$lg00027->LGF0270012 = 1;
		$url = (new Clientes ())->obtenInstitucion ( $lg00027 );
		if (! empty ( $url )) {
			if (empty ( $url [0] ["LGF0270012"] )) {
				// if (! $this->valida_estado_cliente ( $url [0] ["LGF0270001"] )) {
				// $this->renderJSON(array("error"=>$this->ERROR_CLIENTE_DESHABILITADO));
				return;
			}
			// if (! $this->valida_vigencia_cliente ( $url [0] ["NMF0290002"] )) {
			if (! $this->valida_vigencia_cliente ( $url [0] )) {
				// $this->renderJSON(array("error"=>$this->ERROR_CLIENTE_NO_VIGENTE));
				return;
			}
			$_SESSION ["userLogged"] = true;
			$_SESSION ["idInstitucion"] = $url [0] ["LGF0270001"];
			$_SESSION ["tipoSesion"] = 2;
			$this->Redirect ();
		}
	}
	
	/**
	 *
	 * Función que permite recuperar la IP
	 * de una petición realizada al servidor
	 *
	 * @return string retorna URL Referida, si esta existe
	 */
	private function getIPLogin() {
		$ip = "";
		if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] )) {
			$ip = $_SERVER ['HTTP_CLIENT_IP'];
		} elseif (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
			$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER ['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/**
	 *
	 * Función que permite recuperar la URL
	 * referida de una petición.
	 *
	 * @return string retorna URL Referida, si esta existe
	 */
	private function getURLLogin() {
		// $_SERVER ["HTTP_REFERER"] = "http://www.institucion_ficticia.com";
		$refer = "";
		if (isset ( $_SERVER ["HTTP_REFERER"] )) {
			$refer = $_SERVER ["HTTP_REFERER"];
		}
		if (! empty ( parse_url ( $refer ) && isset ( parse_url ( $refer ) ["host"] ) )) {
			return parse_url ( $refer ) ["host"];
		}
		return null;
	}
	
	/**
	 * Función para mostrar una pantalla de login
	 */
	public function login() {
		if (isset ( $_SESSION ["userLogged"] ) && $_SESSION ["userLogged"]) {
			$this->Redirect ();
		}
		$this->header_custom = "header_index.php";
		
		$this->render ();
	}
	
	/**
	 * Metodo para terminsar sesion del usuario
	 * TODO verificar que funciona
	 */
	public function logout() {
		$data = array(
			'LGF0360001' => $_SESSION['logRegistro'],
			'LGF0360002' => $_SESSION['idUsuario'],
			'LGF0360003' => 1
		);
		$_checkLog = (new LogRegistros())->obtenLogRegistros($data);
		/*echo "<pre>";
		// print_r($_SESSION);
		print_r($_checkLog);
		echo "</pre>";*/
		if (!empty($_checkLog)) {
			$closeLog['LGF0360005'] = date("Y-m-d H:i:s");
			$up = (new LogRegistros())->actualizarLogRegistros((object) $closeLog, (object) array(
				"LGF0360001" => $_SESSION['logRegistro']
			));
		}
		setcookie ( session_name (), '', time () - 3600 ); // Unset the session id
		session_destroy ();
		$this->Redirect ();
	}
	
	/**
	 * Función que permite crear un nuevo cliente vinculado a un cliente
	 */
	public function registro() {
		if (isset ( $_SESSION ["tipoSesion"] ) && $_SESSION ["tipoSesion"] == 2) {
			$this->render ();
		} else {
			$this->Redirect ();
		}
	}
	
	/**
	 * METODOS DE PRUEBAS*
	 */
	public function valida_institucion($id_institucion) {
		var_dump ( $_SESSION );
		$institucion = (new Clientes ())->obtenInstitucion ( ( object ) array (
				"LGF0270001" => $id_institucion 
		) );
		var_dump ( $institucion );
	}
}