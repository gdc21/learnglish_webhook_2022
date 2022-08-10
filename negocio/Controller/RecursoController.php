<?php
/**
 * Controlador para recuperar recursos de un ejercicio.
 * @author dfelipe
 *
 */
class RecursoController extends Controller_Learnglish{
	
	public function __construct(){
		
	}
	
	public function render(){
	}
	
	public $imagen_articulo = "img";
	public $recurso_articulo="file";
	
	public $archivos = array();
	public $messajesFiles = array();
	public $showODA = "";
	
	public function img(){
		
	}
	
	public function css(){
		
	}
	
	public function js(){
		
	}
	
	
	
	private function procesoZIPODA() {
		$nameTemp = $this->random_string ( 5 );
		if (isset ( $_FILES ["ODA"] )) {
			if ($_FILES ["ODA"] ["error"] == 0) {
				// Subimos el archivo PDF al Sevidor Local
					move_uploaded_file ( $_FILES ["ODA"]  ["tmp_name"], $path . $nombre.".".$extension );
				if (isset ( $res ["mensaje"] )) {
					// Guardamos el nombre del Descomprimimos ZIP
					$enzipado = new ZipArchive ();
					$nombreArchivo = $res ["nombre"];
					$file = pathinfo ( $nombreArchivo, PATHINFO_FILENAME );
					$extension = pathinfo ( $nombreArchivo, PATHINFO_EXTENSION );
					$nombreArchivo = TMP_MASIVO . $nombreArchivo;
					$carpetaTemporal = TMP_MASIVO . $file . "/";
					// Abrimos el archivo a descomprimir
					$enzipado->open ( $nombreArchivo );
					// Extraemos el contenido del archivo dentro de la carpeta especificada
					$extraido = $enzipado->extractTo ( $carpetaTemporal );
					// Si el archivo se extrajo correctamente listamos los nombres de los archivos que contenia de lo contrario mostramos un mensaje de error
					$archivos = array ();
					$csv = array ();
					$img = array ();
					$pdf = array ();
					$epub = array ();
					if ($extraido == TRUE) {
						for($x = 0; $x < $enzipado->numFiles; $x ++) {
							$archivo = $enzipado->statIndex ( $x );
							if (pathinfo ( $archivo ['name'], PATHINFO_DIRNAME ) != ".")
								continue;
								// almacenamos la informacion de los archivo
								if (pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "csv") {
									array_push ( $csv, pathinfo ( $archivo ['name'] ) );
									continue;
								}
								if (pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "jpg" || pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "jpeg" || pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "png") {
									array_push ( $img, pathinfo ( $archivo ['name'] ) );
									continue;
								}
								if (pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "pdf") {
									array_push ( $pdf, pathinfo ( $archivo ['name'] ) );
									continue;
								}
								if (pathinfo ( $archivo ['name'], PATHINFO_EXTENSION ) == "epub") {
									array_push ( $epub, pathinfo ( $archivo ['name'] ) );
									continue;
								}
						}
						$enzipado->close ();
						$archivos ["zip"] = $nombreArchivo;
						$archivos ["temporal"] = $carpetaTemporal;
						$archivos ["csv"] = $csv;
						$archivos ["img"] = $img;
						$archivos ["pdf"] = $pdf;
						$archivos ["epub"] = $epub;
						if (count ( $archivos ["csv"] ) == 0) {
							$this->deleteZip ( $archivos ["zip"], $archivos ["temporal"] );
							$this->parentClass->renderJSON ( array (
									"error" => "No existe un archivo CSV."
							) );
						}
						if (count ( $archivos ["csv"] ) > 1) {
							$this->deleteZip ( $archivos ["zip"], $archivos ["temporal"] );
							$this->parentClass->renderJSON ( array (
									"error" => "Solo debe existir un archivo CSV dentro del comprimido."
							) );
						}
						unlink ( $nombreArchivo );
						return $archivos;
					} else {
						unlink ( $nombreArchivo );
						$this->parentClass->renderJSON ( array (
								"error" => "Ocurrió un error y el archivo no se pudo descomprimir."
						) );
					}
				} else {
					$this->parentClass->renderJSON ( array (
							"error" => "Ha ocurrido un error al cargar el ZIP."
					) );
				}
			}
		}
	}
	
