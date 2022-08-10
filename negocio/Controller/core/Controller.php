<?php
/**
 * 
 * Clase padre para todos los controladores
 * 
 * @author dfelipe
 *
 */
class Controller {
	
	/**
	 * se almacena el id del usuario para no hacer uso de la $_SESSION cada vez
	 *
	 * @var int
	 */
	protected $userid = 0;
	
	/**
	 * Variable, que permite compartir la informacion con la vista mediante un array()
	 *
	 * @var unknown
	 */
	protected $temp = array ();
	protected $header_custom = "";
	protected $template_custom = "";
	protected $body_custom = "";
	/**
	 * FALSE si no es metodo es un request por GET, TRUE si es por POST
	 *
	 * @var unknown
	 */
	public $isPOST = FALSE;
	protected $oda = false;
	
	/**
	 * Constructor padre.
	 * Todas las clases que hereden de esta clase deberan llamar el constructor padre.
	 *
	 * public function __construct(){
	 * parent::__construct();
	 * }
	 */
	public function __construct() {
		$this->isPOST = $_SERVER ['REQUEST_METHOD'] === "POST";
		if (isset ( $_SESSION ["idUsuario"] )) {
			$this->userid = $_SESSION ["idUsuario"];
		} else {
			$this->userid = 0;
		}
	}
	protected function setCustomBody($path) {
		$this->body_custom = $path;
	}
	
	/**
	 * Funcion que se encarga de Renderizar,
	 * Carga toda la informacion de los archivos.
	 *
	 * Realiza la impresion
	 */
	protected function render($status = 200) {
		$template = new Class_Template ( $this );
		$this->buildHeader ();
		if (! isset ( $this->temp ["seccion"] )) {
			$this->temp ["seccion"] = strtolower ( substr ( get_class ( $this ), 0, strrpos ( get_class ( $this ), "Controller", 0 ) ) );
		}
		if (! isset ( $this->temp ["accion"] )) {
			$debug = debug_backtrace ();
			$this->temp ["accion"] = strtolower ( next ( $debug ) ['function'] );
		}
		if ($this->oda) {
			$template->load_oda ( $this->oda );
		}
		if (! empty ( $this->header_custom )) {
			$template->custom_header = $this->header_custom;
		}
		if (! empty ( $this->template_custom )) {
			$template->custom_template = $this->template_custom;
		}
		if (! empty ( $this->body_custom )) {
			$template->body = $this->body_custom;
		}
		$template->render ( $this->temp, $status );
	}
	
	/**
	 * Funcion para regresar informacion en formato JSON (en construccion)
	 * Si hay un error dentro la codificacion del array a codificar a JSON,
	 * se envia el error de la siguiente manera: {"error":"mensaje"}
	 *
	 * @param array $object
	 *        	Array a convertir en JSON
	 */
	protected function renderJSON($object) {
		$object = (new utf8 ())->utf8_encode_all ( $object );
		$error = array ();
		switch (json_last_error ()) {
			case JSON_ERROR_NONE :
				break;
			case JSON_ERROR_DEPTH :
				$error = array (
						"error" => "Excedido tamaño máximo de la pila" 
				);
				break;
			case JSON_ERROR_STATE_MISMATCH :
				$error = array (
						"error" => "Desbordamiento de buffer o los modos no coinciden" 
				);
				break;
			case JSON_ERROR_CTRL_CHAR :
				$error = array (
						"error" => "Encontrado carácter de control no esperado" 
				);
				break;
			case JSON_ERROR_SYNTAX :
				$error = array (
						"error" => "Error de sintaxis, JSON mal formado" 
				);
				break;
			case JSON_ERROR_UTF8 :
				$error = array (
						"error" => "Caracteres UTF-8 malformados, posiblemente están mal codificados" 
				);
				break;
			default :
				$error = array (
						"error" => "Error desconocido" 
				);
				break;
		}
		if (empty ( $error )) {
			(new Response ())->sendResponse ( 200, json_encode ( $object ), 'application/json' );
		} else {
			(new Response ())->sendResponse ( 500, json_encode ( $error ), 'application/json' );
		}
	}
	
	/**
	 * Funcion para regresa informacion en texto plano
	 *
	 * @param string $object
	 *        	Texto plano
	 */
	protected function renderText($object) {
		(new Response ())->sendResponse ( 200, $object, ' text/plain' );
	}
	
