<?php
class Class_Template{
	/**
	 * 
	 * @var Ruta absoluta de Vista
	 */
	protected  $viewAbs = "";
	
	/**
	 *
	 * @var Ruta relativa de Vista
	 */
	protected  $view = "";
	
	/**
	 * Almacena la ruta y despues la informacion del template a utilizar
	 *
	 * @var unknown
	 */
	protected $template = "";
	
	/**
	 * 
	 * @var unknown
	 */
	public $custom_template="";
	
	/**
	 * 
	 * @var unknown
	 */
	public $custom_header="";
	
	/**
	 * Almacena la ruta y despues la informacion que se desplegara en la seccion Header
	 *
	 * @var unknown
	 */
	public $header;
	
	/**
	 * Almacema la ruta y despues la informacion que se desplegara en la seccion Body
	 *
	 * @var unknown
	 */
	public $body;
	
	/**
	 * Almacena la ruta y despues la informacion que se desplegara en la seccion Title
	 *
	 * @var unknown
	 */
	protected $title;
	
	/**
	 * Almacena la ruta y despues la informacion que se desplegara en la seccion Menu
	 *
	 * @var unknown
	 */
	protected $menu;
	
	/**
	 * Almacena la ruta y despues la informacion que se desplegara en la seccion Footer
	 *
	 * @var unknown
	 */
	protected $footer;
	
	/**
	 * Almacena la ruta y despuesta la informacion que se desplegara en la seccioin de quote
	 * @var unknown
	 */
	protected $quote;
	
	/**
	 * Por default la seccion quote no es cargada
	 * @var unknown
	 */
	public $load_quote=false;
	
	/**
	 * Almacena la ruta y despues la informacion que se desplegara como elemento ODA
	 * @var unknown
	 */
	protected $oda = "";
	
		/**
	 * Almacena información para ser utilizada en la vista
	 * @var array
	 */
	private $temp =  array();

	/**
	 * Variable para guarar refencia del controller principal
	 * @var Controller
	 */
	protected $controller;
	
	/**
	 * Constructor padre.
	 * Todas las clases que hereden de esta clase deberan llamar el constructor padre.
	 *
	 * public function __construct(){
	 * parent::__construct();
	 * }
	 */
	public function __construct(Controller &$controller) {
		$this->controller = $controller;
		(new SniffClient());
		//Ruta absoluta para hacer referencia a los elementos que se utilizara la vista {Desktop,phone,tablet}
		define('VIEW_REALPATH',dirname(__FILE__)."/../../../portal/frontend/");
		$this->viewAbs = dirname(__FILE__)."/../../../portal/frontend/";
		$this->view = CONTEXT."portal/frontend";
		$this->template = $this->viewAbs . "layout/body.php";
		$this->footer = $this->viewAbs . "layout/footer.php";
		$this->header = $this->viewAbs . "layout/header.php";
		$this->isPOST = $_SERVER ['REQUEST_METHOD'] === "POST";
	}
	
	/**
	 * Funcion que permite colocar el template con todos las secciones
	 *
	 * @param string $title
	 * @param string $template
	 * @param string $header
	 * @param string $body
	 * @param string $footer
	 * @param string $menu
	 */
	public function setTemplate($title = "", $template = "", $header = "", $body = "", $footer = "", $menu = "") {
		$this->template = $template;
		$this->header = $header;
		$this->body = $body;
		$this->footer = $footer;
		$this->menu = $menu;
		$this->title = $title;
	}
	
	/**
	 * Funcion para cargar la informacion del template
	 * @param string $template Ruta del archivo de Template
	 */
	protected function load_template($template) {
		$this->template = $this->get_include_contents ( $template );
	}
	
	/**
	 * Funcion para carhar la informacion del Header
	 * @param string $header Ruta para el archivo del header
	 */
	public function load_header($header) {
		$this->header = $this->get_include_contents ( $header );
	}
	
	/**
	 * Titulo a asignar
	 * @param string $title
	 */
	public function load_Title($title) {
		$this->title = $title;
	}
	/**
	 * Funcion para cargar la informacion del body
	 * @param string $body
	 */
	public function load_Body($body) {
		$this->body = $this->get_include_contents ( $body );
	}
	
	/**
	 * Funcion para cargar la seccion de quote
	 *
	 * @param string $footer
	 *        	Path real del archivo para la seccion $footer
	 */
	public function load_Quote($quote) {
		$this->quote = $this->get_include_contents ( $quote );
	}
	
	/**
	 * Funcion para cargar la seccion de footer
	 *
	 * @param string $footer
	 *        	Path real del archivo para la seccion $footer
	 */
	public function load_Footer($footer) {
		$this->footer = $this->get_include_contents ( $footer );
	}
	
	/**
	 * Funcion para cargar la seccion de un menu
	 *
	 * @param string $menu
	 *        	Path real del archivo para la seccion $mnu
	 */
	public function load_leftMenu($menu) {
		$this->menu = $this->get_include_contents ( $menu );
	}
	
	
	public function render($temp,$status=200){
		$this->temp = $temp;
		if(empty($this->body)){
			$this->body = $this->viewAbs . "views/" .$this->temp ["seccion"] . "/" . $this->temp ["accion"] . ".php";
		}
		$this->load_Title ( $this->title );
		$this->load_header((empty($this->custom_header)?$this->header:$this->viewAbs . "layout/".$this->custom_header));
		$this->load_Footer ( $this->footer );
		$this->load_Body ($this->body );
		$this->load_leftMenu ( $this->menu );
		$this->load_template((empty($this->custom_template)?$this->template:$this->viewAbs . "layout/".$this->custom_template));
		(new Response())->sendResponse ( $status, $this->template, 'text/html' );
	}
	
	/**
	 *  Función que permite recuperar un archivo .php, sin perder su funcionalidad.
	 *	Es decir, el código en php del archivo se ejecutara en el mismo ambiente de la clase
	 */
	private function get_include_contents($filename) {
		if (is_file ( $filename )) {
			ob_start ();
			include $filename;
			return ob_get_clean ();
		}
		return false;
	}
	/**
	 *  Función que permite recuperar el title de una url.
	 *	
	 */
	private function getTitle($url) {
		$strs = @file_get_contents($url);
		if ($strs) {
			preg_match('/<title>([^<]+)</', $strs, $title);
			return isset($title[1]) ? $title[1] : $url;
		}
		return false;
	}

	/**
	 * 
	 * @param unknown $type Tipo del Recurso
	 * @param unknown $name	Nombre del Recurso
	 */
	public function recurso($name){
		echo CONTEXT."Recurso/recursoODA/".$this->controller->nameODA."/".$name;
	
	}
	
	public function pathRecurso(){
		return "";
		//return $this->controller->pathRecurso();
	}
	
}
?>