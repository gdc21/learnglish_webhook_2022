<?php
if (ENV == "PROD") {
	error_reporting ( 1 );
}
spl_autoload_register('autoCargaClass');
// Permite cargar las clases de manera automatica
function autoCargaClass($class_name) {
	try {
		if (file_exists ( CONTROLLER . $class_name . '.php' ) || file_exists ( MODEL . $class_name . '.php' ) || file_exists ( UCC . $class_name . '.php' ) || file_exists ( ENTITY . $class_name . '.php' ) || file_exists ( CONTROLLER . "core/" . $class_name . '.php' )) {
			require_once ($class_name . '.php');
		} else {
			throw new Exception ( "Unable to load $class_name.", "404" );
		}
	} catch ( Exception $ex ) {
		if (ENV == "DEV") {
			var_dump ( $ex->getTrace () );
			var_dump ( $ex->getMessage () );
			exit ();
		}
		if ($ex->getCode () == 404) {
			$min = 1;
			$max = 2;
			include_once __DIR__ . '/../error_pages/error_404_' . rand ( $min, $max ) . '.php';
			exit ();
		}
	}
}
function Redirect($permanent = false, $url = "") {
	if (headers_sent () === false) {
		header ( 'Location: ' . $url, true, ($permanent === true) ? 301 : 302 );
	}
	exit ();
}

/**
 * Clase que gestiona la creacion de clases y llamadas de metodos.
 * Gestiona la estructuracion de los parametros y el envio a las metodos.
 *
 * @author dfelipe
 *        
 */
class Route {
	
	/**
	 * Por default, se inicializa la clase HomeController
	 *
	 * @var string
	 */
	private $controller = "HomeController";
	
	/**
	 * Por default, el metodo a ejecutar es Index
	 *
	 * @var string
	 */
	private $action = "index";
	
	/**
	 * Por default, el array de parametros se encuentra vac�o
	 *
	 * @var unknown
	 */
	private $params = Array ();
	private $proxyAuth;
	
	/**
	 * El constructor establece los valores DEFAULT
	 */
	public function __construct() {
		define ( "DEFAULT_CLASS", str_ireplace ( "Controller", "", $this->controller ) );
		define ( "DEFAULT_ACTION", $this->action );
		$this->proxyAuth = new AuthController ();
	}
	
	/**
	 * El metodo action, se encarga de recuperar los parametros.
	 * Seleccionar la clase y el metodo a ejecutar
	 */
	public function action() {
		// Se analiza si existe el elemento $_GET
		// Si este valor esta vacio, quiere decir, que no se indicio ninguna Clase, Metodo o parametros
		// Por lo tanto los valores por default se executaran.
		// if(!empty($_GET)){
		// Verifica si existe el nombre de la clase. Si existe, este se limpia y se adhiere la palabra Controller
		if (isset ( $_GET ["controller"] ))
			$this->controller = ucfirst ( htmlspecialchars ( $_GET ["controller"] ) . "Controller" );
			// Verifica si se executara una accion especifica. Si no es asi, se ejecuta la default.
		if (isset ( $_GET ["action"] ))
			$this->action = htmlspecialchars ( $_GET ["action"] );
			// Verifica si se obtenieron parametros. Si es asi, se dividen en un array
		if (isset ( $_GET ["params"] ))
			$this->params = empty ( $_GET ["params"] ) ? array () : explode ( "/", $_GET ["params"] );
			// }else{
			// $this->RedirectURL(CONTEXT."site/index.html");
			// }
			// Verifica si existen parametros Post
		if (! empty ( $_POST )) {
			$params = Array ();
		}
		// Se valida el controller y la accion con los permisos del perfil del usuario
		// TODO pensar en desarrollar un sistema mejor para un ACL.
		$this->proxyAuth->proxyAuth ( $this->controller, $this->action );
		
		try {
			if ($this->isAjax ()) {
				$this->controller = "Ajax" . $this->controller;
			}
			$controller = new $this->controller ();
		} catch ( Exception $ex ) {
			$this->Redirect ();
		}
		
		// Verifica si la accion se encuentra en la clase. Si la clase no contiene la accion
		// Se realiza un Redireccionamiento con valores default
		if (method_exists ( $controller, $this->action )) {
			// Se verifica los parametros de la accion
			$this->params = $this->checkParameters ( $this->controller, $this->action, $this->params );
			// Si los parametros son propocionador, se ejecutara la funcion.
			// Si no es asi, se realiza un Redireccionamiento con valores default
			if ($this->params !== FALSE) {
				$this->regAction ( $this->controller, $this->action );
				call_user_func_array ( array (
						$controller,
						$this->action 
				), $this->params );
			} else {
				$this->Redirect ();
			}
		} else {
			$min = 1;
			$max = 2;
			include_once __DIR__ . '/../error_pages/error_404_' . rand ( $min, $max ) . '.php';
			exit ();
		}
	}
	
	/**
	 *
	 * Verifica los parametros de la accion.
	 * Parsea los parametros proporcionados, a los que necesita la accion
	 * Si los parametros proporcionados no satisfacen a los requeridos, se retorna un face.
	 * Si satifacen, se envia una array de claves con los parametros.
	 *
	 * @param string $className        	
	 * @param string $methodName        	
	 * @param array $parameters        	
	 * @return boolean|multitype:string
	 */
	private function checkParameters($className, $methodName, $parameters) {
		$r = new ReflectionMethod ( $className, $methodName );
		// Obtiene en un array el nombre de los parametros
		$params = $r->getParameters ();
		// Variable donde se almacenaran los nuevos parametros
		$aux = array ();
		// Cuanta los parametros para verificar si son los adecuados para la funcion
		if (count ( $params ) <= count ( $parameters )) {
			for($i = 0; $i < count ( $params ); $i ++) {
				// Se asigna la claves segun el orden
				$aux [$params [$i]->name] = htmlspecialchars ( $parameters [$i] );
			}
		} else {
			return false;
		}
		return $aux;
	}
	
	// SIn funcionalidad por el momento
	private function joinParameters() {
		$aux = $this->params;
		$this->params = Array ();
	}
	
	/**
	 * Función que verifica si el metodo llamado es solicitado por un
	 * proceso AJAX
	 *
	 * @return boolean
	 */
	private function isAjax() {
		/* AJAX check */
		if (! empty ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest') {
			return true;
		}
		return false;
	}
	
	/**
	 * Metodo que permite redireccionar
	 */
	private function Redirect() {
		$url = CONTEXT;
		$permanent = false;
		if (headers_sent () === false) {
			header ( 'Location: ' . $url, true, ($permanent === true) ? 301 : 302 );
		}
		exit ();
	}
	
	/**
	 * Obtiene el ID de la institución del usuario logueado
	 * o el ID de la institución que accede
	 *
	 * @return int|NULL
	 */
	private function obtenInstitucion() {
		if (isset ( $_SESSION ["idInstitucion"] ))
			return intval ( $_SESSION ["idInstitucion"] );
		return NULL;
	}
	
	/**
	 * Función para registrar cualquier acción
	 *
	 * @param unknown $controller        	
	 * @param unknown $action        	
	 */
	private function regAction($controller, $action) {
		if (! $this->isAjax ()) {
			(new LogController ())->registraAcceso ( $this->obtenInstitucion (), $controller, $action );
			return;
		}
	}
	
	/**
	 * Metodo para redirigir al usuario a una URL
	 *
	 * @param string $url        	
	 */
	private function RedirectURL($url) {
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
}
?>