	/**
	 * Renderiza cualquier contenido que se le pase al parametro $object como HTML
	 *
	 * @param string $object
	 *        	HTML texto
	 * @param string $status
	 *        	200
	 */
	protected function renderHTML($object, $status = "200") {
		(new Response ())->sendResponse ( $status, $object );
	}
	
	/**
	 *
	 * @param unknown $object
	 *        	Contenido del archivo
	 * @param string $name
	 *        	Nombre del archivo
	 * @param string $type
	 *        	MimeType
	 * @param string $status
	 *        	200
	 */
	protected function renderFile($object, $name = "", $type = "text/xml", $status = "200") {
		(new Response ())->sendResponse ( $status, $object, $type, $name );
	}
	
	/**
	 * Construye el menu que se encuentra el header.
	 * Esto lo realiza tomando el menu que se encuentra desde la base de datos.
	 *
	 * Si es una peticion POST, la cabecera no es construida
	 */
	protected function buildHeader() {
		// if (! $this->isAjax()) {
		// }
	}
	
	/**
	 * Permite Redireccionar a una clase y funcion especifica, los parametros que no se envian se toman como
	 * default
	 *
	 * @param string $clase        	
	 * @param string $accion        	
	 * @param array $params        	
	 */
	protected function Redirect($clase = DEFAULT_CLASS, $accion = DEFAULT_ACTION, $params = array()) {
		$url = CONTEXT . $clase . "/" . $accion;
		if (! empty ( $params )) {
			foreach ( $params as $p ) {
				$url .= "/" . $p;
			}
		}
		$permanent = false;
		if (! headers_sent ( $filename, $linenum )) {
		} else {
			echo "Headers already sent in $filename on line $linenum\n";
			exit ();
		}
		if (headers_sent () === false) {
			header ( 'Location: ' . $url, true, 301 );
		}
		exit ();
	}
	
	/**
	 * Metodo para redirigir al usuario a una URL
	 *
	 * @param string $url        	
	 */
	protected function RedirectURL($url) {
		$parsed = parse_url ( $url );
		if (empty ( $parsed ['scheme'] )) {
			$url = '//' . ltrim ( $url, '/' );
		}
		$permanent = false;
		if (! headers_sent ( $filename, $linenum )) {
		} else {
			echo "Headers already sent in $filename on line $linenum\n";
			exit ();
		}
		if (headers_sent () === false) {
			header ( 'Location: ' . $url, true, 301 );
		}
		exit ();
	}
	
	/**
	 * Funcion para ordenar un array
	 *
	 * @param
	 *        	clave para el cual se debe ordenar el array $clave
	 * @param bool $des
	 *        	Default, descendiente, false ascendiente
	 * @return number
	 */
	protected function build_sorter($clave, $des = true) {
		return function ($a, $b) use ($clave, $des) {
			if ($des)
				return strnatcmp ( $b [$clave], $a [$clave] );
			else
				return strnatcmp ( $a [$clave], $b [$clave] );
		};
	}
	
