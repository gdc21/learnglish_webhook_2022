<?php
class AjaxAdminController extends Controller_Learnglish {
	public function __construct() {
		parent::__construct ();
	}
	public function SETSeccion() {
		$nivel = $_POST ['nivel'];
		$modulo = $_POST ['modulo'];
		$leccion = $_POST ['leccion'];
		$seccion = $_POST ['seccion'];
		$ord = array ();
		$obj = array ();
		$navegacion = (new EstructuraNavegacion ())->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180002" => $nivel,
				"LGF0180003" => $modulo,
				"LGF0180004" => $leccion,
				"LGF0180007" => "OASC" 
		) );
		foreach ( $navegacion as $item ) {
			array_push ( $ord, $item ["LGF0180006"] );
			array_push ( $obj, trim ( $item ["LGF0180006"], "obj" ) );
		}
		rsort ( $ord );
		rsort ( $obj );
		$orden = $ord [0];
		$objeto = $obj [0];
		$ok = (new EstructuraNavegacion ())->agregarEstructuraNavegacion ( ( object ) array (
				"LGF0180002" => $nivel,
				"LGF0180003" => $modulo,
				"LGF0180004" => $leccion,
				"LGF0180005" => $seccion,
				"LGF0180006" => $orden + 1,
				"LGF0180007" => "obj" . ($objeto + 1),
				"LGF0180008" => 1 
		) );
		$this->GETSecciones ();
	}
	
	/**
	 * Funcion para correguir
	 * Corregir Vista
	 * TODO Corregir Vista
	 *
	 * @param unknown $id        	
	 */
	public function savePregunta($id) {
		$PreguntID = (new CatalogoPreguntasEval ())->agregarCatalogoPreguntasEval ( ( object ) array (
				"LGF0200002" => $_POST ['preguntaTXT'],
				"LGF0200004" => $_POST ['tipo'],
				"LGF0200014" => date ( "Y-m-d H:i:s" ),
				"LGF0200010" => $_POST ['categoria'],
				"LGF0200003" => $this->archivo_base64 ( "preguntaIMG" ),
				"LGF0200015" => $this->userid,
				"LGF0200009" => $_POST ["id_eval"] 
		) );
		
		if (empty ( $PreguntID )) {
			$this->renderJSON ( array (
					'error' => 'Error al intentar guardar la evaluación' 
			) );
		}
		$ciclos = 0;
		if ($_POST ['tipo'] == "1")
			$ciclos = 4;
		else
			$ciclos = 2;
		
		for($i = 0; $i < $ciclos; $i ++) {
			if ($i == 0) {
				(new RespuestasEvaluacion ())->agregarRespuestasEvaluacion ( ( object ) array (
						'LGF0210002' => $PreguntID,
						'LGF0210003' => isset ( $_POST ['correctaTXT'] ) ? $_POST ['correctaTXT'] : "",
						'LGF0210005' => 'V',
						'LGF0210004' => $this->archivo_base64 ( 'correctaIMG' ) 
				) );
			} else {
				$incorrecta = 'incorrecta' . $i;
				(new RespuestasEvaluacion ())->agregarRespuestasEvaluacion ( ( object ) array (
						'LGF0210002' => $PreguntID,
						'LGF0210003' => isset ( $_POST [$incorrecta . 'TXT'] ) ? $_POST [$incorrecta . 'TXT'] : "",
						'LGF0210005' => 'F',
						'LGF0210004' => $this->archivo_base64 ( $incorrecta . 'IMG' ) 
				) );
			}
		}
		$this->renderJSON ( array (
				'mensaje' => [ 
						'url' => 'preguntas/' . $_POST ["id_eval"],
						'msg' => 'Se ha registrado la pregunta' 
				] 
		) );
	}
	/**
	 * TODO correguir la vista
	 * Funcion que permite actualizar una pregunta
	 *
	 * @param unknown $id        	
	 */
	public function updatePregunta($id) {
		$pregunta = (new CatalogoPreguntasEval ())->obtenCatalogoPreguntasEval ( ( object ) array (
				"LGF0200001" => $id 
		) );
		if (empty ( $pregunta )) {
			$this->Redirect ();
		}
		
		$preguntaIMG = $this->archivo_base64 ( "preguntaIMG" );
		
		$pregunta = $pregunta [0];
		$pregunta ["LGF0200002"] = $_POST ['preguntaTXT'];
		$pregunta ["LGF0200004"] = $_POST ['tipo'];
		$pregunta ["LGF0200010"] = $_POST ['categoria'];
		$pregunta ["LGF0200003"] = empty ( $preguntaIMG ) ? $pregunta ["LGF0200003"] : $preguntaIMG;
		$pregunta ["LGF0200018"] = $this->userid;
		$pregunta ["LGF0200019"] = date ( "Y-m-d H:i:s" );
		$ok = (new CatalogoPreguntasEval ())->actualizarCatalogoPreguntasEval ( ( object ) $pregunta, ( object ) array (
				"LGF0200001" => $id 
		) );
		if (empty ( $ok )) {
			$this->renderJSON ( array (
					'error' => 'Error al intentar guardar la evaluación' 
			) );
		}
		(new RespuestasEvaluacion ())->eliminaRespuestasEvaluacion ( ( object ) array (
				"LGF0210002" => $id 
		) );
		$ciclos = 0;
		if ($_POST ['tipo'] == "1")
			$ciclos = 4;
		else
			$ciclos = 2;
		
		for($i = 0; $i < $ciclos; $i ++) {
			if ($i == 0) {
				(new RespuestasEvaluacion ())->agregarRespuestasEvaluacion ( ( object ) array (
						'LGF0210002' => $id,
						'LGF0210003' => isset ( $_POST ['correctaTXT'] ) ? $_POST ['correctaTXT'] : "",
						'LGF0210005' => 'V',
						'LGF0210004' => $this->archivo_base64 ( 'correctaIMG' ) 
				) );
			} else {
				$incorrecta = 'incorrecta' . $i;
				(new RespuestasEvaluacion ())->agregarRespuestasEvaluacion ( ( object ) array (
						'LGF0210002' => $id,
						'LGF0210003' => isset ( $_POST [$incorrecta . 'TXT'] ) ? $_POST [$incorrecta . 'TXT'] : "",
						'LGF0210005' => 'F',
						'LGF0210004' => $this->archivo_base64 ( $incorrecta . 'IMG' ) 
				) );
			}
		}
		$this->renderJSON ( array (
				'mensaje' => [ 
						'url' => 'preguntas/' . $pregunta ["LGF0200009"],
						'msg' => 'Se ha actualizado la pregunta.' 
				] 
		) );
	}
	public function saveEvaluacion() {
		$ok = (new Evaluacion ())->agregarEvaluacion ( ( object ) array (
				"LGF0190002" => $_POST ['nombre'],
				"LGF0190003" => $_POST ['version'],
				"LGF0190004" => $_POST ['tipo'],
				"LGF0190005" => $_POST ['nivel'],
				"LGF0190006" => $_POST ['modulo'],
				"LGF0190007" => $_POST ['leccion'],
				"LGF0190011" => $_POST ['numPreguntas'],
				"LGF0190010" => $_POST ['activo'],
				"LGF0190014" => date ( "Y-m-d H:i:s" ) 
		) );
		
		if ($ok) {
			$this->renderJSON ( array (
					'mensaje' => [ 
							'url' => 'evaluaciones',
							'msg' => 'Se ha registrado la evaluación' 
					] 
			) );
		} else {
			$this->renderJSON ( array (
					'error' => 'Error al intentar guardar la evaluación' 
			) );
		}
	}
	public function updateEvaluacion($id) {
		$evaluacion = (new Evaluacion ())->obtenEvaluacion ( ( object ) array (
				"LGF0190001" => $id 
		) );
		if (empty ( $evaluacion )) {
			$this->Redirect ();
		}
		$evaluacion = $evaluacion [0];
		$evaluacion ["LGF0190002"] = $_POST ['nombre'];
		$evaluacion ["LGF0190003"] = $_POST ['version'];
		$evaluacion ["LGF0190004"] = $_POST ['tipo'];
		$evaluacion ["LGF0190005"] = $_POST ['nivel'];
		$evaluacion ["LGF0190006"] = $_POST ['modulo'];
		$evaluacion ["LGF0190007"] = $_POST ['leccion'];
		$evaluacion ["LGF0190011"] = $_POST ['numPreguntas'];
		$evaluacion ["LGF0190010"] = $_POST ['activo'];
		$evaluacion ["LGF0190014"] = date ( "Y-m-d H:i:s" );
		$ok = (new Evaluacion ())->actualizarEvaluacion ( ( object ) $evaluacion, ( object ) array (
				"LGF0190001" => $id 
		) );
		if ($ok) {
			$this->renderJSON ( array (
					'mensaje' => [ 
							'url' => 'evaluaciones',
							'msg' => 'Se ha registrado la evaluación' 
					] 
			) );
		} else {
			$this->renderJSON ( array (
					'error' => 'Error al intentar guardar la evaluación' 
			) );
		}
	}
	private function rrmdir($src) {
		$dir = opendir ( $src );
		while ( false !== ($file = readdir ( $dir )) ) {
			if (($file != '.') && ($file != '..')) {
				$full = $src . '/' . $file;
				if (is_dir ( $full )) {
				} else {
					unlink ( $full );
				}
			}
		}
		closedir ( $dir );
	}
	public function UploadFiles() {
		$seccion = (new EstructuraNavegacion ())->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180001" => $_POST ["id"] 
		) );
		$seccion = $seccion [0];
		
		$leccion = (new Leccion ())->obtenLeccion ( ( object ) array (
				"LGF0160001" => $seccion ["LGF0180004"] 
		) );
		$leccion = $leccion [0];
		
		$actual_abs = ODA . "n" . $seccion ["LGF0180002"] . "/m" . $seccion ["LGF0180003"] . "/l" . $leccion ["LGF0160007"] . "/" . $seccion ["LGF0180007"] . "/";
		if (! file_exists ( $actual_abs )) {
			mkdir ( $actual_abs, 0777, true );
		}
		$path = $_FILES ["file-4"] ["tmp_name"];
		$zip = new ZipArchive ();
		$error = 0;
		if ($zip->open ( $path, $error ) === true) {
			$js = false;
			$css = false;
			$dirs = array ();
			for($i = 0; $i < $zip->numFiles; $i ++) {
				$filename = $zip->getNameIndex ( $i );
				$fileinfo = pathinfo ( $filename );
				if ($fileinfo ["dirname"] == "." && $fileinfo ["basename"] == 'lo.css') {
					$css = true;
				}
				if ($fileinfo ["dirname"] == "." && $fileinfo ["basename"] == 'lo.js') {
					$js = true;
				}
				if (! isset ( $fileinfo ["extension"] )) {
					if ($fileinfo ["dirname"] == ".") {
						array_push ( $dirs, $actual_abs . $fileinfo ["basename"] );
					} else {
						array_push ( $dirs, $actual_abs . $fileinfo ["dirname"] . DIRECTORY_SEPARATOR . $fileinfo ["basename"] );
					}
				}
			}
			if ($css && $js) {
				$this->rrmdir ( $actual_abs );
				foreach ( $dirs as $dir ) {
					
						mkdir ( $dir, 0777, true );
					
				}
				for($i = 0; $i < $zip->numFiles; $i ++) {
					$filename = $zip->getNameIndex ( $i );
					$fileinfo = pathinfo ( $filename );
					if (isset ( $fileinfo ["extension"] )) {
						if ($fileinfo ["dirname"] == ".") {
							copy ( "zip://" . $path . "#" . $filename, $actual_abs . $fileinfo ['basename'] );
						} else {
							copy ( "zip://" . $path . "#" . $filename, $actual_abs . $fileinfo ["dirname"] . DIRECTORY_SEPARATOR . $fileinfo ["basename"] );
						}
					}
				}
				$this->renderJSON ( array (
						"mensaje" => "Se han subido correctamente los archivos." 
				) );
			} else {
				$this->renderJSON ( array (
						"mensaje" => "Verifique que existan los archivos lo.css y lo.js" 
				) );
			}
			$zip->close ();
		} else {
			switch ($error) {
				case ZipArchive::ER_INCONS :
				case ZipArchive::ER_INVAL :
					$this->renderJSON ( array (
							"mensaje" => "El archivo se encuentra corrupto." 
					) );
					break;
				case ZipArchive::ER_MEMORY :
					$this->renderJSON ( array (
							"mensaje" => "Ha ocurrido un error de memoria." 
					) );
					break;
				case ZipArchive::ER_NOZIP :
					$this->renderJSON ( array (
							"mensaje" => "El no es un ZIP." 
					) );
					break;
				case ZipArchive::ER_OPEN :
					$this->renderJSON ( array (
							"mensaje" => "Ha ocurrido un error al abrir el archivo, revise de nuevo el archivo." 
					) );
					break;
				case ZipArchive::ER_READ :
					$this->renderJSON ( array (
							"mensaje" => "Ha ocurrido un error al leer el archivo, revise de nuevo el archivo." 
					) );
					break;
			}
			$this->renderJSON ( array (
					"mensaje" => "El archivo proporcionado no se puede abrir." 
			) );
		}
	}
	public function UpdateSection() {
		$seccion = (new EstructuraNavegacion ())->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180001" => $_POST ["id"] 
		) );
		$seccion = $seccion [0];
		$seccion ["LGF0180005"] = $_POST ["id_sec"];
		$ok = (new EstructuraNavegacion ())->actualizarEstructuraNavegacion ( ( object ) $seccion, ( object ) array (
				"LGF0180001" => $_POST ["id"] 
		) );
		if ($ok) {
			$this->renderJSON ( array (
					"mensaje" => "Se ha modificado correctamente." 
			) );
		} else {
			$this->renderJSON ( array (
					"error" => "Ha ocurrido un error al modificar." 
			) );
		}
	}
	public function EstatusSection() {
		$seccion = (new EstructuraNavegacion ())->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180001" => $_POST ["id"] 
		) );
		$seccion = $seccion [0];
		$seccion ["LGF0180008"] = $_POST ["estatus"];
		$ok = (new EstructuraNavegacion ())->actualizarEstructuraNavegacion ( ( object ) $seccion, ( object ) array (
				"LGF0180001" => $_POST ["id"] 
		) );
		if ($ok) {
			$this->renderJSON ( array (
					"mensaje" => "Se ha modificado correctamente." 
			) );
		} else {
			$this->renderJSON ( array (
					"error" => "Ha ocurrido un error al modificar." 
			) );
		}
	}
	
	// SECCION PARA ADMINISTRACION DE OBJETOS
	public function GetModulos() {
		$nivel = $_POST ['nivel'];
		$modulos = (new Modulo ())->obtenModulo ( ( object ) array (
				"LGF0150004" => $nivel 
		) );
		$this->renderJSON ( $modulos );
	}
	public function GETSecciones() {
		$nivel = $_POST ['nivel'];
		$modulo = $_POST ['modulo'];
		$leccion = $_POST ['leccion'];
		$secciones = (new Administrador ())->get_secciones ( array (
				"nivel" => $nivel,
				"modulo" => $modulo,
				"leccion" => $leccion 
		) );
		$this->renderJSON ( $secciones );
	}
	public function GetLecciones() {
		$modulo = $_POST ['modulo'];
		$lecciones = (new Leccion ())->obtenLeccion ( ( object ) array (
				"LGF0160004" => $modulo 
		) );
		$this->renderJSON ( $lecciones );
	}
	public function GETListSec() {
		$result = (new Seccion ())->obtenSeccion ( ( object ) array (
				"LGF0170004" => 1 
		) );
		$this->renderJSON ( $result );
	}
	public function SETOrderSection() {
		$nivel = $_POST ['nivel'];
		$modulo = $_POST ['modulo'];
		$leccion = $_POST ['leccion'];
		$seccion = $_POST ['seccion'];
		// Posicion a mover el objeto que se
		$posicion = $_POST ['posicion'];
		// Posicion del objeto a mover
		$id = $_POST ['id'];
		//
		$move = $_POST ['move'];
		
		$e = new EstructuraNavegacion ();
		$nav_1 = $e->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180001" => $id 
		) );
		$estructura = $e->obtenEstructuraNavegacion ( ( object ) array (
				"LGF0180004" => $leccion,
				"LGF0180003" => $modulo,
				"LGF0180002" => $nivel,
				"LGF0180006" => "OASC" 
		) );
		$new_estructura = array ();
		$p = 0;
		$i = 0;
		while ( $p < count ( $estructura ) ) {
			if (($p + 1) == $posicion) {
				$nav_1 [0] ["LGF0180006"] = $posicion;
				array_push ( $new_estructura, $nav_1 [0] );
				$p ++;
			} else {
				if ($nav_1 [0] ["LGF0180001"] != $estructura [$i] ["LGF0180001"]) {
					$estructura [$i] ["LGF0180006"] = ($p + 1);
					array_push ( $new_estructura, $estructura [$i] );
					$p ++;
				}
				$i ++;
			}
		}
		
		foreach ( $new_estructura as $item ) {
			$e->actualizarEstructuraNavegacion ( ( object ) $item, ( object ) array (
					"LGF0180001" => $item ["LGF0180001"] 
			) );
		}
		$secciones = (new Administrador ())->get_secciones ( array (
				"nivel" => $nivel,
				"modulo" => $modulo,
				"leccion" => $leccion 
		) );
		$this->renderJSON ( $secciones );
	}
}