	public function procesaODA(){
		$odaCarpeta ="";
		if (isset ( $_FILES ["oda"] )) {
			var_dump($_FILES["oda"]);
			$nameTemp = $this->random_string ( 5 );
			if ($_FILES ["oda"] ["error"] == 0) {
				
				$file = pathinfo ( $_FILES ["oda"]["name"], PATHINFO_FILENAME );
				$extension = pathinfo ( $_FILES ["oda"]["name"], PATHINFO_EXTENSION );
				if(move_uploaded_file ( $_FILES ["oda"] ["tmp_name"],ODA.$file.".".$extension )){
					$odaCarpeta = ODA.$nameTemp;
					// Guardamos el nombre del Descomprimimos ZIP
					$enzipado = new ZipArchive ();
					$enzipado->open ( ODA.$file.".".$extension  );
					$extraido = $enzipado->extractTo ( $odaCarpeta );
				}
				error_reporting(0);
				unlink ( ODA.$file.".".$extension );
				error_reporting(-1);
			}
		}
		return $odaCarpeta;
	}
	
	
	
	/**
	 *
	 * @param string $path Ruta absoluta del archivo a convertir
	 * @return  string Archivo en Base 64
	 */
	function encodeBase64($type,$path){
		$data = file_get_contents($path);
		$base64 = 'data:'.$type. ';base64,' . base64_encode($data);
		return $base64;
	}
	
	
	/**
	 *
	 * @param string $base64_string Cadena Base64 a convertir
	 * @param string $output_file Ruta absoluta del archivo a guardar
	 * @return string Ruta del archivo
	 *
	 */
	function decodeBase64($base64_string, $output_file) {
		$ifp = fopen($output_file, "wb");
		$data = explode(',', $base64_string);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
		return $output_file;
	}
	
	public function uploadFile_Test(){
		$this->procesaODA();
		exit();
		
		if(isset($_FILES[$this->imagen_articulo])){
			var_dump($_FILES[$this->imagen_articulo]);
			if(!empty($_FILES[$this->imagen_articulo]["name"])){
				echo $this->encodeBase64($_FILES[$this->imagen_articulo]["type"],$_FILES[$this->imagen_articulo]["tmp_name"]);
			}
		}
	}
	
	public function error_file($code,$name,$index,$temp,$type,$recursoimg=false){
		switch ($code) {
			case UPLOAD_ERR_OK:
				array_push($this->archivos,array("mensaje"=>"El archivo se ha subido correctamente",
				"nombre"=>$name,"ok"=>true,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_INI_SIZE:
				$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$name,"ok"=>false,"index"=>$index,"temp"=>$temp,"type"=>$type));
				break;
			default:
				$message = "Unknown upload error";
				array_push($this->archivos,array("mensaje"=>$message,
						"nombre"=>$_FILES[$this->recurso_articulo]["name"][$key],"ok"=>false));
				break;
		}
	}
	
	
	
	public function checkFiles($campo){
		if(isset($_FILES)){
			foreach($_FILES[$this->recurso_articulo]["error"] as $key=>$value){
			}
		}
	}
	
	
	
	public function subeArchivo($nombreArchivo,$rutaCarpeta,&$mensajes,$campo="file"){
	
	
	
	
	}
	
	public function decodeBase64_file($base64_string = ""){
		$data = explode(',', $base64_string);
		$mimetype =array();
		preg_match("/:(.*?);/", $data[0], $mimetype);
		header('Content-Type:'. $mimetype[1]);
		$data = base64_decode($data[1]);
		echo $data;
	}
	
	public function uploadODA(){
		
	}
	
	private function random_string($length) {
		$key = '';
		$keys = array_merge ( range ( 0, 9 ), range ( 'a', 'z' ) );
	
		for($i = 0; $i < $length; $i ++) {
			$key .= $keys [array_rand ( $keys )];
		}
		return $key;
	}
	
	public function recursoODA($oda,$name){
		$this->nameODA = $oda;
		$dir = ODA.$oda;
		$files =  $this->listFiles($dir);
		foreach($files as $file){
			if(pathinfo ( $file, PATHINFO_BASENAME ) == $name){
				$contenido = file_get_contents($file);
				if(pathinfo ( $file, PATHINFO_EXTENSION ) == "css"){
					$contenido=str_replace("{path_recurso}",$this->pathRecurso(),$contenido);
				}
				(new Response())->sendResponse(200,$contenido,$this->mime_type($file));
				break;
			}
		}
		exit();
	}
	
	private function rrmdir($carpeta) {
		foreach ( glob ( $carpeta . "/*" ) as $archivos_carpeta ) {
			if (is_dir ( $archivos_carpeta )) {
				$this->rrmdir ( $archivos_carpeta );
			} else {
				unlink ( $archivos_carpeta );
			}
		}
		rmdir ( $carpeta );
	}
	
	public function categorizaElemento(){
		
	}
	
	public function is_url($url){
		return ((filter_var($url, FILTER_VALIDATE_URL) === FALSE)?false:true);
	}
	
}