	/**
	 * Encrypt Function - Rijndael 256-bit
	 *
	 * @param string $encrypt
	 *        	Cadena a encriptar
	 * @param string $key
	 *        	Llave para encriptar
	 * @return string Cadena encriptada
	 */
	protected function mc_encrypt($encrypt, $key) {
		$encrypt = serialize ( $encrypt );
		$iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC ), MCRYPT_DEV_URANDOM );
		$key = pack ( 'H*', $key );
		$mac = hash_hmac ( 'sha256', $encrypt, substr ( bin2hex ( $key ), - 32 ) );
		$passcrypt = mcrypt_encrypt ( MCRYPT_RIJNDAEL_256, $key, $encrypt . $mac, MCRYPT_MODE_CBC, $iv );
		$encoded = base64_encode ( $passcrypt ) . '|' . base64_encode ( $iv );
		return $encoded;
	}
	
	/**
	 * Decrypt Function - Rijndael 256-bit
	 *
	 * @param string $decrypt
	 *        	Cadena encriptada
	 * @param string $key
	 *        	Llave para desencriptar
	 * @return boolean|mixed Cadena desencriptada o un false si no se concreto la funcionalidad
	 */
	protected function mc_decrypt($decrypt, $key) {
		$decrypt = explode ( '|', $decrypt . '|' );
		$decoded = base64_decode ( $decrypt [0] );
		$iv = base64_decode ( $decrypt [1] );
		if (strlen ( $iv ) !== mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC )) {
			return false;
		}
		$key = pack ( 'H*', $key );
		$decrypted = trim ( mcrypt_decrypt ( MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv ) );
		$mac = substr ( $decrypted, - 64 );
		$decrypted = substr ( $decrypted, 0, - 64 );
		$calcmac = hash_hmac ( 'sha256', $decrypted, substr ( bin2hex ( $key ), - 32 ) );
		if ($calcmac !== $mac) {
			return false;
		}
		$decrypted = unserialize ( $decrypted );
		return $decrypted;
	}
	protected function archivoAlt($campo, $nombre, $allowedExts = array(), $path = RESOURCE_APP, $limitSize = 1073741824, $allowedType = array()) {
		if (! isset ( $_FILES [$campo] )) {
			return array (
					"error" => "No existe archivo para procesar." 
			);
		}
		$temp = explode ( ".", $_FILES [$campo] ["name"] );
		$extension = strtolower ( end ( $temp ) );
		
		if (in_array ( $_FILES [$campo] ["type"], $allowedType ) || empty ( $allowedType )) {
			if ($_FILES [$campo] ["size"] < $limitSize) {
				if (in_array ( $extension, $allowedExts ) || empty ( $allowedExts )) {
					if ($_FILES [$campo] ["error"] > 0) {
						return array (
								"error" => "Error: " . $_FILES [$campo] ["error"] 
						);
					} else {
						if (file_exists ( $path . $_FILES [$campo] ["name"] )) {
							return array (
									"error" => "Ya existe un archivo con ese nombre." 
							);
						} else {
							move_uploaded_file ( $_FILES [$campo] ["tmp_name"], $path . $nombre . "." . $extension );
							return array (
									"mensaje" => "Archivo correctamente procesado.",
									"nombre" => $nombre . "." . $extension,
									"nombreOriginal" => $_FILES [$campo] ["name"],
									"tamanio" => $_FILES [$campo] ["size"] 
							);
						}
					}
				} else {
					return array (
							"error" => "El archivo tiene un extensión incorrecta." 
					);
				}
			} else {
				return array (
						"error" => "El archivo sobrepasa el limite de tamaño." 
				);
			}
		} else {
			return array (
					"error" => "El tipo del archivo es invalido." 
			);
		}
	}
	
	/**
	 * Metodo para convertir una imagen base 64 directo desde la carpeta temporal
	 *
	 * @param unknown $campo        	
	 */
	protected function archivo_base64($campo) {
		if (! isset ( $_FILES [$campo] )) {
			return "";
		}
		if ($_FILES [$campo] ["error"] !== UPLOAD_ERR_OK) {
			return "";
		}
		$type = $_FILES [$campo] ["type"];
		$path = $_FILES [$campo] ["tmp_name"];
		$data = file_get_contents ( $path );
		$base64 = 'data:' . $type . ';base64,' . base64_encode ( $data );
		return $base64;
	}
	protected function archivos_base64($campo) {
		$archivos = array ();
		foreach ( $_FILES [$campo] ["error"] as $error ) {
			if ($error !== UPLOAD_ERR_OK) {
				array_push ( $archivos, array (
						"status" => 0 
				) );
			} else {
				array_push ( $archivos, array (
						"status" => 1 
				) );
			}
		}
		for($i = 0; $i < count ( $archivos ); $i ++) {
			$archivos [$i] ["file"] = (($archivos [$i] ["status"]) ? 'data:' . ($_FILES [$campo] ["type"] [$i]) . ';base64,' . base64_encode ( file_get_contents ( $_FILES [$campo] ["tmp_name"] [$i] ) ) : "");
		}
		return $archivos;
	}
	
	/**
	 *
	 * Funcion para obtener un fomato de fecha especifico
	 *
	 * @param string $date
	 *        	(fecha)
	 * @return string $fecha (fecha formateada)
	 */
	protected function dateFormat($date, $format = 'Y/m/d') {
		if ($date == '0000-00-00 00:00:00' || empty ( $date ))
			$date = '';
		return ! $date ? "" : date ( $format, strtotime ( $date ) );
	}
	
	/**
	 * Establece un objeto de aprendizaje a mostrar.
	 *
	 * @param string $oda        	
	 */
	protected function objeto_de_aprendizaje($oda = "") {
		$this->nameODA = $oda;
		$this->setODA ();
	}
	
	/**
	 * Se metodo para setear un ODA, toma el primer archivo php que encuentre
	 */
	protected function setODA() {
		$dir = ODA . $this->nameODA;
		$files = $this->listFiles ( $dir );
		foreach ( $files as $file ) {
			if (pathinfo ( $file, PATHINFO_EXTENSION ) == "php") {
				$this->oda = $file;
				break;
			}
		}
	}
	
	/**
	 * Recupera los archivos dentro de una carpeta ingresada
	 *
	 * @param string $from        	
	 */
	protected function listFiles($from = '.') {
		if (! is_dir ( $from ))
			return false;
		$files = array ();
		$dirs = array (
				$from 
		);
		while ( NULL !== ($dir = array_pop ( $dirs )) ) {
			if ($dh = opendir ( $dir )) {
				while ( false !== ($file = readdir ( $dh )) ) {
					if ($file == '.' || $file == '..')
						continue;
					$path = $dir . '/' . $file;
					if (is_dir ( $path ))
						$dirs [] = $path;
					else
						$files [] = $path;
				}
				closedir ( $dh );
			}
		}
		return $files;
	}
	
	/**
	 * Lista de Mime_type
	 *
	 * @param unknown $file        	
	 * @throws \Exception
	 */
	protected function mime_type($file) {
		
		// there's a bug that doesn't properly detect
		// the mime type of css files
		// https://bugs.php.net/bug.php?id=53035
		// so the following is used, instead
		// src: http://www.freeformatter.com/mime-types-list.html#mime-types-list
		$mime_type = array (
				"3dml" => "text/vnd.in3d.3dml",
				"3g2" => "video/3gpp2",
				"3gp" => "video/3gpp",
				"7z" => "application/x-7z-compressed",
				"aab" => "application/x-authorware-bin",
				"aac" => "audio/x-aac",
				"aam" => "application/x-authorware-map",
				"aas" => "application/x-authorware-seg",
				"abw" => "application/x-abiword",
				"ac" => "application/pkix-attr-cert",
				"acc" => "application/vnd.americandynamics.acc",
				"ace" => "application/x-ace-compressed",
				"acu" => "application/vnd.acucobol",
				"adp" => "audio/adpcm",
				"aep" => "application/vnd.audiograph",
				"afp" => "application/vnd.ibm.modcap",
				"ahead" => "application/vnd.ahead.space",
				"ai" => "application/postscript",
				"aif" => "audio/x-aiff",
				"air" => "application/vnd.adobe.air-application-installer-package+zip",
				"ait" => "application/vnd.dvb.ait",
				"ami" => "application/vnd.amiga.ami",
				"apk" => "application/vnd.android.package-archive",
				"application" => "application/x-ms-application",
				"css" => "text/css",
				"js" => "text/javascript",
				"png" => "image/png" 
		);
		
		$extension = \strtolower ( \pathinfo ( $file, \PATHINFO_EXTENSION ) );
		
		if (isset ( $mime_type [$extension] )) {
			return $mime_type [$extension];
		} else {
			throw new \Exception ( "Unknown file type" );
		}
	}
	
	/**
	 * Metodo para realizar debug mediante el archivo logFiles
	 */
	protected function logFile($text) {
		$myfile = fopen ( dirname ( __FILE__ ) . "/log.txt", "a+" ) or die ( "Unable to open file!" );
		$txt = date ( "Y-m-d H:i:s" ) . "-----" . $text . "\n";
		fwrite ( $myfile, $txt );
		fclose ( $myfile );
	}
	
	/**
	 * Función pensada para remplazar el var_dump original de PHP
	 * para evitar este tipo de salidas en QA y PRODUCCION
	 *
	 * @param unknown $string        	
	 */
	protected function var_dump($string) {
		if (ENV == "DEV") {
			var_dump ( $string );
		}
	}
	
	/**
	 * Función que permite cortar un texto en cierta cantidad de palabras
	 *
	 * @param unknown $string        	
	 * @param unknown $wordsreturned        	
	 * @return string|unknown
	 */
	protected function shorten_string($string, $wordsreturned) {
		$retval = $string;
		$string = preg_replace ( '/(?<=\S,)(?=\S)/', ' ', $string );
		$string = str_replace ( "\n", " ", $string );
		$array = explode ( " ", $string );
		if (count ( $array ) <= $wordsreturned) {
			$retval = $string;
		} else {
			array_splice ( $array, $wordsreturned );
			$retval = implode ( " ", $array ) . " ...";
		}
		return $retval;
	}
}
?>