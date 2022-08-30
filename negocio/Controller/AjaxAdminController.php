<?php
	class AjaxAdminController extends Controller_Learnglish {
		public function __construct() {
			parent::__construct ();
		}


        public function asignaralumnosagrupodesdecurps(){
            $grupo = $_POST['grupo'];
            $docente = $_POST['docente'];
            $curps = $_POST['curps'];
            $institucion = $_POST['institucion'];

            if(!preg_match ('/^[a-zA-Z0-9,]+$/', $curps)){
                $this->renderJSON ( array (
                    'result' => "invalid_data",
                    'msg'    => "Formato o tipo de datos no valido, no usar acentos o caracteres especiales."
                ) );
            }else{
                $curpsProcesados = explode(',', $curps);

                $verificarCurpsContraBase = (new Administrador())->verificarCurpsAlumnosCargados($curpsProcesados);

                if($verificarCurpsContraBase != []){

                    if(count($curpsProcesados) == count($verificarCurpsContraBase)){
                        $resultado = (new Administrador())->actualizarAlumnosGrupoDocente($curpsProcesados, $grupo, $docente, $institucion);

                        $this->renderJSON ( array (
                            'result' => "updated_correctly",
                            'msg'    => 'Todo ok ',
                        ) );
                    }else{
                        $faltantes = [];

                        foreach ($curpsProcesados as $curpPost){
                            $aparecio = false;
                            $cual = '';
                            foreach ($verificarCurpsContraBase as $curpBaseDatos){
                                $cual = $curpPost;
                                if($curpBaseDatos['curp'] == $curpPost){
                                    $aparecio = true;
                                }
                            }
                            if(!$aparecio){
                                $faltantes[] = $cual;
                            }
                        }

                        $this->renderJSON ( array (
                            'result' => "not_equals",
                            'msg'    =>'<h3>Los SIGUIENTES alumnos NO APARECEN en la base, NINGÚN registro se actualizó, verifica y vuelve a intentar</h3>',
                            'alumnosNoAparecen'    => $faltantes
                        ) );
                    }

                }else{
                    $this->renderJSON ( array (
                        'result' => "invalid_data",
                        'msg'    => 'Los alumnos NO APARECEN en la base, NINGÚN registro se actualizó, verifica y vuelve a intentar.',
                    ) );
                }
            }
        }

        public function eliminarpreview(){
            $id_leccion = $_POST['id_leccion'];

            $data = (new Leccion ())->actualizarLeccion ( ( object ) array (
                "LGF0160009" => ''
            ), (object) array(
                'LGF0160001' => $id_leccion
            ) );
            if($data){
                $this->renderJSON ( array (
                    'error' => 0,
                    'data' => '<div class="alert alert-success" role="alert">Preview borrado correctamente.</div><br><br><button onclick="window.location.reload();" class="btn btn-success mx-auto text-center">Recargar página</button>'
                ) );
            }else{
                $this->renderJSON ( array (
                    'error' => 1,
                    'data' => "<p style='color: red;' class='mt-2'>Hubo un error al borrar el preview del video.</p>"
                ) );
            }
        }

        public function cargarpreview(){
            $id_video = $_POST['id_video'];
            $id_leccion = $_POST['id_leccion'];

            $leccion = (new Leccion ())->obtenLeccion ( ( object ) array (
                "LGF0160001" => $id_leccion
            ) );

            if(empty($leccion)){
                $this->renderJSON ( array (
                    'error' => 1,
                    'data' => "<p style='color: red;' class='mt-2'>Hubo un error en el id del video.</p>"
                ) );
            }
            $nombre_leccion = $this->eliminar_acentos($leccion[0]['LGF0160002']);

            $base_preview_iframe = '<iframe width="100%" style="min-height: 30vh;" src="https://www.youtube.com/embed/'.$id_video.'" title="'.$nombre_leccion.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

            $data = (new Leccion ())->actualizarLeccion ( ( object ) array (
                "LGF0160009" => $base_preview_iframe
            ), (object) array(
                'LGF0160001' => $id_leccion
            ) );

            if(!empty($data)){
                $this->renderJSON ( array (
                    'error' => 0,
                    'data' => '<div class="alert alert-success" role="alert">Preview cargado correctamente.</div><br><br><button onclick="window.location.reload();" class="btn btn-success mx-auto text-center">Recargar página</button>'
                ) );
            }else{
                $this->renderJSON ( array (
                    'error' => 1,
                    'data' => "<p style='color: red;' class='mt-2'>Hubo un error al cargar el preview, favor de reintentar.</p>"
                ) );
            }


        }

        public function gruposyprofesoresdeinstitucion(){
            $institucion = $_POST['institucion'];

            $grupos = (new Administrador())->obtener_grupos($institucion);
            $docentes = (new Administrador())->obtener_docentes_desde_institucion($institucion);

            $this->renderJSON ( array (
                'grupos' => $grupos == null ? 0:$grupos,
                'docentes' => $docentes == null ? 0:$docentes
            ) );
        }


        public function guardarinstrucciones($tipo){
            if($tipo == 1){
                $this->renderJSON ( array (
                    'data' => "Hola como estas 1 bsbs"
                ) );
            }elseif($tipo == 2){
                $this->renderJSON ( array (
                    'data' => "Hola como estas 2 bsbs"
                ) );
            }else{
                $this->renderJSON ( array (
                    'data' => "Adios bsbs"
                ) );
            }
        }

        public function leccionesdemodulo() {
            $modulo = $_POST['modulo'];
            $data = (new Leccion ())->obtenLeccion ( ( object ) array (
                "LGF0160004" => $modulo
            ) );
            $this->renderJSON ( array (
                'data' => $data
            ) );
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
					"LGF0180008" => 1,
					"LGF0180009" => date("Y-m-d")
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

			// echo nl2br($_POST ['preguntaTXT']);
			
			$preguntaIMG = $this->archivo_base64 ( "preguntaIMG" );
			
			$pregunta = $pregunta [0];
			$pregunta ["LGF0200002"] = nl2br($_POST ['preguntaTXT']);
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
		/**
		 * Funcion para guardar usuarios	
		 * TODO Formulario guardar usuarios
		 *	
		 */
		public function saveUsuario() {
			$ok = (new Usuarios ())->agregarUsuario ( ( object ) array (
					"LGF0010002" => $_POST ["nombre"],
					"LGF0010003" => $_POST ["lastnamep"],
					"LGF0010004" => $_POST ["lastnamem"],
					"LGF0010005" => $_POST ["user"],
					"LGF0010006" => $_POST ["password"],
					"LGF0010007" => $_POST ["perfil"],				
					"LGF0010008" => $_POST ["activo"],				
					"LGF0010009" => $this->archivo_base64 ('archivoImg'),				
					"LGF0010021" => $_POST ["sexo"],
					"LGF0010023" => $_POST ["nivel"],
					"LGF0010024" => $_POST ["modulo"],
					"LGF0010025" => $_POST ["leccion"],
					"LGF0010030" => date ( "Y-m-d H:i:s" )
			) );	
		
			
			if ($ok) {
				$this->renderJSON ( array (
						"mensaje" => "Usuario registrado exitosamente." 
				) );
			} else {
				$this->renderJSON ( array (
						"error" => "Ha ocurrido un error al registrar el usuario." 
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
			
			$actual_abs = ODA."n".$seccion["LGF0180002"]."/m".$seccion["LGF0180003"]."/l".$leccion["LGF0160007"]."/".$seccion["LGF0180007"]."/";
			if (! file_exists ( $actual_abs )) {
				mkdir ( $actual_abs, 0777, true );
			}
			// die();
			$path = $_FILES ["file-4"] ["tmp_name"];
			$zip = new ZipArchive ();
			$error = 0;
			if ($zip->open ( $path, $error ) === true) {
				$js = false;
				$css = false;
				$dirs = array ();
				for($i = 0; $i < $zip->numFiles; $i ++) {
					$filename = $zip->getNameIndex($i);
					$fileinfo = pathinfo($filename);
					// echo "<pre>".print_r($fileinfo)."</pre>";
					if ($fileinfo["dirname"] == "." && $fileinfo["basename"] == 'lo.css') {
						// echo "CSS \n";
						$css = true;
					} else {
						// echo "CSS - F \n";
					}
					if ($fileinfo["dirname"] == "." && $fileinfo["basename"] == 'lo.js') {
						// echo "JS \n";
						$js = true;
					} else {
						// echo "JS - F \n";
					}
					if (! isset ( $fileinfo ["extension"] )) {
						if ($fileinfo ["dirname"] == ".") {
							// echo ":D \n";
							array_push ( $dirs, $actual_abs . $fileinfo ["basename"] );
						} else {
							// echo ":P \n";
							array_push ( $dirs, $actual_abs . $fileinfo ["dirname"] . DIRECTORY_SEPARATOR . $fileinfo ["basename"] );
						}
					}
				}
				// echo "<pre>".print_r($dirs)."</pre>";
				// die();
				if ($css && $js) {
					// echo "Entro aqui\n";
					// $this->rrmdir ( $actual_abs );
					foreach ( $dirs as $dir ) {
						if (! file_exists ( $dir )) {
							mkdir ( $dir, 0777, true );
						}
					}
					for($i = 0; $i < $zip->numFiles; $i ++) {
						$filename = $zip->getNameIndex ( $i );
						$fileinfo = pathinfo ( $filename );
						if (isset ( $fileinfo ["extension"] )) {
							if ($fileinfo ["dirname"] == ".") {
								// echo "1\n";
								copy("zip://".$path."#".$filename, $actual_abs.$fileinfo['basename']);
							} else {
								// echo "2\n";
								copy("zip://".$path."#".$filename, $actual_abs.$fileinfo["dirname"].DIRECTORY_SEPARATOR.$fileinfo["basename"]);
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
        public function GETSeccionesActivas() {
            $nivel = $_POST ['nivel'];
            $modulo = $_POST ['modulo'];
            $leccion = $_POST ['leccion'];
            $secciones = (new Administrador ())->get_secciones ( array (
                "nivel" => $nivel,
                "modulo" => $modulo,
                "leccion" => $leccion
            ), 1 );
            $this->renderJSON ( $secciones );
        }
        public function GetLeccionData() {
            $leccion = $_POST ['leccion'];
            $lecciones = (new Leccion ())->obtenLeccion ( ( object ) array (
                "LGF0160001" => $leccion
            ) );
            $this->renderJSON ( $lecciones );
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
        public function GETEstructuraNavegacion(){
            $id = $_POST['id_estructura'];
            $e = new EstructuraNavegacion ();

            $estruc_nav = $e->obtenEstructuraNavegacion ( ( object ) array (
                "LGF0180001" => $id
            ) );

            $data = array(
                'id'                => $estruc_nav[0]['LGF0180001'],
                'audio_es'          => $estruc_nav[0]['LGF0180012'],
                'audio_en'          => $estruc_nav[0]['LGF0180013'],
                'img_instrucciones' => $estruc_nav[0]['LGF0180014']
            );

            $this->renderJSON ( $data );
        }

        public function borrar_archivo_directorio($archivo){
            if(!is_dir($archivo) && file_exists($archivo)){
                unlink($archivo);
            }
        }

        public function DELPartOfEstructuraNavegacion(){
            $id = $_POST['id_estructura_navegacion'];
            $nombre_campo_eliminar = $_POST['nombre_campo_eliminar'];
            $relative_path_folder = $_POST['ruta_archivo'];

            $campos_posibles = array(
                'audio_es'          => "LGF0180012",
                'audio_en'          => "LGF0180013",
                'img_instrucciones' => "LGF0180014",
            );

            if(in_array($nombre_campo_eliminar, array_keys($campos_posibles))){
                $e = new EstructuraNavegacion ();

                /*Buscamos para borrar el archivo*/
                $estructura_navegacion = $e->obtenEstructuraNavegacion ( ( object ) array (
                    "LGF0180001" => $id
                ) );
                $direccion_archivo_borrar =
                    __DIR__.
                    "/../../".
                    $relative_path_folder.
                    $estructura_navegacion[0][$campos_posibles[$nombre_campo_eliminar]];

                $this->borrar_archivo_directorio($direccion_archivo_borrar);

                $registro_actualizado = $e->actualizarEstructuraNavegacion((object) array(
                    $campos_posibles[$nombre_campo_eliminar] => ''
                ), (object) array(
                    "LGF0180001" => $id
                ));

                if($registro_actualizado){
                    $this->renderJSON ( array(1) );
                }
            }else{
                $this->renderJSON ( array(0) );
            }


        }
		
		// SECCION PARA ADMINISTRACION DE OBJETOS
		public function GetPerfiles() {		
			$perfiles = (new Perfil ())->obtenPerfiles ();
			$this->renderJSON ( $perfiles );
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

		// SECCION PARA INSTITUCIONES
		public function saveInstitucion() {
			$nombre = $_POST['nombre']; // LGF0270002
			$nombreCorto  = $_POST['nameCorto']; // LGF0270022
			$vigencia = $_POST['vigencia']; // LGF0270005
			$ip = $_POST['ip']; // LGF0270020
			$lote = $_POST['lote']; // LGF0270019
			$fecha = date('Y-m-d H:i:s'); // LGF0270013
			$pais = $_POST['pais']; // LGF0270010
			$cliente = $_POST['cliente']; // LGF0270021
			// $imagen = $this->archivo_base64($_POST['logotipo']);
			$usuario = $_POST['usuario']; // LGF0270024
			$password = $_POST['password']; // LGF0270025
			$tipo = $_POST['tipo'];
			$fecha_inicio = $_POST['fecha']; // LGF0270004
			$cct = $_POST['cct']; // LGF0270004
			$aux = explode("-", $fecha_inicio);
			$fecha_inicio = $aux[2]."-".$aux[1]."-".$aux[0];
			$modulo = "";

			$data = array(
				'LGF0270002' => $nombre, // Nombre
				'LGF0270022' => $nombreCorto, // Nombre corto
				'LGF0270016' => $this->userid, // ID Usuario alta
				'LGF0270013' => $fecha, // Fecha de creacion
				// 'LGF0270010' => $pais, // Pais
				'LGF0270021' => $cliente, // ID Cliente
				'LGF0270019' => $lote, // Licencias contratadss
				'LGF0270020' => $ip, // Login URL
				'LGF0270012' => 1, // Activo/Inactivo
				'LGF0270005' => $vigencia." 23:59:59", // Fecha termino
				'LGF0270004' => $fecha_inicio, // Fecha inicio
				'LGF0270023' => 4, // ID Perfil 4 -> Institución
				'LGF0270024' => $usuario, // Usuario
				'LGF0270025' => $password, // Contraseña
				'LGF0270028' => $cct // cct
			);

			/*echo "<pre>";
			print_r($data);
			echo "</pre>";
			die();*/
			
			$respuesta = (new Instituciones())->agregarInstitucion((object) $data);
			if ($respuesta) {
				for ($i=0; $i < count($tipo); $i++) { 
					$data_modulo_institucion = array(
						"LGF0300002" => $respuesta,
						"LGF0300003" => $tipo[$i]
					);
					$modulo_institucion = (new ModuloInstitucion())->addModuloInst((object) $data_modulo_institucion);
				}
				$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$_POST['pass'], "LGF0330003"=>4);
				$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
				$this->renderJSON(array("mensaje" => "Institución registrada exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al registrar la institución."));
			}
			// echo $this->archivo_base64('logotipo');
		}

		public function deleteInstitucion() {
			// echo "ID recibido: ".$_POST['id'];
			$estatus['LGF0270012'] = 0;
			$respuesta = (new Instituciones())->actualizarInstitucion((object) $estatus, (object) array (
				"LGF0270001" => $_POST['id']
			));

			if ($respuesta) {
				$this->renderJSON(array("mensaje" => "Institución eliminada exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al eliminar la institución, inténtelo de nuevo."));
			}
		}

		public function updateInstitucion() {
			$nombre = $_POST['nombre']; // LGF0270002
			$nombreCorto  = $_POST['nameCorto']; // LGF0270022
			$vigencia = $_POST['vigencia']; // LGF0270005
			$ip = $_POST['ip']; // LGF0270020
			$lote = $_POST['lote']; // LGF0270019
			$fecha = date('Y-m-d H:i:s'); // LGF0270013
			$pais = $_POST['pais']; // LGF0270010
			$cliente = $_POST['cliente']; // LGF0270021
			// $imagen = $this->archivo_base64($_POST['logotipo']);
			$tipo = $_POST['tipo'];
			$cct = $_POST['cct'];
			$modulo = "";
			
			for ($i=0; $i < count($tipo); $i++) { 
				if ($i == 0) {
					$modulo.= $tipo[$i];
				} else {
					$modulo.= ",".$tipo[$i];
				}
			}

			$usuario = $_POST['usuario']; // LGF0270024
			$password = $_POST['password']; // LGF0270025

			$data = array(
				'LGF0270002' => $nombre, // Nombre
				'LGF0270022' => $nombreCorto, // Nombre corto
				'LGF0270017' => $this->userid, // ID Usuario modifico
				'LGF0270014' => $fecha, // Fecha de modificacion
				// 'LGF0270010' => $pais, // Pais
				'LGF0270021' => $cliente, // ID Cliente
				'LGF0270020' => $ip, // Login URL
				'LGF0270005' => $vigencia." 23:59:59", // Fecha termino
				'LGF0270024' => $usuario, // Nick de usuario
				'LGF0270023' => 4, // ID Perfil
				'LGF0270028' => $cct // cct
			);

			if (!empty($password)) {
				$data['LGF0270025'] = $password;
			}

			if ($_SESSION['perfil'] == 1) {
				$data['LGF0270019'] = $lote; // Licencias contratadss
			}

			$respuesta = (new Instituciones())->actualizarInstitucion((object) $data, (object) array (
				"LGF0270001" => $_POST['id']
			));

			if ($respuesta) {
				if (!empty($password)) {
					$checkPassUser = (new Administrador())->checkPassUser($_POST['id'], 4);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$_POST['id'],"LGF0330002"=>$_POST['pass'], "LGF0330003"=>4);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330002"=>$_POST['pass']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$_POST['id'], "LGF0330003"=>4
						));
					}
				}
				$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al intentar actualizar la Información, inténtelo de nuevo."));
			}
		}

		/**
			 * Listado de usuarios
			 */
		public function obtenerUsuarios() {
			$id = $_POST['id'];
			$lista = (new Administrador())->lista_usuarios($id);
			// print_r($lista);
			$tabla = '';
			if (count($lista) > 0) {
				foreach ($lista as $usuario) {
					if (empty($usuario['nombre'])) {
						$nombre = '----';
					} else {
						$nombre = $usuario['nombre'];
					}
					if (empty($usuario['institucion'])) {
						$institucion = "----";
					} else {
						$institucion = $usuario['institucion'];
					}
					if (empty($usuario['grupo'])) {
						$grupo = "----";
					} else {
						$grupo = $usuario['grupo'];
					}
					if (empty($usuario['fecha'])) {
						$fecha = "N/A";
					} else {
						$fecha = $usuario['fecha'];
					}
					if (empty($usuario['pass']) || $usuario['pass'] == null) {
						$password = "----";
					} else {
						$password = $usuario['pass'];
					}
					$username = $usuario['LGF0010005'];
					if ($_SESSION['perfil'] == 6) {
						$tabla.='<tr><td>'.$nombre.'</td><td>'.$institucion.'</td><td>'.$grupo.'</td><td>'.$fecha.'</td><td>'.$username.'</td><td>'.$password.'</td></tr>';
					} else {
						$tabla.='<tr><td>'.$nombre.'</td><td>'.$institucion.'</td><td>'.$grupo.'</td><td>'.$fecha.'</td><td>'.$username.'</td><td>'.$password.'</td><td><span><a href="'.CONTEXT.'admin/editUsuario/'.$usuario['LGF0010001'].'"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a></span><span><a href="#" onclick="eliminar('.$usuario['LGF0010001'].')"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</a></span></td></tr>';
					}
				}
			} else {
				if ($_SESSION['perfil'] == 6) {
					$tabla.='<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>';
				} else {
					$tabla.='<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>';
				}
			}
			$this->renderJSON(array("info" => $tabla, "total"=>count($lista)));
		}

		public function validarLicencias() {
			$id = $_POST['id'];
			$lista = (new Administrador())->informacion_institucion($id);
			$licencias_permitidas = $lista[0]['LGF0270019'];
			// echo "licencias permitidas: ".$licencias_permitidas;
			$licencias = (new Administrador())->licencias_permitidas($id);
			$licencias_registradas = $licencias[0]['total'];
			// echo " Licencias registradas: ".$licencias_registradas."\n";
			if ($licencias_permitidas == 0) {
				// echo "Esta institucion no tienen ninguna licencia contratada";
				$this->renderJSON(array("error" => "Esta institución no tienen ninguna licencia contratada."));
			} else if ($licencias_registradas < $licencias_permitidas) {
				// echo $licencias_registradas." < ".$licencias_permitidas;
				$this->renderJSON(array("success"));
			} else if ($licencias_permitidas >= $licencias_registradas) {
				// echo $licencias_permitidas." >= ".$licencias_registradas;
				$this->renderJSON(array("error" => "Ya no tienes licencias para poder registrar más usuarios."));
			}
		}

        public function listar_alumnos_grupo_especifico(){
            $id = $_POST['id'];

            $lista = (new Administrador())->listar_alumnos_grupo($id);
			$this->renderJSON(array("lista" => $lista));
        }

		public function obtenerGrupos() {
			$id = $_POST['id'];
			$modulo = $_POST['grado'];
			$lista = (new Administrador())->obtener_grupos($id, $modulo);
			$this->renderJSON(array("lista" => $lista));
		}

		public function validarLicenciasRegistradas($id) {
			$lista = (new Administrador())->informacion_institucion($id);
			$licencias_permitidas = $lista[0]['LGF0270019'];
			// echo "licencias permitidas: ".$licencias_permitidas;
			$licencias = (new Administrador())->licencias_permitidas($id);
			$licencias_registradas = $licencias[0]['total'];
			if ($licencias_permitidas == 0) {
				// echo "Esta institucion no tienen ninguna licencia contratada";
				return 0;
			} else if ($licencias_registradas < $licencias_permitidas) {
				// echo $licencias_registradas." < ".$licencias_permitidas;
				return 1;
			} else if ($licencias_permitidas >= $licencias_registradas) {
				// echo $licencias_permitidas." >= ".$licencias_registradas;
				return 2;
			}
		}

		public function saveAddUsuario() {
			$institucion = $_POST['institucion'];
			$perfil = $_POST['perfil'];
			$nombre = $_POST['nombre'];
			$aPaterno = $_POST['aPaterno'];
			$aMaterno = $_POST['aMaterno'];
			$fNacimiento = $_POST['fNacimiento'];
			$grupo = $_POST['grupo']; // Pendiente
			$email = $_POST['email'];
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			$estatus = $_POST['estatus'];
			$id = $_POST['id'];
			$genero = $_POST['genero'];
			$curp = $_POST['curp'];

			$check = (new Administrador())->check_matricula($curp);
			if (!empty($check)) {
				$this->renderJSON(array("error" => "Ya existe un usuario con este CURP registrado"));
			}

			// Campos nuevos
			$continuaRegistro = false;
			if ($perfil == 2) {
				$aux = explode("_", $_POST['leccion']);
				$leccion = $aux[0];
				$nivel = $aux[1];
				$modulo = $_POST['nivel'];

				$grupos = (new Administrador())->grupos($grupo);
				// print_r($grupos);
				$nivel_asignado = $grupos[0]['LGF0290005'];
				// echo $nivel_asignado." ".$modulo."<br>";
				if ($modulo != $nivel_asignado) {
					$continuaRegistro = true;
				}
			} else {
				$datos = (new Administrador())->obtener_niveles();
				$leccion = $datos[0]['leccion'];
				$nivel = $datos[0]['nivel'];
				$modulo = $datos[0]['modulo'];
			}

			if ($continuaRegistro) {
				$nombreModulo = (new Administrador())->modulos($nivel_asignado);
				// print_r($nombreModulo);
				$this->renderJSON(array("error" => "Este alumno no puede ser asignado al grupo '".$grupos[0]['LGF0290002']."' , este grupo esta asignado a ".$nombreModulo[0]['nombre']));
			}

			if ($perfil == 6) {
				$grupo = "";
				$data = (new Administrador())->leccion_modulo($_POST['modulo']);
				$dataN = (new Administrador())->modulos($_POST['modulo']);
				$leccion = $data[0]['id'];
				$nivel = $dataN[0]['nivel'];
				$modulo = $_POST['modulo'];
			}
			$data = array(
				'LGF0010002' => $nombre,
				'LGF0010003' => $aPaterno,
				'LGF0010004' => $aMaterno,
				'LGF0010005' => $usuario,
				'LGF0010006' => $password,
				'LGF0010038' => $institucion,
				'LGF0010007' => $perfil,
				'LGF0010008' => $estatus,
				"LGF0010009" => $this->archivo_base64('foto'),
				'LGF0010012' => $email,
				"LGF0010021" => $genero,
				'LGF0010022' => empty($fNacimiento) || $fNacimiento == '' ? null : $fNacimiento,
				"LGF0010023" => $nivel,
				"LGF0010024" => $modulo,
				"LGF0010025" => $leccion,
				"LGF0010026" => 1,
				'LGF0010030' => date('Y-m-d H:i:s'),
				'LGF0010031' => $this->userid,
				"LGF0010039" => empty($grupo) || $grupo == '' ? null: $grupo,
				'LGF0010040' => $curp,
			);
			// echo "<pre>";
			// echo "</pre>";
			$check = $this->validarLicenciasRegistradas($institucion);
			if ($check == 1) {
				// echo "1)\n";
				// $this->renderJSON(array("success" => $check));
				$respuesta = (new Usuarios())->agregarUsuario((object) $data);
				if ($respuesta) {
					$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$_POST['pass'], "LGF0330003"=>$perfil);
					$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					// echo "Insert";
					$this->renderJSON(array("mensaje" => "Usuario registrado exitosamente."));
				} else {
					// echo "Fail";
					$this->renderJSON(array("error" => "Ha ocurrido un error al registrar la información del usuario."));
				}
			} else if ($check == 2) {
				// echo "2)\n";
				$this->renderJSON(array("error" => "Ya no tienes licencias para poder registrar más usuarios."));
			} else {
				$this->renderJSON(array("error" => "Esta institución no tienen ninguna licencia contratada."));
			}
		}

		public function updateUsuario() {
			$institucion = $_POST['institucion'];
			$perfil = $_POST['perfil'];
			$nombre = $_POST['nombre'];
			$aPaterno = $_POST['aPaterno'];
			$aMaterno = $_POST['aMaterno'];
			$fNacimiento = $_POST['fNacimiento'];
			$curp = $_POST['curp'];
			$genero = $_POST['genero'];
			$email = $_POST['email'];
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			$estatus = $_POST['estatus'];


			$grupo = $_POST['grupo']; // Pendiente
			$id = $_POST['id'];

			$check = (new Administrador())->check_matricula($curp);
			if (!empty($check)) {
				if ($check[0]['LGF0010001'] != $id) {
					$this->renderJSON(array("error" => "Ya existe un usuario con este CURP registrado"));
				}
			}

			// Campos nuevos
			$continuaRegistro = false;
			if ($perfil == 2) {
				if (!empty($_POST['leccion'])) {
					$aux = explode("_", $_POST['leccion']);
					$leccion = $aux[0];
					$nivel = $aux[1];
					$modulo = $_POST['nivel'];

					$grupos = (new Administrador())->grupos($grupo);
					// print_r($grupos);
					$nivel_asignado = $grupos[0]['LGF0290005'];
					// echo $nivel_asignado." ".$modulo."<br>";
					if ($modulo != $nivel_asignado) {
						$continuaRegistro = true;
					}
				}
			} else {
				$datos = (new Administrador())->obtener_niveles();
				$leccion = $datos[0]['leccion'];
				$nivel = $datos[0]['nivel'];
				$modulo = $datos[0]['modulo'];
			}

			$datos = (new Administrador())->informacion_usuario($id);
			if ($nivel == "") {
				$nivel = $datos[0]['LGF0010023'];
			}
			if ($leccion == "") {
				$leccion = $datos[0]['LGF0010025'];
			}
			if ($modulo == "") {
				$modulo = $datos[0]['LGF0010024'];
			}
			$seccion = $datos[0]['LGF0010026'];
			if ($perfil == 6) {
				$grupo = "";
			}

			if ($continuaRegistro) {
				$nombreModulo = (new Administrador())->modulos($nivel_asignado);
				// print_r($nombreModulo);
				$this->renderJSON(array("error" => "Este alumno no puede ser asignado al grupo '".$grupos[0]['LGF0290002']."' , este grupo esta asignado a ".$nombreModulo[0]['nombre']));
			}

			$data = array(
				'LGF0010038' => $institucion,
				'LGF0010007' => $perfil,
				'LGF0010002' => $nombre,
				'LGF0010003' => $aPaterno,
				'LGF0010004' => $aMaterno,
				'LGF0010022' => $fNacimiento,
				'LGF0010012' => $email,
				'LGF0010005' => $usuario,
				'LGF0010008' => $estatus,
				'LGF0010032' => date('Y-m-d H:i:s'),
				"LGF0010009" => $this->archivo_base64('foto'),
				'LGF0010033' => $this->userid,
				"LGF0010039" => $grupo,
				"LGF0010021" => $genero,
				"LGF0010023" => $nivel,
				"LGF0010024" => $modulo,
				"LGF0010025" => $leccion,
				"LGF0010026" => $seccion
			);

			if (!empty($password)) {
				$data['LGF0010006'] = $password;
			}

			$respuesta = (new Usuarios())->actualizarUsuario((object) $data, (object) array (
				"LGF0010001" => $id
			));
			if ($respuesta) {
				if (!empty($password)) {
					$checkPassUser = (new Administrador())->checkPassUser($id, $perfil);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$id,"LGF0330002"=>$_POST['pass'], "LGF0330003"=>$perfil);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330002"=>$_POST['pass']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$id, "LGF0330003"=>$perfil
						));
					}
				}
				$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al actualizar la Información del usuario."));
			}
		}

		public function deleteUsuario() {
			// echo "ID recibido: ".$_POST['id'];
			$estatus['LGF0010008'] = 0;
			$respuesta = (new Usuarios())->actualizarUsuario((object) $estatus, (object) array (
				"LGF0010001" => $_POST['id']
			));

			if ($respuesta) {
				$this->renderJSON(array("mensaje" => "Usuario eliminado exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al eliminar el registro, inténtelo de nuevo."));
			}
		}

		/**
		 * Clientes
		 */
		public function saveCliente() {
			$nombre = $_POST['nombre'];
			$contacto = $_POST['contacto'];
			$email = $_POST['email'];
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			$telefono = $_POST['telefono'];
			$direccion = $_POST['direccion'];
			$pais = $_POST['pais'];

			$data = array(
				'LGF0280002' => $nombre,
				'LGF0280017' => $contacto,
				'LGF0280018' => $email,
				'LGF0280019' => $usuario,
				'LGF0280020' => $password,
				'LGF0280021' => $telefono,
				'LGF0280003' => $direccion,
				'LGF0280011' => date('Y-m-d H:i:s'),
				'LGF0280010' => 1,
				'LGF0280014' => $this->userid,
				'LGF0280022' => 3 // ID Cliente
			);

			// print_r($data);

			$respuesta = (new Clientes())->addCliente((object) $data);
			// echo "Respuesta: "; print_r($respuesta);
			if ($respuesta) {
				$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$_POST['pass'], "LGF0330003"=>3);
				$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
				$this->renderJSON(array("mensaje" => "Cliente registrado exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al registrar la información del cliente."));
			}
		}

		public function updateCliente() {
			$nombre = $_POST['nombre'];
			$contacto = $_POST['contacto'];
			$email = $_POST['email'];
			$usuario = $_POST['usuario'];
			$password = $_POST['password'];
			$telefono = $_POST['telefono'];
			$direccion = $_POST['direccion'];
			$pais = $_POST['pais'];

			$data = array(
				'LGF0280002' => $nombre,
				'LGF0280017' => $contacto,
				'LGF0280018' => $email,
				'LGF0280019' => $usuario,
				'LGF0280021' => $telefono,
				'LGF0280003' => $direccion,
				'LGF0280012' => date('Y-m-d H:i:s'),
				'LGF0280015' => $this->userid,
				'LGF0280022' => 3 // ID Cliente
			);

			if (!empty($password)) {
				$data['LGF0280020'] = $password;
			}

			$respuesta = (new Clientes())->actualizar((object) $data, (object) array (
				"LGF0280001" => $_POST['id']
			));
			if ($respuesta) {
				if (!empty($password)) {
					$checkPassUser = (new Administrador())->checkPassUser($_POST['id'], 3);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$_POST['id'],"LGF0330002"=>$_POST['pass'], "LGF0330003"=>3);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330002"=>$_POST['pass']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$_POST['id'], "LGF0330003"=>3
						));
					}
				}
				$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al actualizar la Información del cliente."));
			}
		}

		public function deleteCliente() {
			// echo "ID recibido: ".$_POST['id'];
			$estatus['LGF0280010'] = 0;
			$respuesta = (new Clientes())->actualizar((object) $estatus, (object) array (
				"LGF0280001" => $_POST['id']
			));

			if ($respuesta) {
				$this->renderJSON(array("mensaje" => "Cliente eliminado exitosamente."));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al eliminar el registro, inténtelo de nuevo."));
			}
		}

        /** Retorna segin el caso los tiempos o licencias activas-inactivas por grafica solicitada
         * @return void
         */
        public function datosIntervalosFechasTiempos(){
            $fec_inicio = $_POST['fec_inicio'];
            $fec_fin    = $_POST['fec_fin'];
            $tipo = $_POST['tipo'];

            if($tipo == 'total'){
                /*Retornara los minutos que han empleado el sistema en los periodos de tiempo y perfil indicado como 1 parametro*/
                $dato1 = (new EstadisticasCliente())->tiempo_conexion_acumulado(2, $fec_inicio, $fec_fin)[0]['tiempo'];
                ##############################################################
                $dato2 = (new EstadisticasCliente())->tiempo_conexion_acumulado(6, $fec_inicio, $fec_fin)[0]['tiempo'];
            }elseif($tipo == 'licencias'){
                /*Retornara la cantidad de licencias activas-inactivas de usuarios y docentes*/
                $alumnos_activos = (new EstadisticasCliente())->estadisticasPorFecha_Alm_Doc(2, $fec_inicio, $fec_fin);
                $docentes_activos = (new EstadisticasCliente())->estadisticasPorFecha_Alm_Doc(6, $fec_inicio, $fec_fin);

                $dato1 = 0;
                $dato2 = 0;
                foreach ($docentes_activos as $key => $docente) {
                        $dato1 += $docente['T_activos'] + $alumnos_activos[$key]['T_activos'];
                        $dato2 += ($docente['T_registrados'] - $docente['T_activos']);
                        $dato2 += ($alumnos_activos[$key]['T_registrados'] -  + $alumnos_activos[$key]['T_activos']);
                }
            }

            $this->renderJSON(array(
                #Alumnos tiempo - Lic activas
                "dato1" => $dato1,
                #Docentes tiempo - Lic inactivas
                "dato2" => $dato2
            ));
        }


        public function obtenerestadisticacliente(){
            $cliente = $_POST['cliente'];
            $tabla = "";

            $data = (new EstadisticasCliente())->obtenerEstadisticasCliente((object) array (
                "LGF0460002" => $cliente
            ));

            if(count($data) > 0){
                foreach ($data as $registro){
                    $tabla .=
                        '<tr>                                                  
                            <td>'.$registro['LGF0460003'].'</td>                       
                            <td>'.$registro['LGF0460004'].'</td>                       
                            <td>'.$registro['LGF0460005'].'</td>                       
                            <td>
                                <a href="'.CONTEXT.'admin/estadisticacliente/'.$registro['LGF0460001'].'" target="_blank" class="mb-2">Ver análisis</a>
                                <hr>
                                <button class="eliminarRegistroCliente" registro="'.$registro['LGF0460001'].'">
                                    Eliminar registro
                                </button>
                            </td>                       
                        </tr>';
                }
            }


            if ($tabla != "") {
                $this->renderJSON(array("tabla" => $tabla, 'cantidad' => 1));
            } else {
                $tabla =
                    "<tr>
                        <td colspan='4'>Sin registros</td>                       
                    </tr>";
                $this->renderJSON(array("tabla" => $tabla, 'cantidad' => 0));
            }

        }
        public function asignarestadisticacliente(){
            $cliente    = $_POST['cliente'];
            $licencias  = $_POST['licencias'];
            $fec_inicio = $_POST['fec_inicio'];
            $fec_fin    = $_POST['fec_fin'];

            $data = array(
                'LGF0460002' => $cliente,
                'LGF0460003' => $licencias,
                'LGF0460004' => $fec_inicio,
                'LGF0460005' => $fec_fin
            );

            $respuesta = (new EstadisticasCliente())->crearEstadisticasCliente((object) $data);

            if ($respuesta) {
                $this->renderJSON(array("mensaje" => "Estadistica creada correctamente"));
            } else {
                $this->renderJSON(array("error" => "Ha ocurrido un error al registrar la información del cliente."));
            }

        }
        public function eliminarestadisticacliente(){
            $id    = $_POST['id'];

            $data = array(
                'LGF0460001' => $id
            );

            $respuesta = (new EstadisticasCliente())->eliminaEstadisticasCliente((object) $data);

            if ($respuesta) {
                $this->renderJSON(array("mensaje" => "Estadistica eliminada correctamente"));
            } else {
                $this->renderJSON(array("error" => "Ha ocurrido un error al eliminar la información del cliente."));
            }

        }


		/**
		 * Grupos
		 */
		public function saveGrupo() {
			$nombre = $_POST['grupo'];
			$institucion = $_POST['institucion'];
			$docente = $_POST['docente'];
			// Campo nuevo
			$nivel = $_POST['nivel'];
			$ciclo = $_POST['ciclo'];

			if (empty($_POST['idgrupo'])) {
				$data = array(
					"LGF0290002" => $nombre,
					"LGF0290004" => $institucion,
					"LGF0290006" => empty($docente) ? null: $docente,
					"LGF0290003" => 1,
					"LGF0290005" => empty($nivel) ? null: $nivel,
					"LGF0290007" => empty($ciclo) ? null: $ciclo,
				);

				$respuesta = (new Grupos())->addGrupo((object) $data);
				if ($respuesta) {
					$this->renderJSON(array("mensaje" => "Grupo creado correctamente"));
				} else {
					$this->renderJSON(array("error" => "Ha ocurrido un error al registrar la información del grupo."));
				}
			} else {
				$data = array(
					"LGF0290002" => $nombre,
					"LGF0290006" => $docente,
					"LGF0290004" => $institucion,
					"LGF0290005" => $nivel,
					"LGF0290007" => $ciclo
				);

				$respuesta = (new Grupos())->updateGrupo((object) $data, (object) array (
					"LGF0290001" => $_POST['idgrupo']
				));
				if ($respuesta) {
					$this->renderJSON(array("mensaje" => "Información actualizada correctamente"));
				} else {
					$this->renderJSON(array("error" => "Ha ocurrido un error al actualizar la información del grupo."));
				}
			}
		}

		public function eliminarGrupo() {
			$data = array(
				"LGF0290003" => 0
			);
			$respuesta = (new Grupos())->updateGrupo((object) $data, (object) array (
				"LGF0290001" => $_POST['id']
			));
			if ($respuesta) {
				$this->renderJSON(array("mensaje" => "Grupo eliminado correctamente"));
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al eliminar el grupo."));
			}
		}

		public function informacionGrupos() {
			$id = $_POST['id'];
			$grupo = (new Administrador())->informacionGrupo($id);
			$this->renderJSON(array("info" => $grupo));
		}

		/**
		 * Modulos
		 */
		public function accionModulos() {
			$accion = $_POST['accion'];
			switch ($accion) {
				case 'registro':
					$data = array("LGF0300002"=>$_POST['institucion'], "LGF0300003" => $_POST['modulo']);
					$modulo_institucion = (new ModuloInstitucion())->addModuloInst((object) $data);
					if ($modulo_institucion) {
						$this->renderJSON(array("mensaje" => "Modulo registrado"));
					} else {
						$this->renderJSON(array("error" => "Ha ocurrido un error"));
					}
				break;
				case 'eliminar':
					$modulo_institucion = (new ModuloInstitucion())->eliminaModulo((object) array (
						"LGF0300001" => $_POST['clave']
					));
					if ($modulo_institucion) {
						$this->renderJSON(array("mensaje" => "Modulo eliminado"));
					} else {
						$this->renderJSON(array("error" => "Ha ocurrido un error"));
					}
				break;
			}
		}

		public function mostrar_resultados() {
			$seccion = $_POST['seccion']; // [1]Evaluaciones [2] Habilidades
			$opcion = $_POST['opcion']; // [1] Institucion [2] Grupos [3] Alumnos
			$institucion = $_POST['institucion'];
			$cliente = $_POST['cliente'];
			$fecha = $_POST['fecha'];
			/*foreach ($_POST as $key => $value) {
				echo $key."  => ".$value."\n\n";
			}
			die();*/
			switch ($opcion) {
				case '1':
					if ($seccion == 1) {
						$this->resultados_evaluaciones($opcion, $institucion, $cliente, $fecha);
					} else {
						$this->resultados_habilidades($opcion, $institucion, $cliente, $fecha);
					}
				break;
				case '2':
					if ($seccion == 1) {
						$this->resultados_evaluaciones($opcion, $institucion, $cliente, $fecha);
					} else {
						$this->resultados_habilidades($opcion, $institucion, $cliente, $fecha);
					}
				break;
				case '3':
					if ($seccion == 1) {
						$this->resultados_evaluaciones($opcion, $institucion, $cliente, $fecha);
					} else {
						$this->resultados_habilidades($opcion, $institucion, $cliente, $fecha);
					}
				break;
			}
		}

		public function resultados_evaluaciones($opcion, $institucion, $cliente, $fecha) {
			$modulos = (new Administrador())->obtener_modulos();
			$lecciones = (new Administrador())->obtenerMaxLecciones();

			$result = (new Administrador())->resultados_evaluaciones_admin($lecciones[0]['num'], $opcion, $institucion, $cliente);
			/*echo "<pre>";
			print_r($result);
			echo "</pre>";*/
			$array = array();
			foreach ($result as $key => $value) {
				if ($opcion == 3) {
					$nombre = $value['LGF0010002']." ".$value['LGF0010003']." ".$value['LGF0010004'];
					$array[] = array(
						"id" => $value['id'],
						"nombre" => $nombre,
						"nivel" => $value['nivel'],
						"grupo" => $value['grupo']
					);
				} else {
					$nombre = $value['nombre'];
					$array[] = array(
						"id" => $value['id'],
						"nombre" => $nombre,
						"nivel" => $value['nivel'],
						"totalAlumnos" => $value['totalAlumnos']
					);
				}
				
			}

			$total = "";
			foreach ($result as $key => $value) {
				for ($i=1; $i <= $lecciones[0]['num']; $i++) { 
					$posicion = 0;
					
					$suma = (new Administrador())->obtener_promedios($i, $opcion, $value['id'], $fecha);

					if ($suma[0]["promL".$i] != "") {
						$promedio = round($suma[0]["promL".$i] / $suma[0]['total']);
					} else {
						$promedio = "N/A";
					}
					if ($i==1) {
						$total = $promedio;
					} else {
						$total.= "|".$promedio;
					}
					if ($suma[0]['id'] == $value['id']) {
						$array[$key]['promedio'] = $total;
					}
				}
				$array[$key]['promedio'] = $total;
			}
			
			$tabla = "";
			if (!empty($array)) {
				$error = 0;
				$color = "#fff";
				
				foreach ($array as $key => $res) {
					$aux = explode("|", $res['promedio']);
					if ($res['nivel'] == 1) {
						$fondo = "#7e3e98";
					} else if ($res['nivel'] == 2) {
						$fondo = "#2dbeba";
					} else if ($res['nivel'] == 3) {
						$fondo = "#0b70b7";
					} else {
						$fondo = "#ccc";
					}
					if ($opcion == 3) {
						// echo "Cont: ".$cont." --- modulo: ".$res[$cont][0]['modulo']."<br>";
						$tabla.="<tr><td style='background-color: ".$fondo."; color: ".$color.";'>".$res['nombre']."</td><td style='background-color: ".$fondo."; color: ".$color.";'>".$res['grupo']."</td>";
					} else {
						// echo "Cont: ".$cont." --- modulo: ".$res[$cont][0]['modulo']."<br>";
						$tabla.="<tr><td style='background-color: ".$fondo."; color: ".$color.";'>".$res['nombre']."</td><td style='background-color: ".$fondo."; color: ".$color.";'>".$res['totalAlumnos']."</td>";
					}

					$promedio = 0;
					$contador1 = 0;
					$suma = 0;
					for ($i=0; $i < count($aux); $i++) { 
						$tabla.="<td>".$aux[$i]."</td>";
						$suma = $suma + $aux[$i];
						if ($aux[$i] != 0) {
							$contador1++;
						}
					}
					if ($contador1 == 0) {
						$contador1 = $lecciones[0]['num'];
					}
					// echo "contador[".$res[$cont][0]['id']."]: (".$promedio.") ".$contador1."\n";
					$promedioL = round($suma / $contador1);

					if ($promedio == "") {
						$promedio = "S/P";
					}
					$tabla.="<td style='background-color: ".$fondo."; color: ".$color."; text-align: center;'>".$promedioL."</td>";
					$tabla.="</tr>";
				}
			} else {
				$error = 1;
				$tabla = "<tr>";
				for ($i=1; $i <= ($lecciones[0]['num'] + 3); $i++) { 
					$tabla.="<td>-----</td>";
				}
				$tabla.="</tr>";
			}
			$this->renderJSON(array("error"=>$error, "contenido"=>$tabla));
		}

		public function resultados_habilidades($opcion, $institucion, $cliente, $fecha) {
			$result = (new Administrador())->resultados_habilidades($opcion, $institucion, $cliente, $fecha);
			$columnas = "";
			if (!empty($result)) {
				$error = 0;
				if ($opcion == 3) { // por alumno
					$cont = 0;
					foreach ($result as $res) {
						$alumno = $res['LGF0010001']." ".$res['LGF0010002']." ".$res['LGF0010003'];
						if (empty($alumno)) {
							$alumno = "----";
						} 
						if (empty($res['grupo'])) {
							$grupo = "----";
						} else {
							$grupo = $res['grupo'];
						}
						if (empty($res['vocabulary'])) {
							$vocabulary = 0;
						} else {
							$vocabulary = round($res['vocabulary']);
							$cont++;
						}
						if (empty($res['grammar'])) {
							$grammar = 0;
						} else {
							$grammar = round($res['grammar']);
							$cont++;
						}
						if (empty($res['reading'])) {
							$reading = 0;
						} else {
							$reading = round($res['reading']);
							$cont++;
						}
						if (empty($res['listening'])) {
							$listening = 0;
						} else {
							$listening = round($res['listening']);
							$cont++;
						}
						if (empty($res['speaking'])) {
							$speaking = 0;
						} else {
							$speaking = round($res['speaking']);
							$cont++;
						}
						// $listening = 0;
						if ($cont > 0) {
							$total = ($vocabulary+$grammar+$reading+$listening+$speaking)/$cont;
						} else {
							$total = 0;
						}
						
						$columnas.="<tr><td><a href='#' onclick='reporteDetail(".$res['ID'].");'>".$alumno."</a></td><td>".$grupo."</td><td>".$vocabulary." %</td><td>".$grammar." %</td><td>".$reading." %</td><td>".$listening." %</td><td>".$speaking." %</td><td>".round($total)." %</td></tr>";
					}
				} else {
					$cont = 0;
					foreach ($result as $res) {
						$nombre = $res['nombre'];
						$totalAlumnos = $res['totalAlumnos'];
						
						if (empty($res['vocabulary'])) {
							$vocabulary = 0;
						} else {
							$vocabulary = round($res['vocabulary']);
							$cont++;
						}
						if (empty($res['grammar'])) {
							$grammar = 0;
						} else {
							$grammar = round($res['grammar']);
							$cont++;
						}
						if (empty($res['reading'])) {
							$reading = 0;
						} else {
							$reading = round($res['reading']);
							$cont++;
						}
						if (empty($res['listening'])) {
							$listening = 0;
						} else {
							$listening = round($res['listening']);
							$cont++;
						}
						if (empty($res['speaking'])) {
							$speaking = 0;
						} else {
							$speaking = round($res['speaking']);
							$cont++;
						}
						// $listening = 0;
						if ($cont > 0) {
							$total = ($vocabulary+$grammar+$reading+$listening)/$cont;
						} else {
							$total = 0;
						}
						$columnas.="<tr><td>".$nombre."</td><td>".$totalAlumnos."</td><td>".$vocabulary." %</td><td>".$grammar." %</td><td>".$reading." %</td><td>".$listening." %</td><td>".$speaking." %</td><td>".round($total)." %</td></tr>";
					}
				}
			} else {
				$error = 1;
				$columnas.="<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
			}
			$this->renderJSON(array("contenido"=>$columnas, "error"=>$error));
		}

		public function estadisticasCalificaciones() {
			$id = $_POST['clave'];
			$this->temp['modulos'] = (new Administrador())->obtener_lecciones();
			$this->temp['informacion'] = (new Administrador())->obtener_usuario($id);
			$nombre = $this->temp['informacion'][0]['LGF0010002']." ".$this->temp['informacion'][0]['LGF0010003']." ".$this->temp['informacion'][0]['LGF0010004'];
			$grupo = $this->temp['informacion'][0]['grupo'];
			$foto = $this->temp['informacion'][0]['foto'];
			if (empty($grupo)) {
				$grupo = "N/A";
			}
			if (empty($foto)) {
				$foto = IMG."default.png";
			}
			foreach ($this->temp['modulos'] as $modulo) {
				$data[] = array(
					'id' => $modulo['id'],
					'nombre' => $nombre,
					'grupo' => $grupo,
					'modulo' => $modulo['modulo'],
					'totalmodulos' => $modulo['totalmodulos'],
					'lecciones' => (new Administrador())->lecciones($modulo['id'])
				);
			}
			$avance = (new Administrador())->avance_modulo($id);
			$columnas = $data;
			/*echo "<pre>";
			print_r($avance['modulo2']);
			echo "</pre>";*/
			$tabla = "<table class='table reporte_tabla'><tbody><tr><th>Alumno</th></tr><tr><td><img src='".$foto."' id='imagenPerfil' alt='' style='width: 15%;float: left;margin-left: 100px;'><span style='font-weight: bold;font-size: 30px;' id='nombre'>".$columnas[0]['nombre']."<br><span style='font-weight: bold; font-size: 30px;' id='grupo'>Grupo: ".$columnas[0]['grupo']."</span></td></tr></tbody></table>";
			$tabla.= "<table class='table reporte_tabla'><tr><th colspan=40>Evaluaciones (Lección/Porcentaje)</th></tr><tr><th>Gramática 1</th>";
				$cont = 0;
				for ($i=1; $i <=$columnas[0]['totalmodulos']; $i++) {
					$clase = "";
					$porcentaje = "";
					for ($j=0; $j <count($avance['modulo1']) ; $j++) { 
						if ($cont == 0) {
							$clase.="class='relleno'";
						}
						if ($columnas[0]['lecciones'][$cont]['ids'] <= $avance['modulo1'][$j]['leccion']) {
							// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
							$clase.="class='relleno'";
						} else {
							$clase.="";
						}

						if ($columnas[0]['lecciones'][$cont]['ids'] == $avance['modulo1'][$j]['leccion']) {
							$porcentaje.= "<br>".$avance['modulo1'][$j]['porcentaje'];
						} else {
							$porcentaje.= "";
						}
					}
					// $tabla.="<td>".$i."</td>";
					$tabla.="<td ".$clase.">".$i.$porcentaje."</td>";
					$cont++;
				}
			$tabla.="</tr><tr><th>Gramática 2</th>";
				$clase = '';
				$cont = 0;
				for ($i=1; $i <=$columnas[1]['totalmodulos']; $i++) {
					$clase = "";
					$porcentaje = "";
					for ($j=0; $j <count($avance['modulo2']) ; $j++) {
						if ($cont == 0) {
							$clase.="class='relleno'";
						}
						if ($columnas[1]['lecciones'][$cont]['ids'] <= $avance['modulo2'][$j]['leccion']) {
							// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
							$clase.="class='relleno'";
						} else {
							$clase.="";
						}

						if ($columnas[1]['lecciones'][$cont]['ids'] == $avance['modulo2'][$j]['leccion']) {
							$porcentaje.= "<br>".$avance['modulo2'][$j]['porcentaje'];
						} else {
							$porcentaje.= "";
						}
					}
					// $tabla.="<td>".$i."</td>";
					$tabla.="<td ".$clase.">".$i.$porcentaje."</td>";
					$cont++;
				}
			$tabla.="</tr><tr><th>Servicios</th>";
				$clase = '';
				$cont = 0;
				for ($i=1; $i <=$columnas[2]['totalmodulos']; $i++) {
					$clase = "";
					$porcentaje = "";
					for ($j=0; $j <count($avance['modulo3']) ; $j++) { 
						if ($cont == 0) {
							$clase.="class='relleno'";
						}
						if ($columnas[2]['lecciones'][$cont]['ids'] <= $avance['modulo3'][$j]['leccion']) {
							// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
							$clase.="class='relleno'";
						} else {
							$clase.="";
						}

						if ($columnas[2]['lecciones'][$cont]['ids'] == $avance['modulo3'][$j]['leccion']) {
							$porcentaje.= "<br>".$avance['modulo3'][$j]['porcentaje'];
						} else {
							$porcentaje.= "";
						}
					}
					// $tabla.="<td>".$i."</td>";
					$tabla.="<td ".$clase.">".$i.$porcentaje."</td>";
					$cont++;
				}
			$tabla.="</tr><tr><th>Profesional</th>";
				$clase = '';
				$cont = 0;
				for ($i=1; $i <=$columnas[3]['totalmodulos']; $i++) {
					$clase = "";
					$porcentaje = "";
					for ($j=0; $j <count($avance['modulo4']) ; $j++) {
						if ($cont == 0) {
							$clase.="class='relleno'";
						}
						if ($columnas[3]['lecciones'][$cont]['ids'] <= $avance['modulo4'][$j]['leccion']) {
							// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
							$clase.="class='relleno'";
						} else {
							$clase.="";
						}

						if ($columnas[3]['lecciones'][$cont]['ids'] == $avance['modulo4'][$j]['leccion']) {
							$porcentaje.= "<br>".$avance['modulo4'][$j]['porcentaje'];
						} else {
							$porcentaje.= "";
						}
					}
					// $tabla.="<td>".$i."</td>";
					$tabla.="<td ".$clase.">".$i.$porcentaje."</td>";
					$cont++;
				}
			$tabla.="</tr><tr><th>Turismo</th>";
				$clase = '';
				$cont = 0;
				for ($i=1; $i <=$columnas[4]['totalmodulos']; $i++) {
					$clase = "";
					$porcentaje = "";
					for ($j=0; $j <count($avance['modulo5']) ; $j++) {
						if ($cont == 0) {
							$clase.="class='relleno'";
						}
						if ($columnas[4]['lecciones'][$cont]['ids'] <= $avance['modulo5'][$j]['leccion']) {
							// echo $columnas[0]['lecciones'][$i]['ids']." -> ".$avance['modulo1'][$j]['leccion']."<br>";
							$clase.="class='relleno'";
						} else {
							$clase.="";
						}

						if ($columnas[4]['lecciones'][$cont]['ids'] == $avance['modulo5'][$j]['leccion']) {
							$porcentaje.= "<br>".$avance['modulo5'][$j]['porcentaje'];
						} else {
							$porcentaje.= "";
						}
					}
					// $tabla.="<td>".$i."</td>";
					$tabla.="<td ".$clase.">".$i.$porcentaje."</td>";
					$cont++;
				}
			$tabla.="</tr></table>";
			$this->renderJSON(array("contenido"=>$tabla));
		}

		public function habilidades_alumno() {
			$idAlumno = $_POST['clave'];
			$result = (new Administrador())->habilidades_alumno($idAlumno);
			if (empty($result[0]['grupo'])) {
				$grupo = "N/A";
			} else {
				$grupo = $result[0]['grupo'];
			}
			if (empty($result[0]['foto'])) {
				$foto = IMG."default.png";
			} else {
				$foto = $result[0]['foto'];
			}

			$vocabulary = round($result[0]['vocabulary']);
			$grammar = round($result[0]['grammar']);
			$reading = round($result[0]['reading']);
			$listening = round($result[0]['listening']);
			$speaking = round($result[0]['speaking']);
			$total = ($vocabulary+$grammar+$reading+$listening+$speaking)/4;

			$informacion = array(
				"alumno"=> $result[0]['LGF0010002']." ".$result[0]['LGF0010003']." ".$result[0]['LGF0010004'],
				"grupo" => $grupo,
				"foto" => $foto,
				"vocabulary" => $vocabulary,
				"grammar" => $grammar,
				"reading" => $reading,
				"listening" => $listening,
				"speaking" => $speaking,
				"total" => $total
			);
			$this->renderJSON(array("contenido"=>$informacion));
		}

		/**
		 * Objetos
		 */
		public function obtenerLecciones() {
			$modulo = $_POST['clave'];
			$lecciones = (new Administrador())->leccion_modulo($modulo);
			$contenido = "<option value=''>Selecciona una lección</option>";
			foreach ($lecciones as $leccion) {
				$contenido.="<option value='".$leccion['id']."'>".$leccion['nombre']."</option>";
			}
			$this->renderJSON(array("contenido"=>$contenido));
		}

		public function mostrarEvaluaciones() {
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];

			$respuesta = (new Administrador())->mostrarEvaluaciones($modulo, $leccion);
			$tabla = "";
			if (count($respuesta) > 0) {
				foreach ($respuesta as $resp) {
					if ($resp['estatus'] == 1) {
						$estatus = "Activa";
						$texto = "Desactivar";
						$icono = "fa fa-lock";
						$accion = "eliminar(".$resp['idEvaluacion'].")'";
						$estilo ="";
					} else {
						$estatus = "Inactiva";
						$texto = "Activar";
						$icono = "fa fa-unlock";
						$accion = "activar(".$resp['idEvaluacion'].")'";
						$estilo = "style='font-weight: bold; color: #ff0000;'";
					}
					$tabla.="<tr><td>".$resp['nombre_evaluacion']."</td><td>".$resp['modulo']."</td><td>".$resp['leccion']."</td><td>".$resp['numero_preguntas']."</td><td>".$resp['fecha']."</td><td ".$estilo.">".$estatus."</td><td><span><a href=".CONTEXT."admin/editEvaluacion/".$resp['idEvaluacion']."><i class='fa fa-pencil' aria-hidden='true'></i> Editar</a></span>  <span><a href='#' onclick='".$accion."'><i class='".$icono."' aria-hidden='true'></i> ".$texto."</a></span>  <span><a href='".CONTEXT."admin/mostrarPreguntas/".$resp['idEvaluacion']."'><i class='fa fa-question' aria-hidden='true'></i> Preguntas</a></span></td></tr>";
				}
			} else {
				$tabla.="<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
			}
			$this->renderJSON(array("contenido"=>$tabla));
		}

		public function verificarevaluacion() {
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];
			// echo "recibido: ".$modulo." ".$leccion;

			$check = (new Administrador())->check_evaluacion($modulo, $leccion);
			if (empty($check)) {
				$this->renderJSON(array("mensaje"=>false));
			} else {
				$enlace = '';
				$cont = 0;
				foreach ($check as $k) {
					$links[] = array("url"=>CONTEXT."admin/editEvaluacion/".$k['id'], "nombre"=>$k['nombre']);
				}
				$this->renderJSON(array("mensaje"=>true, "urls"=>$links));
			}
		}

		public function saveAddEvaluacion() {
			$nombre = $_POST['nombre'];
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];
			$preguntas = $_POST['preguntas'];
			// $estatus = $_POST['estatus'];
			$estatus = 0;
			$tipo = $_POST['tipo'];
			
			$check = (new Administrador())->check_evaluacion($modulo, $leccion);
			if (empty($check)) {
				$nivel = (new Administrador())->obtener_nivel_modulo($modulo);
				$tipo = 1;

				$data = array(
					'LGF0190002' => addslashes($nombre),
					'LGF0190004' => $tipo,
					'LGF0190005' => $nivel[0]['nivel'],
					'LGF0190006' => $modulo,
					'LGF0190007' => $leccion,
					'LGF0190010' => $estatus,
					'LGF0190011' => $preguntas,
					'LGF0190014' => date('Y-m-d H:i:s'),
					"LGF0190015" => $this->userid
				);

				$respuesta = (new Evaluacion())->agregarEvaluacion((object) $data);
				if ($respuesta) {
					$this->renderJSON(array("mensaje" => "Evaluacion registrada exitosamente."));
				} else {
					$this->renderJSON(array("error" => "Ha ocurrido un error al registrar la evaluación."));
				}
			} else {
				$nombres = (new Administrador())->mostrarEvaluaciones($modulo, $leccion);

				$enlace = '';
				$cont = 0;
				$texto = '';
				foreach ($check as $k) {
					if ($cont == 0) {
						$texto = 'tiene registrada la siguiente evaluación<br>';
						$enlace.='<strong><a href="'.CONTEXT."admin/editEvaluacion/".$k['id'].'">'.$k['nombre'].'</a></strong>';
					} else {
						$texto = 'tienen registradas las siguientes evaluaciones: <br>';
						$enlace.=', <strong><a href="'.CONTEXT."admin/editEvaluacion/".$k['id'].'">'.$k['nombre'].'</a></strong>';
					}
					$cont++;
				}
				$this->renderJSON(array("error" => "El módulo <b>".$nombres[0]['modulo']."</b> y la lección <b>".$nombres[0]['leccion']."</b> ".$texto.$enlace));
			}
		}

		public function upEvaluacion() {
			$idEvaluacion = $_POST['evaluacion'];
			$nombre = $_POST['nombre'];
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];
			$preguntas = $_POST['preguntas'];
			$estatus = $_POST['estatus'];
			$tipo = $_POST['tipo'];
			$nivel = (new Administrador())->obtener_nivel_modulo($modulo);
			$tipo = 1;

			$evaluacion_anterior = (new Evaluacion())->obtenEvaluacion((object) array (
				"LGF0190001" => $idEvaluacion
			));

			$data = array(
				'LGF0190002' => addslashes($nombre),
				'LGF0190004' => $tipo,
				'LGF0190005' => $nivel[0]['nivel'],
				'LGF0190006' => $modulo,
				'LGF0190007' => $leccion,
				'LGF0190010' => $estatus,
				'LGF0190011' => $preguntas,
				'LGF0190018' => date('Y-m-d H:i:s'),
				"LGF0190019" => $this->userid
			);

			$respuesta = (new Evaluacion())->actualizarEvaluacion((object) $data, (object) array (
				"LGF0190001" => $idEvaluacion
			));

			if ($respuesta) {
				$check_preguntas = (new Administrador())->check_preguntas($idEvaluacion);
				if ($check_preguntas[0]['total'] == 0) {
					$this->renderJSON(array("error" => "Esta evaluación no puede ser activada, tiene que tener mínimo una pregunta registrada para ser activada."));
				} else {
					$evaluacion_activa = (new Administrador())->orden_evaluacion($modulo, $leccion);
					$datos['LGF0180008'] = $estatus;

					$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
						"LGF0180001" => $evaluacion_activa[0]['id']
					));
					/*if ($evaluacion_anterior[0]['LGF0190010'] != $estatus) {
						if ($estatus == 1) {
							$evaluacion_activa = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
								"LGF0180002" => $nivel[0]['nivel'],
								"LGF0180003" => $modulo,
								"LGF0180004" => $leccion,
								"LGF0180006" => 0
							));

							$datos['LGF0180006'] = $evaluacion_activa[0]['LGF0180006'] + 1;
							$datos['LGF0180008'] = 1;

							$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
								"LGF0180001" => $evaluacion_activa[0]['LGF0180001']
							));
						} else {
							$evaluacion_activa = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
								"LGF0180002" => $nivel[0]['nivel'],
								"LGF0180003" => $modulo,
								"LGF0180004" => $leccion,
								"LGF0180006" => 1
							));

							$datos['LGF0180006'] = $evaluacion_activa[0]['LGF0180006'] - 1;
							$datos['LGF0180008'] = 0;

							$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
								"LGF0180001" => $evaluacion_activa[0]['LGF0180001']
							));
						}

						$anterior = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
							"LGF0180002" => $nivel[0]['nivel'],
							"LGF0180003" => $modulo,
							"LGF0180004" => $leccion
						));

						foreach ($anterior as $ant) {
							if ($ant['LGF0180001'] != $evaluacion_activa[0]['LGF0180001']) {
								if ($estatus == 1) {
									$nueva_posicion['LGF0180006'] = $ant['LGF0180006'] + 1;
									$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $nueva_posicion, (object) array(
										"LGF0180001" => $ant['LGF0180001']
									));
								} else {
									$nueva_posicion['LGF0180006'] = $ant['LGF0180006'] - 1;
									$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $nueva_posicion, (object) array(
										"LGF0180001" => $ant['LGF0180001']
									));
								}
							}
						}
					}*/
					$this->renderJSON(array("mensaje" => "Evaluacion actualizada exitosamente."));
				}
			} else {
				$this->renderJSON(array("error" => "Ha ocurrido un error al actualizar la información."));
			}
		}

		public function accionEvaluacion() {
			$idEvaluacion = $_POST['evaluacion'];
			$estatus = $_POST['estatus'];
			$bandera = false;

			if ($estatus == 1) {
				$check_preguntas = (new Administrador())->check_preguntas($idEvaluacion);
				if ($check_preguntas[0]['total'] == 0) {
					$bandera = false;
				} else {
					$bandera = true;
				}
			} else {
				$bandera = true;
			}

			if ($bandera) {
				$evaluacion_anterior = (new Evaluacion())->obtenEvaluacion((object) array (
					"LGF0190001" => $idEvaluacion
				));

				$data = array(
					'LGF0190010' => $estatus
				);

				$estatus_evaluacion['LGF0180008'] = $estatus;

				$evaluacion = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
					"LGF0180002" => $informacion[0]['LGF0190005'],
					"LGF0180003" => $informacion[0]['LGF0190006'],
					"LGF0180004" => $informacion[0]['LGF0190007'],
					"LGF0180006" => 1
				));

				$respuesta = (new Evaluacion())->actualizarEvaluacion((object) $data, (object) array (
					"LGF0190001" => $idEvaluacion
				));
				if ($respuesta) {
					$evaluacion_activa = (new Administrador())->orden_evaluacion($evaluacion_anterior[0]['LGF0190006'], $evaluacion_anterior[0]['LGF0190007']);
					$datos['LGF0180008'] = $estatus;

					$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
						"LGF0180001" => $evaluacion_activa[0]['id']
					));

					/*if ($evaluacion_anterior[0]['LGF0190010'] != $estatus) {
						if ($estatus == 1) {
							$evaluacion_activa = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
								"LGF0180002" => $evaluacion_anterior[0]['LGF0190005'],
								"LGF0180003" => $evaluacion_anterior[0]['LGF0190006'],
								"LGF0180004" => $evaluacion_anterior[0]['LGF0190007'],
								"LGF0180006" => 0
							));

							$datos['LGF0180006'] = $evaluacion_activa[0]['LGF0180006'] + 1;
							$datos['LGF0180008'] = 1;

							$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
								"LGF0180001" => $evaluacion_activa[0]['LGF0180001']
							));
						} else {
							$evaluacion_activa = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
								"LGF0180002" => $evaluacion_anterior[0]['LGF0190005'],
								"LGF0180003" => $evaluacion_anterior[0]['LGF0190006'],
								"LGF0180004" => $evaluacion_anterior[0]['LGF0190007'],
								"LGF0180006" => 1
							));

							$datos['LGF0180006'] = $evaluacion_activa[0]['LGF0180006'] - 1;
							$datos['LGF0180008'] = 0;

							$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
								"LGF0180001" => $evaluacion_activa[0]['LGF0180001']
							));
						}
						$anterior = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
							"LGF0180002" => $evaluacion_anterior[0]['LGF0190005'],
							"LGF0180003" => $evaluacion_anterior[0]['LGF0190006'],
							"LGF0180004" => $evaluacion_anterior[0]['LGF0190007'],
						));

						foreach ($anterior as $ant) {
							if ($ant['LGF0180001'] != $evaluacion_activa[0]['LGF0180001']) {
								if ($estatus == 1) {
									$nueva_posicion['LGF0180006'] = $ant['LGF0180006'] + 1;
									$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $nueva_posicion, (object) array(
										"LGF0180001" => $ant['LGF0180001']
									));
								} else {
									$nueva_posicion['LGF0180006'] = $ant['LGF0180006'] - 1;
									$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $nueva_posicion, (object) array(
										"LGF0180001" => $ant['LGF0180001']
									));
								}
							}
						}
					}*/
					$this->renderJSON(array("mensaje" => "Evaluacion actualizada exitosamente."));
				} else {
					$this->renderJSON(array("error" => "Ha ocurrido un error al actualizar la información."));
				}
			} else {
				$this->renderJSON(array("error" => "Esta evaluación no puede ser activada, tiene que tener mínimo una pregunta registrada para ser activada."));
			}
		}

		/**
		 * Preguntas
		 */
		public function saveQuestion() {
			$nombre = nl2br($_POST['texto']);
			$tipo = $_POST['tipo'];
			$categoria = $_POST['categoria'];
			$evaluacion_id = $_POST['id'];

			$pregunta = array(
				"LGF0200002" => addslashes($nombre),
				"LGF0200003" => $this->mover_archivos('imagenprincipal'),
				"LGF0200004" => $tipo,
				"LGF0200009" => $evaluacion_id,
				"LGF0200010" => $categoria,
				"LGF0200014" => date("Y-m-d H:i:s"),
				"LGF0200015" => $this->userid
			);

			/*print_r($pregunta);
			$this->mover_archivos("imagenprincipal");
			die();*/

			$PreguntID = (new CatalogoPreguntasEval())->agregarCatalogoPreguntasEval((object) $pregunta );

			if (empty($PreguntID)) {
				$this->renderJSON(array('error' => 'Ocurrió un problema al registrar la pregunta.'));
			}

			if ($tipo == 1) {
				$ciclos = 4;
				for($i = 0; $i < $ciclos; $i ++) {
					if ($i == 0) {
						$data = array(
							'LGF0210002' => $PreguntID,
							'LGF0210003' => addslashes($_POST['correcta']),
							'LGF0210005' => 'V',
							'LGF0210004' => $this->archivo_base64('imgcorrecta')
						);
						(new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
					} else {
						$respuesta = "respuestaincorrecta".$i;
						$imagen = 'imgcorrecta'.$i;
						$data = array(
							'LGF0210002' => $PreguntID,
							'LGF0210003' => addslashes($_POST[$respuesta]),
							'LGF0210005' => 'F',
							'LGF0210004' => $this->archivo_base64($imagen)
						);
						// print_r($data);
						(new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
					}
				}

				// print_r($data);
			} else {
				$ciclos = 2;
				for($i = 0; $i < $ciclos; $i ++) {
					if ($i == 0) {
						$data = array(
							'LGF0210002' => $PreguntID,
							'LGF0210003' => addslashes($_POST['correctaV']),
							'LGF0210005' => 'V',
							'LGF0210004' => $this->archivo_base64('imgcorrectaV')
						);
						(new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
					} else {
						$data = array(
							'LGF0210002' => $PreguntID,
							'LGF0210003' => addslashes($_POST['respuestaincorrectaF']),
							'LGF0210005' => 'F',
							'LGF0210004' => $this->archivo_base64('imgcorrectaF')
						);
						(new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
					}
				}
			}
			$this->renderJSON(array("mensaje" => "Pregunta registrada correctamente."));
		}

		public function updateQuestion() {
			$nombre = nl2br($_POST['texto']);
			$tipo = $_POST['tipo'];
			$categoria = $_POST['categoria'];
			$evaluacion_id = $_POST['id'];
			
			$pregunta = array(
				"LGF0200002" => addslashes($nombre),
				"LGF0200004" => $tipo,
				"LGF0200010" => $categoria,
				"LGF0200018" => date("Y-m-d H:i:s"),
				"LGF0200019" => $this->userid
			);

			if (!empty($this->archivo_base64('imagen1'))) {
				$pregunta["LGF0200003"] = $this->mover_archivos('imagen1');
			}

			$ok = (new CatalogoPreguntasEval())->actualizarCatalogoPreguntasEval((object) $pregunta, (object) array(
				"LGF0200001" => $evaluacion_id
			));

			if ($tipo == 1) {
				$ciclos = 4;
				$inicio = 2;
				$termino = 6;
			} else {
				$ciclos = 2;
				$inicio = 6;
				$termino = 8;
			}

			$respuesta = "respuesta";
			$imagen = "imagen";
			$respuesta_id = "respuesta_id";

			$ids = array();
			$id = (new Administrador())->obtener_ids_respuestas($evaluacion_id);
			array_push($ids, $id);
			
			$cont = 0;
			for ($i=$inicio; $i < $termino; $i++) { 
				$id = $respuesta_id.$i;
				$resp = $respuesta.$i;
				$img = $imagen.$i;

				if ($cont == 0) {
					$data = array(
						'LGF0210002' => $evaluacion_id,
						'LGF0210003' => addslashes($_POST[$resp]),
						'LGF0210005' => 'V'
					);
					if (!empty($this->archivo_base64($img))) {
						$data['LGF0210004'] = $this->archivo_base64($img);
					} else {
						$data['LGF0210004'] = $ids[0][0]['imagen'];
					}
					$up = (new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
				} else {
					$data = array(
						'LGF0210002' => $evaluacion_id,
						'LGF0210003' => addslashes($_POST[$resp]),
						'LGF0210005' => 'F'
					);
					if (!empty($this->archivo_base64($img))) {
						$data['LGF0210004'] = $this->archivo_base64($img);
					} else {
						$data['LGF0210004'] = $ids[0][$cont]['imagen'];
					}
					$up = (new RespuestasEvaluacion())->agregarRespuestasEvaluacion((object) $data);
				}
				$cont++;
			}

			foreach ($ids[0] as $pos) {
				(new RespuestasEvaluacion ())->eliminaRespuestasEvaluacion ( ( object ) array (
					"LGF0210001" => $pos['id'] 
				));
			}

			// die();
				
			if ($ok && $up) {
				$this->renderJSON(array("mensaje" => "Preguntas actualizadas correctamente."));
			} else {
				$this->renderJSON(array("error" => "Ocurrió un problema al actualizar la información, intentelo de nuevo."));
			}
			// print_r($data);
		}

		public function mover_archivos($campo) {
			$fileTmpPath = $_FILES[$campo]['tmp_name'];
			$fileName = $_FILES[$campo]['name'];
			$fileSize = $_FILES[$campo]['size'];
			$fileType = $_FILES[$campo]['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileName = str_replace(" ", "_", $fileNameCmps[0]);
			$fileExtension = strtolower(end($fileNameCmps));

			$fecha = date("Y-m-d H:i:s");
			$fecha = str_replace(" ", "_", $fecha);
			$fecha = str_replace("-", "_", $fecha);
			$fecha = str_replace(":", "_", $fecha);

			$newFileName = $fileName.$fecha.'.'.$fileExtension;

			$allowedfileExtensions = array('jpg', 'png', 'mp3', 'mp4');
			if (in_array($fileExtension, $allowedfileExtensions)) {
				$uploadFileDir = __DIR__.'/../../portal/archivos/';
				$dest_path = $uploadFileDir.$newFileName;
				if(move_uploaded_file($fileTmpPath, $dest_path)) {
				  return $newFileName;
				} else {
					return $this->archivo_base64($campo);
				}
			}
		}

        public function borrarObjeto(){
            $objeto = $_POST["objeto"];

            $seccion18 = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array("LGF0180001" => $objeto));
            $seccion18 = $seccion18[0];

            $leccion = (new Leccion())->obtenLeccion((object) array("LGF0160001" => $seccion18["LGF0180004"]));
            $leccion = $leccion[0];

            $ruta = __DIR__."/../../portal/oda/n".$seccion18["LGF0180002"]."/m".$seccion18["LGF0180003"]."/l".$leccion["LGF0160007"]."/".$seccion18["LGF0180007"]."/";
            $res = $this->eliminar_directorio_recursivamente($ruta);

            (new EstructuraNavegacion())-> eliminaEstructuraNavegacion((object) array("LGF0180001" => $objeto));

            if($res){
                $this->renderJSON(array("mensaje" => "Objeto borrado correctamente."));
            }else{
                $this->renderJSON(array('error' => 'Ocurrió un problema al borrar el objeto.'));
            }
        }

		public function mostrarObjetos() {
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];

			$tabla = "";
			if (!empty($modulo) && !empty($leccion)) {
				$respuesta = (new Administrador())->mostrarObjetos($modulo, $leccion);
                #var_dump("respuesta", $respuesta);
				if (count($respuesta) > 0) {
					$resultado = true;
					foreach ($respuesta as $resp) {
						if ($resp['estatus'] == 1) {
							$estatus = "Activo";
							$texto = "Desactivar";
							$icono = "fa fa-lock";
							$accion = "eliminar(".$resp['id'].")";
                            $accionBorrar = "";
                            $iconoBorrar = "";
                            $textoBorrar = "";
							$estilo ="";
						} else {
                            #var URL_for_iframe = navegar/nivelid_moduloid_leccionid_orden
                            $url_para_iframe_previsualizar = $resp['nivelid']."_".$resp['moduloid']."_".$resp['leccionid']."_".$resp['orden']."_0";

							$estatus = "Inactivo <hr> 
                                <button type='button' url='".$url_para_iframe_previsualizar."' class='modal_previsualizar regresar basico menu-principal' >
                                    Previsualizar  
                                </button>";
							$texto = "Activar";
							$icono = "fa fa-unlock";
							$accion = "activar(".$resp['id'].")'";
                            $accionBorrar = "borrarObjeto(".$resp['id'].")";
                            $iconoBorrar = "fa fa-trash";
                            $textoBorrar = "<b>Borrar</b> objeto";
							$estilo = "style='font-weight: bold; color: #ff0000;'";
						}
						if (empty($resp['fecha'])) {
							$fecha = "N/A";
						} else {
							$fecha = $resp['fecha'];
						}
						$tabla.="<tr>   
                                    <td>".$resp['orden']."</td>
                                    <td>".$resp['nombre']."</td>
                                    <td>".$resp['modulo']."</td>
                                    <td>".$resp['leccion']."</td>
                                    <td>".$resp['seccion']."</td>
                                    <td>".$fecha."</td>
                                    <td ".$estilo.">".$estatus."</td>
                                    <td>
                                        <span>
                                            <a href=".CONTEXT."admin/editObjeto/".$resp['id'].">
                                                <i class='fa fa-pencil' aria-hidden='true'></i> Editar
                                            </a>
                                        </span> <br>
                                        <span>
                                            <a href='#' onclick='".$accion."'>
                                                <i class='".$icono."' aria-hidden='true'></i> ".$texto."
                                            </a>
                                        </span> ";
                        $tabla .= $accionBorrar != "" ? "<hr>
                                        <span>
                                            <a href='#' onclick='".$accionBorrar."'>
                                                <i class='".$iconoBorrar."' aria-hidden='true'></i> ".$textoBorrar."
                                            </a>
                                        </span>
                                    </td>
                                  </tr>":
                            "</td>
                        </tr>";
					}
				} else {
					$resultado = false;
					$tabla.="";
				}
			} else {
				$resultado = false;
				$tabla.="";
			}
			return $this->renderJSON(array('resultado'=>$resultado,'contenido'=>$tabla));
		}

		public function listarObjetos() {
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];

			$lista = "";
			$lista2 = "";
			$titulo = "";
			if (!empty($modulo) && !empty($leccion)) {
				$respuesta = (new Administrador())->mostrarObjetos($modulo, $leccion);
				$ultimo_orden = end($respuesta);
				// print_r($ultimo_orden);
				$posicion_evalucion = $ultimo_orden['orden'];
				// echo "Ultima posicion: ".$posicion_evalucion;
				if (count($respuesta) > 0) {
					$resultado = true;
					$contador = 0;
					
					if ($respuesta[0]['seccionid'] == 11 && $respuesta[0]['estatus'] == 1) {
						$inicio = 1;
					} else {
						$inicio = 0;
					}
					$contador = 0;
					foreach ($respuesta as $resp) {
						$lista2.="<div id='ajh' style='display:none'>Total: ".$contador."</div>";
						if ($resp['estatus'] == 1) {
							$estatus = "Activo";
						} else {
							$estatus = "Inactivo";
						}

						if ($resp['seccionid'] == 11 && $resp['estatus'] == 0 || $resp['seccionid'] == 11 && $resp['estatus'] == 1 && $resp['orden'] == $posicion_evalucion) {
							$lista2.="<li class='list-group-item'>".$resp['orden']." ) ".$resp['nombre']."<span class='text-estatus'><i class='fa fa-lock' aria-hidden='true'></i> ".$estatus."</span></li>";
						} else {
							$lista.="<li id='".$resp['id']."' class='list-group-item' data-iden=".$resp['id']." data-id=".$resp['orden']." data-order=".$resp['orden']." data-inicia='".$inicio."'><span id='span_".$resp['id']."'>".$resp['orden']." )</span> ".$resp['nombre']."<span class='text-estatus'>".$estatus."-".$contador."</span></li>";
						}
						$contador++;
						$titulo = "Ordenar objetos correspondientes a ".$resp['modulo']." - ".$resp['leccion'];
					}
				} else {
					$resultado = false;
					$lista.="";
					$lista2.="";
					$titulo = "";
				}
			} else {
				$resultado = false;
				$lista.="";
				$lista2.="";
				$titulo = "";
			}
			return $this->renderJSON(array('resultado'=>$resultado,'contenido'=>$lista, "titulo"=>$titulo, "lista"=>$lista2));
		}

		public function accionObjeto() {
			$objeto = $_POST['objeto'];
			$estatus = $_POST['estatus'];

			$evaluacion_anterior = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array (
				"LGF0180001" => $objeto
			));

			$anterior = (new Administrador())->mostrarObjetos($evaluacion_anterior[0]['LGF0180003'], $evaluacion_anterior[0]['LGF0180004']);
			$paso = false;
			if ($anterior[0]['id'] == $_POST['objeto']) {
				$paso = true;
			}

			if ($paso) {
				// echo "Se ordena";
				if ($evaluacion_anterior[0]['LGF0180008'] != $estatus) {
					// echo "1<br>\n";
					if ($estatus == 1) {
						// echo "2<br>\n";
						$datos['LGF0180006'] = $evaluacion_anterior[0]['LGF0180006'] + 1;
						$datos['LGF0180008'] = 1;

						$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
							"LGF0180001" => $evaluacion_anterior[0]['LGF0180001']
						));
					} else {
						// echo "3<br>\n";
						$datos['LGF0180006'] = $evaluacion_anterior[0]['LGF0180006'] - 1;
						$datos['LGF0180008'] = 0;

						$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
							"LGF0180001" => $evaluacion_anterior[0]['LGF0180001']
						));
					}
				}

				foreach ($anterior as $ant) {
					if ($ant['id'] != $_POST['objeto']) {
						// echo $ant['LGF0180001']." --- ".$objeto."\n";
						$data[] = array(
							"posicion" => $ant['orden'],
							"id" => $ant['id']
						);
					}
				}

				for ($i=0; $i < count($data); $i++) { 
					if ($estatus == 1) {
						// echo "1<br>\n";
						$nueva_posicion['LGF0180006'] = $data[$i]['posicion'] + 1;
					} else {
						// echo "2<br>\n";
						$nueva_posicion['LGF0180006'] = $data[$i]['posicion'] - 1;
						// echo $nueva_posicion['LGF0180006']." -- ".$ant['LGF0180006']."<br>\n";
					}

					$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $nueva_posicion, (object) array("LGF0180001" => $data[$i]['id']));
				}

				if ($ok) {
					if ($estatus == 1) {
						$this->renderJSON(array("mensaje"=>"Objeto activado correctamente"));
					} else {
						$this->renderJSON(array("mensaje"=>"Objeto desactivado correctamente"));
					}
				} else {
					if ($estatus == 1) {
						$this->renderJSON(array("error"=>"No se pudo activar el objeto."));
					} else {
						$this->renderJSON(array("error"=>"No se pudo desactivar el objeto."));
					}
				}
			} else {
				// echo "Solo se activa";
				if ($evaluacion_anterior[0]['LGF0180008'] != $estatus) {
					// echo "1<br>\n";
					if ($estatus == 1) {
						// echo "2<br>\n";
						$datos['LGF0180008'] = 1;

						$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
							"LGF0180001" => $evaluacion_anterior[0]['LGF0180001']
						));
						if ($ok) {
							$this->renderJSON(array("mensaje"=>"Objeto activado correctamente."));
						} else {
							$this->renderJSON(array("error"=>"No se pudo activar el objeto."));
						}
					} else {
						// echo "3<br>\n";
						$datos['LGF0180008'] = 0;

						$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $datos, (object) array(
							"LGF0180001" => $evaluacion_anterior[0]['LGF0180001']
						));
						if ($ok) {
							$this->renderJSON(array("mensaje"=>"Objeto desactivado correctamente."));
						} else {
							$this->renderJSON(array("error"=>"No se pudo desactivar el objeto."));
						}
					}
				}
			}
				
		}

		public function saveObjeto() {
			/*foreach ($_POST as $key => $value) {
				echo $key." -> ".$value."\n";
			}*/
			$seccion = $_POST['seccion'];
			$modulo = $_POST['modulo'];
			$leccion = $_POST['leccion'];
			$estatus = $_POST['estatus'];
			$nivel = (new Administrador())->obtener_nivel_modulo($modulo);
			$nivel = $nivel[0]['nivel'];

			$ultimoOrden = (new Administrador())->orden_evaluacion($modulo, $leccion);
			/*echo "<pre>";
			print_r($ultimoOrden);
			echo "</pre>";*/

			$numero_leccion = (new Leccion())->obtenLeccion((object) array("LGF0160001" => $leccion));
			$numero_leccion = $numero_leccion[0];

			$ord = array();
			$obj = array();
			$navegacion = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array(
				"LGF0180002" => $nivel,
				"LGF0180003" => $modulo,
				"LGF0180004" => $leccion,
				"LGF0180007" => "OASC" 
			));
			/*echo "***********<pre>";
			print_r($navegacion);
			echo "</pre>";*/
			foreach($navegacion as $item) {
				array_push($ord, $item["LGF0180006"]);
				array_push($obj, trim($item["LGF0180006"], "obj"));
			}
			rsort($ord);
			rsort($obj);
			$orden = $ord[0];
			$objeto = $obj[0];
			// echo "Orden: ".$orden." Directorio: ".$directorio."<br>";
			// die();
			$ordenObj = 0;
			if ($seccion == 11) {
				$directorio = "";
				$carga = true;
				$ordenObj = ($orden+1);
			} else {
				if (empty($ultimoOrden[0]['orden'])) {
					// echo "|1";
					$ruta = __DIR__."/../../portal/oda/n".$nivel."/m".$modulo."/l".$numero_leccion['LGF0160007']."/obj".($orden+1);
					$ordenObj = ($orden+1);
					$directorio = "obj".($orden+1);
				} else {
					// echo "|2";
					$ruta = __DIR__."/../../portal/oda/n".$nivel."/m".$modulo."/l".$numero_leccion['LGF0160007']."/obj".($ultimoOrden[0]['orden']);
					$ordenObj = $ultimoOrden[0]['orden'];
					$directorio = "obj".$ultimoOrden[0]['orden'];
				}
				if(!is_dir($ruta)){
					mkdir($ruta, 0777, true);
					chown($ruta, "root");
					chmod($ruta, 0777);
				}

				// $directorio = "obj".(empty($ultimoOrden[0]['orden']) ? 1 : $objeto+1);
				$carga = $this->cargar_archivo("file", $ruta."/");
			}
			if ($carga == true) {
				$ok = (new EstructuraNavegacion())->agregarEstructuraNavegacion((object) array(
					"LGF0180002" => $nivel,
					"LGF0180003" => $modulo,
					"LGF0180004" => $leccion,
					"LGF0180005" => $seccion,
					"LGF0180006" => $ordenObj,
					"LGF0180007" => $directorio,
					"LGF0180008" => $estatus,
					"LGF0180009" => date("Y-m-d")
				));
				if (!empty($ok)) {
					if (!empty($ultimoOrden[0]['orden'])) {
						$data = array(
							"LGF0180006" => $ultimoOrden[0]['orden'] + 1
						);
						$newOrden = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $data, (object) array(
							"LGF0180001" => $ultimoOrden[0]['id']
						));
					}
					$this->renderJSON(array("mensaje" => "Objeto registrado correctamente.", "ruta"=>$ruta));
				} else {
					$this->renderJSON(array('error' => 'Ocurrió un problema al registrar el objeto.', "ruta"=>$ruta));
				}
			} else {
				return $carga;
			}
		}

		public function ordenarObjetos() {
			$posicion = $_POST['posicion'];
			$id = $_POST['id'];

			$up['LGF0180006'] = $posicion;
			$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $up, (object) array(
				"LGF0180001" => $id
			));
			$this->renderJSON(array("res"=>true));
		}

		public function cargar_archivo($campo, $ruta) {
			if (!file_exists($ruta)) {
				mkdir($ruta, 0777, true);
				chown($ruta, "root");
				chmod($ruta, 0777);
			}
			// die();
			$path = $_FILES[$campo]["tmp_name"];
			$zip = new ZipArchive();
			$error = 0;
			if ($zip->open($path, $error) === true) {
				$js = false;
				$css = false;
				$dirs = array();
				for($i = 0; $i < $zip->numFiles; $i ++) {
					$filename = $zip->getNameIndex($i);
					$fileinfo = pathinfo($filename);

					if ($fileinfo["dirname"] == "." && $fileinfo["basename"] == 'lo.css') {
						$css = true;
					}

					if ($fileinfo["dirname"] == "." && $fileinfo["basename"] == 'lo.js') {
						$js = true;
					}

					if (!isset($fileinfo["extension"])) {
						if ($fileinfo ["dirname"] == ".") {
							array_push($dirs, $ruta.$fileinfo["basename"]);
						} else {
							array_push($dirs, $ruta.$fileinfo["dirname"].DIRECTORY_SEPARATOR.$fileinfo["basename"]);
						}
					}
				}
				
				foreach($dirs as $dir) {
					if (!file_exists($dir)) {
						mkdir($dir, 0777, true);
						chmod($dir, 0777);
					}
				}
				for($i = 0; $i < $zip->numFiles; $i ++) {
					$filename = $zip->getNameIndex($i);
					$fileinfo = pathinfo($filename);
					if (isset($fileinfo["extension"])) {
						if ($fileinfo["dirname"] == ".") {
							copy("zip://".$path."#".$filename, $ruta.$fileinfo['basename']);
							chmod($ruta.$fileinfo['basename'], 0777);
						} else {
							copy("zip://".$path."#".$filename, $ruta.$fileinfo["dirname"].DIRECTORY_SEPARATOR.$fileinfo["basename"]);
							chmod($ruta.$fileinfo["dirname"].DIRECTORY_SEPARATOR.$fileinfo["basename"], 0777);
						}
					}
				}
				$zip->close();
				return true;
			} else {
				switch ($error) {
					case ZipArchive::ER_INCONS:
					case ZipArchive::ER_INVAL:
						$this->renderJSON(array("error" => "El archivo se encuentra corrupto."));
					break;
					case ZipArchive::ER_MEMORY:
						$this->renderJSON(array("error" => "Ha ocurrido un error de memoria."));
					break;
					case ZipArchive::ER_NOZIP:
						$this->renderJSON(array("error" => "El archivo no es un ZIP."));
					break;
					case ZipArchive::ER_OPEN:
						$this->renderJSON(array("error" => "Ha ocurrido un error al abrir el archivo, revise de nuevo el archivo."));
					break;
					case ZipArchive::ER_READ:
						$this->renderJSON(array("error" => "Ha ocurrido un error al leer el archivo, revise de nuevo el archivo."));
					break;
				}
				$this->renderJSON(array("error" => "El archivo proporcionado no se puede abrir."));
			}
		}

		public function validar_ruta($ruta) {
			if (file_exists($ruta)) {
				return true;
			}
		}

		public function updateObjeto() {
			$seccion = $_POST['seccion'];
			$estatus = $_POST['estatus'];
			/*$texto_es = $_POST['texto_es'];
			$texto_en = $_POST['texto_en'];*/

			/*$opcion = $_POST['opcion'];*/
			
			$seccion18 = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array("LGF0180001" => $_POST["objeto"]));
			$seccion18 = $seccion18[0];

			$leccion = (new Administrador())->informacionLeccion($seccion18['LGF0180004']);

			/*$rutaA = __DIR__."/../../portal/archivos/recursosLecciones/n".$seccion18["LGF0180002"]."/m".$seccion18["LGF0180003"]."/l".$leccion[0]["LGF0160007"]."/audio/";
			$rutaImg = __DIR__."/../../portal/archivos/recursosLecciones/n".$seccion18["LGF0180002"]."/m".$seccion18["LGF0180003"]."/l".$leccion[0]["LGF0160007"]."/img/";*/

			/*if ($opcion == 1) { // eliminar audio
				$idioma = $_POST['lg'];
				if ($idioma == 'es') {
					$data["LGF0180012"] = "";
					$texto = "Audio en español";
					$audio= $rutaA.$seccion18['LGF0180012'];
				} else if ($idioma == "en") {
					$data["LGF0180013"] = "";
					$texto = "Audio en inglés";
					$audio = $rutaA.$seccion18['LGF0180013'];
				} else {
					$data["LGF0180014"] = "";
					$texto = "Imagen";
					$audio = $rutaImg.$seccion18['LGF0180014'];
				}
				$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $data, (object) array(
					"LGF0180001" => $_POST['objeto']
				));

				unlink($audio);
				$this->renderJSON(array("mensaje" => $texto." eliminado correctamente."));
			} else { // actualizar informacion de objetos*/
				/*$data["LGF0180010"] = (empty($texto_es) ? "" : $texto_es);
				$data["LGF0180011"] = (empty($texto_en) ? "" : $texto_en);*/
				// echo $rutaA."<br>";
				/*if (!$this->validar_ruta($rutaA)) {
					mkdir($rutaA, 0777, true);
					chown($rutaA, "root");
					chmod($rutaA, 0777);
				}

				if (!$this->validar_ruta($rutaImg)) {
					mkdir($rutaImg, 0777, true);
					chown($rutaImg, "root");
					chmod($rutaImg, 0777);
				}*/

				/*if ($_FILES['imagen']['tmp_name'] != "") {
					$temporal = $_FILES['imagen']['tmp_name'];
					$aux = str_replace(" ", "_", $_FILES['imagen']['name']);
					$aux = strtolower($aux);
					$time = sha1($aux.time());
					$time = substr($time, 0, 10);
					$name = "img_instruccion_leccion_"."l".$leccion[0]["LGF0160007"]."_".$time."_".$aux;
					if ($this->validar_ruta($rutaImg.$seccion18["LGF0180014"])) {
						unlink($rutaImg.$seccion18["LGF0180014"]);
					}
					$rutaFile = $rutaImg.$name;
					$data["LGF0180014"] = $name;
					$this->mover_recursos($temporal, $rutaFile);
				}*/

				/*if ($_FILES['audio_es']['tmp_name'] != "") {
					$temporal = $_FILES['audio_es']['tmp_name'];
					$aux = str_replace(" ", "_", $_FILES['audio_es']['name']);
					$aux = strtolower($aux);
					$time = sha1($aux.time());
					$time = substr($time, 0, 10);
					$name = "audio_leccion_es_"."l".$leccion[0]["LGF0160007"]."_".$time."_".$aux;
					if ($this->validar_ruta($rutaA.$seccion18["LGF0180012"])) {
						unlink($rutaA.$seccion18["LGF0180012"]);
					}
					$rutaFile = $rutaA.$name;
					$data["LGF0180012"] = $name;
					$this->mover_recursos($temporal, $rutaFile);
				}*/

				/*if ($_FILES['audio_en']['tmp_name'] != "") {
					$temporal = $_FILES['audio_en']['tmp_name'];
					$aux = str_replace(" ", "_", $_FILES['audio_en']['name']);
					$aux = strtolower($aux);
					$time = sha1($aux.time());
					$time = substr($time, 0, 10);
					$name = "audio_leccion_en_"."l".$leccion[0]["LGF0160007"]."_".$time."_".$aux;
					if ($this->validar_ruta($rutaA.$seccion18["LGF0180013"])) {
						unlink($rutaA.$seccion18["LGF0180013"]);
					}
					$rutaFile = $rutaA.$name;
					// echo $rutaFile;
					$data["LGF0180013"] = $name;
					$this->mover_recursos($temporal, $rutaFile);
				}*/

				if (!empty($_FILES['file']['tmp_name'])) {
					$leccion = (new Leccion())->obtenLeccion((object) array("LGF0160001" => $seccion18["LGF0180004"]));
					$leccion = $leccion[0];
					
					$ruta = __DIR__."/../../portal/oda/n".$seccion18["LGF0180002"]."/m".$seccion18["LGF0180003"]."/l".$leccion["LGF0160007"]."/".$seccion18["LGF0180007"]."/";
					$this->eliminar_directorio_recursivamente($ruta);
					
					$carga = $this->cargar_archivo("file", $ruta);
					if ($carga == true) {
						$data["LGF0180005"] = $seccion;
						$data["LGF0180008"] = $estatus;

						$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $data, (object) array(
							"LGF0180001" => $_POST['objeto']
						));
						if (!empty($ok)) {
							$this->renderJSON(array("mensaje" => "Objeto actualizado correctamente."));
						} else {
							$this->renderJSON(array('error' => 'Ocurrió un problema al actualizado el objeto.'));
						}
					} else {
						return $carga;
					}
				} else {
					$data["LGF0180005"] = $seccion;
					$data["LGF0180008"] = $estatus;

					$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $data, (object) array(
						"LGF0180001" => $_POST['objeto']
					));
					if ($ok) {
						$this->renderJSON(array("mensaje" => "Objeto actualizado correctamente."));
					} else {
						$this->renderJSON(array('error' => 'Ocurrió un problema al actualizar el objeto.'));
					}
					// actualizarEstructuraNavegacion
				}
			/*}*/
		}

		public function eliminar_directorio_recursivamente($ruta) {
			if (is_dir($ruta)) {
				// Obtener un arreglo con directorios y archivos
		        $subdirectorios_o_archivos = scandir($ruta);
		        // print_r($subdirectorios_o_archivos);
		        foreach ($subdirectorios_o_archivos as $subdirectorio_o_archivo) {
		        	// Omitir . y .., pues son directorios que se refieren al directorio actual o al directorio padre
		            if ($subdirectorio_o_archivo != "." && $subdirectorio_o_archivo != "..") {
		            	// Si es un directorio, recursión
		                if (is_dir($ruta.$subdirectorio_o_archivo)) {
		                	$this->eliminar_directorio_recursivamente($ruta.$subdirectorio_o_archivo."/");
		                } else {
		                    // Si es un archivo, lo eliminamos con unlink
		                    unlink($ruta.$subdirectorio_o_archivo); 
		                }
		            }
		        }
		        # Al final de todo, el directorio estará vacío
		        # y podremos usar rmdir
		        rmdir($ruta);
                return true;
		    }
		}

		/**
		 * Nuevas funciones de reportes
		 */

		public function reporte_resultados() {
			$seccion = $_POST['seccion']; // [1]Evaluaciones [2] Habilidades
			$usuario = $_POST['usuario']; // [1] Institucion [2] Grupos [3] Alumnos
			$institucion = $_POST['institucion'];
			if ($seccion == 1) {
				$this->reporte_evaluaciones($usuario);
			} else {
				// echo "Hola habilidades";
				$this->reporte_habilidades($usuario);
			}
		}

		public function reporte_habilidades($usuario) {
			// $result = (new Administrador())->reporte_habilidades($usuario);
			$modulos = (new Administrador())->obtener_modulos();
			foreach ($modulos as $modulo) {
				$result[] = (new Administrador())->reporte_habilidades($usuario, $modulo['LGF0150001']);
			}
			$columnas = "";

			foreach ($modulos as $key => $value) {
				// echo "Campo".$value['LGF0150004']."\n";
				if ($value['LGF0150004'] == 1) {
					$fondo = "#7e3e98";
				} else if ($value['LGF0150004'] == 2) {
					$fondo = "#2dbeba";
				} else if ($value['LGF0150004'] == 3) {
					$fondo = "#0b70b7";
				}

				$color = "#fff";

				if (empty($result[$key][0]['vocabulary'])) {
					$vocabulary = 0;
				} else {
					$vocabulary = round($result[$key][0]['vocabulary']);
				}
				if (empty($result[$key][0]['grammar'])) {
					$grammar = 0;
				} else {
					$grammar = round($result[$key][0]['grammar']);
				}
				if (empty($result[$key][0]['reading'])) {
					$reading = 0;
				} else {
					$reading = round($result[$key][0]['reading']);
				}
				if (empty($result[$key][0]['listening'])) {
					$listening = 0;
				} else {
					$listening = round($result[$key][0]['listening']);
				}
				if (empty($result[$key][0]['speaking'])) {
					$speaking = 0;
				} else {
					$speaking = round($result[$key][0]['speaking']);
				}
				$total = ($vocabulary+$grammar+$reading+$listening+$speaking)/5;
				$columnas.="<tr><td style='background-color: ".$fondo."; color: ".$color."; font-size: 16px; font-weight: bold;'>".$value['LGF0150002']."</td><td>".$vocabulary."</td><td>".$grammar."</td><td>".$reading."</td><td>".$listening."</td><td>".$speaking."</td><td style='background-color: ".$fondo."; color: ".$color."; font-size: 16px; font-weight: bold;'>".$total."</td></tr>";
			}

			$this->renderJSON(array("contenido"=>$columnas));
		}

		public function reporte_evaluaciones($usuario) {
			$modulos = (new Administrador())->obtener_modulos();
			$lecciones = (new Administrador())->obtenerMaxLecciones();

			foreach ($modulos as $modulo) {
				$result[] = array(
					$modulo['LGF0150001'] => (new Administrador())->reporte_evaluaciones($usuario, $lecciones[0]['num'], $modulo['LGF0150001'])
				);
			}

			$contador = 0;
			foreach ($modulos as $key => $value) {
				$contador++;
			}
			
			$color = "#fff";
			$cont = 1;
			$tabla = "";
			
			foreach ($result as $key => $res) {
				if ($res[$cont][0]['nivel'] == 1) {
					$fondo = "#7e3e98";
				} else if ($res[$cont][0]['nivel'] == 2) {
					$fondo = "#2dbeba";
				} else if ($res[$cont][0]['nivel'] == 3) {
					$fondo = "#0b70b7";
				}
				// echo "Cont: ".$cont." --- modulo: ".$res[$cont][0]['modulo']."<br>";
				$tabla.="<tr><td style='background-color: ".$fondo."; color: ".$color.";'>".$res[$cont][0]['modulo']."</td>";
				$promedio = 0;
				$contador1 = 0;
				for ($i=1; $i <= $lecciones[0]['num']; $i++) { 
					$prom = "promL".$i;
					if ($res[$cont][0][$prom] == "" || $res[$cont][0][$prom] == null) {
						$valor = "S/P";
					} else {
						$valor = round($res[$cont][0][$prom]);
					}

					if ($res[$cont][0][$prom] != "" || $res[$cont][0][$prom] != null) {
						$contador1++;
					}
					

					$promedio = ($promedio + round($res[$cont][0][$prom]));
					$tabla.="<td>".$valor."</td>";
				}
				if ($contador1 == 0) {
					$contador1 = $lecciones[0]['num'];
				}
				// echo "contador[".$res[$cont][0]['id']."]: (".$promedio.") ".$contador1."\n";
				$promedioL = ($promedio/$contador1);

				if ($promedio == "") {
					$promedio = "S/P";
				}
				$tabla.="<td style='background-color: ".$fondo."; color: ".$color.";'>".$promedioL."</td>";
				$tabla.="</tr>";
				if ($cont == $contador) {
					$cont = 0;
				}
				$cont++;
			}

			$this->renderJSON(array("contenido"=>$tabla));
		}

		public function guias() {
			$nivel = $_POST['nivel'];
			$docente = $_POST['docente'];
			$origen = $_POST['origen']; // 1) Admin 2)Home
			// echo CONTEXT;
			$guias = (new Administrador())->obtenerGuias($nivel);
			$nivel = (new Administrador())->obtener_nivel_modulo($nivel);
			$guiasEstudio = ARCHIVO_FISICO."guiasEstudio/";
			$rutaIconos = ARCHIVO_FISICO."iconosLecciones/";
			$pdf = $rutaIconos."pdf.png";
			$scopeicono = $rutaIconos."scope.png";
			foreach ($guias as $guia) {
				if ($guia['icono'] == "" || $guia['icono'] == null) {
					$iconoL = $rutaIconos."icono_temporal.png";
				} else {
					$iconoL = $rutaIconos."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$guia['icono'];
				}
				// echo $iconoL."\n";
				/*if (!file_get_contents($iconoL)) {
					$iconoL = $rutaIconos."icono_temporal.png";
				}*/
				// echo $iconoLeccion."\n";

				if ($guia['archivo'] == "" || $guia['archivo'] == null) {
					$archivo = $guiasEstudio."GUIA_default.pdf";
				} else {
					if ($docente == 1) {
						$aux = explode(".pdf", $guia['archivo']);
						$file = $aux[0]."_docente.pdf";
						$archivo = $guiasEstudio."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$file;
					} else {
						$archivo = $guiasEstudio."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$guia['archivo'];
					}
				}

				/*if (is_file($archivo)) {
					$archivo = $guiasEstudio."GUIA_default.pdf";
				}*/
				// echo $archivo."\n";

				if ($guia['orden'] == 0) {
					if ($guia['archivo'] == "" || $guia['archivo'] == null) {
						$archivoScope = $guiasEstudio."GUIA_default.pdf";
					} else {
						$rutaScope = "n".$nivel[0]['nivel']."/m".$guia['modulo']."/".$guia['archivo'];
						$archivoScope = $guiasEstudio.$rutaScope;
					}
					/*if (is_file($archivoScope)) {
						$archivoScope = $guiasEstudio."GUIA_default.pdf";
					}*/
					// echo $archivoScope."\n";
					$contenido = "<tr><td width='100'><img class='img-fluid' src='".$scopeicono."'></td><td class='texto'>Scope and sequence</td><td width='100'><a href='".$archivoScope."' target='_blank'><img class='img-fluid' src='".$pdf."'></a></td></tr>";
				}
			}
			// echo "Hola";

			if ($_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 5) {
				$cGuias = (new Administrador())->obtenerGuias1($_POST['nivel'], 1);
			} else if ($_SESSION['perfil'] == 6) {
				$cGuias = (new Administrador())->obtenerGuias1($_POST['nivel'], 2);
			} else if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4) {
				$cGuias = (new Administrador())->obtenerGuias1($_POST['nivel'], 0);
			}
			foreach ($cGuias as $guia) {
				if ($guia['icono'] == "" || $guia['icono'] == null) {
					$iconoL = $rutaIconos."icono_temporal.png";
				} else {
					$iconoL = $rutaIconos."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$guia['icono'];
				}
				// echo $iconoL."\n";
				/*if (!file_get_contents($iconoL)) {
					$iconoL = $rutaIconos."icono_temporal.png";
				}*/
				// echo $iconoLeccion."\n";

				if ($guia['archivo'] == "" || $guia['archivo'] == null) {
					$archivo = $guiasEstudio."GUIA_default.pdf";
				} else {
					if ($docente == 1) {
						$aux = explode(".pdf", $guia['archivo']);
						$file = $aux[0]."_docente.pdf";
						$archivo = $guiasEstudio."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$file;
					} else {
						$archivo = $guiasEstudio."n".$nivel[0]['nivel']."/m".$guia['modulo']."/l".$guia['orden']."/".$guia['archivo'];
					}
				}

				/*if (is_file($archivo)) {
					$archivo = $guiasEstudio."GUIA_default.pdf";
				}*/
				// echo $archivo."\n";
				/*if ($origen == 2 && $_SESSION['perfil'] == 1) {
					$complemento = "<a onclick='editar_leccion(".$guia['id'].",".$guia['leccionid'].")' style='float: right; cursor: pointer;' title='Editar lección ".$guia['orden']."'><i class='fa fa-pencil' aria-hidden='true'></i></a>";
				}*/

				if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4) {
					$texto = " - ".((empty($guia['tipoG'] == 1) ? "Guía del alumno" : "Guía del docente"));
				}

				$contenido.="<tr><td width='100'>$complemento <img class='img-fluid' src='".$iconoL."'></td><td class='texto'>Lección ".$guia['orden']." ".$guia['leccion']." ".$texto."</td><td width='100'><a href='".$archivo."' target='_blank'><img class='img-fluid' src='".$pdf."'></a></td></tr>";
			}
			// echo $cont;
			$this->renderJSON(array("contenido"=>$contenido));
		}

		public function recursos() {
			$nivel = $_POST['nivel'];
			if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6) {
				$tipoRecurso = 0;
			} else if ($_SESSION['perfil'] == 2) {
				$tipoRecurso = 1;
			}

			$recurso = (new Administrador())->obtenerRecursos($nivel, $tipoRecurso);
			/*echo "<pre>";
			print_r($recurso);
			echo "</pre>";*/
			$iconos = ARCHIVO_FISICO."iconosLecciones/";
			$recursos = ARCHIVO_FISICO."recursosLecciones/";
			$tabla = "";
			foreach ($recurso as $value) {
				if ($_SESSION['perfil'] != 2) {
					if ($tipoRecurso == 0) {
						if ($value['tipoR'] == 1) {
							$texto = "<br>(Recurso del alumno)";
						} else {
							$texto = "<br>(Recurso del docente)";
						}
					}
				}
				#$ruta_recursos = __DIR__."/../../portal/archivos/recursosLecciones/n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/";
				#$ruta_iconos = __DIR__."/../../portal/archivos/iconosLecciones/n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/";
				// echo $ruta_recursos."<br>";
				if ($value['icono'] == "" || $value['icono'] == null) {
					$icono = $iconos."icono_temporal.png";
				} else {
					/*####################################################*/
					/*if (file_exists($ruta_iconos.$value['icono'])) {
						$icono = $iconos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					} else {
						$icono = $iconos."icono_temporal.png";
					}*/
					$icono = $iconos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					/*####################################################*/
				}
				$nombre = "Lección ".$value['orden'].") ".$value['leccion']."$texto";
				if ($value['recurso1'] == "" || $value['recurso1'] == null) {
					$rec1 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
				} else {
					/*####################################################*/
					/*if (file_exists($ruta_recursos.$value['recurso1'])) {*/
						$aux = explode(".", $value['recurso1']);
						if ($aux[1] == "mp3") {
							/*$rec1 = "<a onclick='reproducir(".$value['orden'].")' id='recurso_".$value['orden']."' data-enlace='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1']."'><i class='fa fa-play' aria-hidden='true' style='font-size: 50px;'></i></a> <a href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1']."' download><i class='fa fa-download' aria-hidden='true' style='float: right; font-size: 20px !important;'></i></a>";*/

							$rec1 = "<a target='_blank' href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1']."' download><i class='fa fa-download' aria-hidden='true' style=' font-size: 20px !important;'></i></a>";
						} else {
							$rec1 = "<a href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1']."'><i class='fa fa-file-archive-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
						}
					/*} else {
						$rec1 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					}*/
					/*####################################################*/
				}
				if ($value['recurso2'] == "" || $value['recurso2'] == null) {
					$rec2 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
				} else {
					/*####################################################*/
					/*if (file_exists($ruta_recursos.$value['recurso2'])) {*/
						$recurso2 = $recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso2'];
						$rec2 = "<a href='".$recurso2."' id='recurso_".$value['orden']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*} else {
						$rec2 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					}*/
					/*####################################################*/
				}

				if ($value['recurso3'] == "" || $value['recurso3'] == null) {
					$rec3 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
				} else {
					/*####################################################*/
					/*if (file_exists($ruta_recursos.$value['recurso3'])) {*/
						$rec3 = "<a href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso3']."' id='recurso_".$value['orden']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*} else {
						$rec3 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					}*/
					/*####################################################*/
				}

				if ($value['recurso4'] == "" || $value['recurso4'] == null) {
					$rec4 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
				} else {
					/*####################################################*/
					/*if (file_exists($ruta_recursos.$value['recurso4'])) {*/
						$rec4 = "<a href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso4']."' id='recurso_".$value['orden']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
					/*} else {
						$rec4 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
					}*/
					/*####################################################*/
				}

                if ($value['recurso5'] == "" || $value['recurso5'] == null) {
                    $rec5 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
                } else {
                	/*####################################################*/
                    /*if (file_exists($ruta_recursos.$value['recurso5'])) {*/
                        $rec5 = "<a href='".$recursos."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso5']."' id='recurso_".$value['orden']."' target='_blank'><i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size: 50px;'></i></a>";
                    /*} else {
                        $rec5 = "<i class='fa fa-lock' aria-hidden='true' style='font-size: 50px;'></i>";
                    }*/
                    /*####################################################*/
                }

				$tabla.="<tr><td><img src='".$icono."' class='img-fluid'></td><td>".$nombre."</td><td>".$rec1."</td><td>".$rec2."</td><td>".$rec3."</td><td>".$rec5."</td><td>".$rec4."</td></tr>";
			}
			$this->renderJSON(array("contenido"=>$tabla,"r"=>$recursos));
			
		}

		public function leccion() {
			$id = $_POST['id'];
			$leccion = (new Administrador())->obtenerLeccion($id);
			$this->renderJSON(array("leccion"=>$leccion[0]['leccion']."_".$leccion[0]['nivel']));
		}

		public function mostrar_grupos() {
			if ($_SESSION['perfil'] == 3) {
				$instituciones = (new Administrador())->institucion_cliente($_SESSION['idUsuario']);
				$lista = "";
				foreach ($instituciones as $key => $value) {
					if ($key == 0) {
						$lista.= $value['LGF0270001'];
					} else {
						$lista.= ", ".$value['LGF0270001'];
					}
				}
				$grupos = (new Administrador())->docente_grupos($lista);
			} else {
				$docente = $_POST['docente'];
				if ($docente == "") {
					$grupos = (new Administrador())->docente_grupos();
				} else {
					$grupos = (new Administrador())->docente_grupos($docente);
				}
			}
			
			$tabla = "";
			$clase = "preescolar";
			if (empty($grupos)) {
				$error = 1;
			} else {
				$error = 0;
			}
			$color = "#000";
			foreach ($grupos as $grupo) {
				if ($grupo['nivelid'] == 2) {
					$clase = "primaria";
				} else if ($grupo['nivelid'] == 3) {
					$clase = "secundaria";
				}
				if ($docente != "") { // vista del docente
					$tabla.="<tr><td>".$grupo['grupo']."</td><td>".$grupo['alumnos']."</td><td class='".$clase."'>".$grupo['nivel']."</td><td class='".$clase."'>".$grupo['lecciones']."</td><td class='".$clase."'><a href='".CONTEXT."home/guides/".$grupo['modulo']."/".$grupo['id']."' style='color: ".$color.";'>Guías</a></td><td class='".$clase."'><a href='".CONTEXT."home/means/".$grupo['modulo']."/".$grupo['id']."' style='color: ".$color.";'>Recursos</a></td><td class='".$clase."'><a href='".CONTEXT."home/results/".$grupo['id']."/".$grupo['nivelid']."' style='color: ".$color.";'>Reportes</a></td></tr>";
				} else { // vista del admin
					if ($grupo['nivel'] == "" || $grupo['nivel'] == null) {
						$nivel = "S/A";
					} else {
						$nivel = $grupo['nivel'];
					}

					$tabla.="<tr><td><a href='".CONTEXT."admin/editGroup/".$grupo['id']."'>".$grupo['grupo']."</a></td><td>".$grupo['alumnos']."</td><td class='".$clase."'>".$nivel."</td><td class='".$clase."'>".(empty($grupo['docente']) ? "Sin docente asignado" : $grupo['docente'])."</td></td><td class='".$clase."'><a href='".CONTEXT."home/results/".$grupo['id']."/".$grupo['nivelid']."' style='color: ".$color.";'>Reportes</a></td></tr>";
				}
			}
			$this->renderJSON(array("contenido" => $tabla, "error" => $error));
		}

		public function mostrar_grupo() {
			$usuario = $_POST['usuario'];
			$accion = $_POST['accion'];
			
			if ($accion == "exportar") {
				$grupos = (new Administrador())->obtener_grupos($_POST['id']);
			} else {
				$institucion = (new Administrador())->informacion_usuario($usuario);
				$institucionid = $institucion[0]['LGF0010038'];
				$grupos = (new Administrador())->obtener_grupos($institucionid);
			}
			// echo "ID: ".$institucionid."\n";
			// print_r($grupos);
			if (count($grupos) > 0) {
				$this->renderJSON(array("respuesta"=>0, "contenido"=>$grupos));
			} else {
				$this->renderJSON(array("respuesta"=>1, "contenido"=>"No hay grupos"));
			}
		}

		public function asignar_grupo() {
			$usuario = $_POST['usuario'];
			$grupo = $_POST['grupo'];
			$data = array(
				"LGF0290006" => $usuario
			);

			$respuesta = (new Grupos())->updateGrupo((object) $data, (object) array (
				"LGF0290001" => $grupo
			));
			if ($respuesta) {
				$this->renderJSON(array("error"=>0, "mensaje" => "Docente asignado correctamente"));
			} else {
				$this->renderJSON(array("error"=>1, "mensaje" => "Ha ocurrido un error al actualizar la información del grupo."));
			}
		}

		public function importar_datos() {
			date_default_timezone_set('America/Mexico_City');
			$file = $_FILES['archivo']; 
			$file = file_get_contents($file['tmp_name']);
			$file = explode("\n", $file);
			$file = array_filter($file);
			
			for ($i=0; $i < count($file); $i++) { 
				$file[$i] = trim($file[$i], ",");
				$file[$i] = trim($file[$i]);
			}
			$file = array_filter($file);
			/*for ($i=0; $i < count($file); $i++) { 
				$file[$i] = trim($file[$i], ",");
				$file[$i] = trim($file[$i]);
			}

			$file = array_filter($file);*/

			switch ($_POST['opcion']) {
				case '1': // Importar usuarios
					$modulo = (new Administrador())->informacionGrupo($_POST['grupoxp']);
					if ($modulo[0]['modulo'] == 1) {
						$nivel = 1;
					} else if ($modulo[0]['modulo'] >= 2 && $modulo[0]['modulo'] <= 7) {
						$nivel = 2;
					} else if ($modulo[0]['modulo'] >= 8 && $modulo[0]['modulo'] <= 10) {
						$nivel = 3;
					}
					
					$usuarios = array();
					for ($i=1; $i < count($file); $i++) { 
						$usuarios[] = explode(",", $file[$i]);
					}

					$usuarios = $this->convertirutf8($usuarios);
					$no_registrados= array();
					$registrados= array();
					for ($i=0; $i < count($usuarios); $i++) { 
						if ($usuarios[$i][7] == "") {
							$no_registrados[] = array(
								"Nombre" => $usuarios[$i][0],
								"Apellido_Paterno" => $usuarios[$i][1],
								"Apellido_Materno" => $usuarios[$i][2],
								"Genero" => $usuarios[$i][3],
								"Email" => $usuarios[$i][4],
								"Usuario" => $usuarios[$i][5],
								"Contraseña" => $usuarios[$i][6],
								"CURP" => $usuarios[$i][7],
								"Motivo" => "CURP no proporcionada"
							);
						} else {
							$registrados[] = array(
								0 => $usuarios[$i][0],
								1 => $usuarios[$i][1],
								2 => $usuarios[$i][2],
								3 => $usuarios[$i][3],
								4 => $usuarios[$i][4],
								5 => $usuarios[$i][5],
								6 => $usuarios[$i][6],
								7 => $usuarios[$i][7]
							);
						}
					}
					$usuarios = array();
					for ($i=0; $i < count($registrados); $i++) { 
						$check = (new Administrador())->check_matricula($registrados[$i][7]);
						if ($check[0]['LGF0010040'] != "") {
							$no_registrados[] = array(
								"Nombre" => $registrados[$i][0],
								"Apellido_Paterno" => $registrados[$i][1],
								"Apellido_Materno" => $registrados[$i][2],
								"Genero" => $registrados[$i][3],
								"Email" => $registrados[$i][4],
								"Usuario" => $registrados[$i][5],
								"Contraseña" => $registrados[$i][6],
								"CURP" => $registrados[$i][7],
								"Motivo" => "CURP existente en sistema"
							);
						} else {
							$usuarios[] = array(
								0 => $registrados[$i][0],
								1 => $registrados[$i][1],
								2 => $registrados[$i][2],
								3 => $registrados[$i][3],
								4 => $registrados[$i][4],
								5 => $registrados[$i][5],
								6 => $registrados[$i][6],
								7 => $registrados[$i][7]
							);
						}
					}
					$cadena = "";
					if (count($no_registrados) > 0) {
						$cadena = json_encode($no_registrados);
					}
					
					$registro = true;
					for ($i=0; $i < count($usuarios); $i++) { 
						$aux = explode(" ", $usuarios[$i][0]);
						$aux1 = explode(" ", $usuarios[$i][1]);
						if (count($aux) > 0) {
							$username = $aux[0];
						} else {
							$username = $usuarios[$i][0];
						}
						if (count($aux1) > 0) {
							$username.=".".$aux1[0];
						} else {
							$username.=".".$usuarios[$i][1];
						}
						$username = $usuarios[$i][5];
						$pass = strtolower($usuarios[$i][5]);
						$password = sha1(strtolower($usuarios[$i][5]));
						$usuarios[$i][5] = $_POST['institucionexp']; // Institución
						$usuarios[$i][6] = $_POST['grupoxp']; // Grupo
						$usuarios[$i][7] = $nivel; // Nivel inicial del grupo
						$usuarios[$i][8] = $_POST['moduloexp']; // Modulo inicial del grupo
						$usuarios[$i][9] = 1; // Numero de lección inicial
						$usuarios[$i][10] = $username; // Username
						$usuarios[$i][11] = $password; // Contraseña
						$usuarios[$i][12] = 2; // Perfil del usuario por default 2
						$usuarios[$i][13] = 1; // Activo

						$data = array(
							'LGF0010038' => $usuarios[$i][5],
							'LGF0010007' => 2,
							'LGF0010002' => $usuarios[$i][0],
							'LGF0010003' => $usuarios[$i][1],
							'LGF0010004' => $usuarios[$i][2],
							'LGF0010022' => null,
							'LGF0010012' => $usuarios[$i][4],
							'LGF0010005' => $username,
							'LGF0010006' => $password,
							'LGF0010008' => 1,
							'LGF0010030' => date('Y-m-d H:i:s'),
							"LGF0010009" => null,
							'LGF0010031' => $this->userid,
							"LGF0010039" => $usuarios[$i][6],
							"LGF0010021" => $usuarios[$i][3],
							"LGF0010023" => $usuarios[$i][7],
							"LGF0010024" => $usuarios[$i][8],
							"LGF0010025" => 1,
							"LGF0010026" => 1
						);

						$respuesta = (new Usuarios())->agregarUsuario((object) $data);
						if ($respuesta) {
							$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$pass, "LGF0330003"=>2);
							$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
							$registro = true;
						} else {
							$registro = false;
						}
					}

					if ($registro) {
						$this->renderJSON(array("error"=>0,"mensaje" => "Usuarios importados exitosamente.", "data"=>$cadena));
					} else {
						$this->renderJSON(array("error"=>1,"mensaje" => "Error al importar usuarios, verifique que el archivo CSV no este dañado.", "data"=>$cadena));
					}
				break;
				case '2': // Importar instituciones
					$datos = array();
					for ($i=1; $i < count($file); $i++) { 
						$datos[] = explode(",", $file[$i]);
					}
					$datos = $this->convertirutf8($datos);

					$modulos = (new Administrador())->obtener_modulos();
					$listaM = "";
					foreach ($modulos as $key => $value) {
						if ($key == 0) {
							$listaM = $value['LGF0150001'];
						} else {
							$listaM.="|".$value['LGF0150001'];
						}
					}

					$adicional = array();
					for ($i=0; $i < count($datos); $i++) { 
						if ($datos[$i][6] == "" || $datos[$i][6] == null) {
							$datos[$i][6] = $listaM;
						}
						if ($datos[$i][7] != "") {
							$aux = explode("/", $datos[$i][7]);
							$fechaIn = $aux[2]."-".$aux[1]."-".$aux[0];
							$fecha_inicio = $fechaIn." ".date("H:i:s");
						} else {
							$fecha_inicio = date("Y-m-d H:i:s");
						}

						if ($datos[$i][8] != "") {
							$aux = explode("/", $datos[$i][8]);
							$fechaFin = $aux[2]."-".$aux[1]."-".$aux[0];
							$fechaFin = $fechaFin." ".date("H:i:s");
						} else {
							$nuevafecha = strtotime('+1 month', strtotime($fecha_inicio));
							$fecha_fin = date('Y-m-d H:i:s', $nuevafecha);
						}
						$password = $datos[$i][5];
						$data = array(
							'LGF0270002' => $datos[$i][0], // Nombre
							'LGF0270022' => $datos[$i][1], // Nombre corto
							'LGF0270016' => $this->userid, // ID Usuario alta
							'LGF0270013' => date("Y-m-d H:i:s"), // Fecha de creacion
							'LGF0270010' => $_POST['paisexp'], // Pais
							'LGF0270021' => $_POST['clienteexp'], // ID Cliente
							'LGF0270019' => $datos[$i][2], // Licencias contratadss
							'LGF0270020' => $datos[$i][3], // Login URL
							'LGF0270012' => 1, // Activo/Inactivo
							'LGF0270005' => $fecha_fin, // Fecha termino
							'LGF0270004' => $fecha_inicio, // Fecha inicio
							'LGF0270023' => 4, // ID Perfil 4 -> Institución
							'LGF0270024' => $datos[$i][4], // Usuario
							'LGF0270025' => sha1($password) // Contraseña
						);

						$respuesta = (new Instituciones())->agregarInstitucion((object) $data);
						
						$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$password, "LGF0330003"=>2);
						$respuesta1 = (new PasswordReset())->agregarPassUsuario((object) $recover);
						
						$auxMod = explode("|", $datos[$i][6]);
						
						for ($j=0; $j < count($auxMod); $j++) { 
							$data_modulo_institucion = array(
								"LGF0300002" => $respuesta,
								"LGF0300003" => $auxMod[$j]
							);
							$modulo_institucion = (new ModuloInstitucion())->addModuloInst((object) $data_modulo_institucion);
						}

					}
					$this->renderJSON(array("error"=>0,"mensaje" => "Instituciones importadas exitosamente."));
				break;
			}
		}

		// Funcion para convertir caracteres en utf8
		private function convertirutf8($array) {
			header("Content-Type: text/html; charset=utf-8");
			array_walk_recursive($array, function (&$item, $key){
				if (!mb_detect_encoding($item, 'utf-8', true)) {
					$item = utf8_encode($item);
				}
			});
			return $array;
		}

		private function eliminar_acentos($cadena) {
		    //Ahora reemplazamos las letras
		    $cadena = str_replace(
		        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
		        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
		        $cadena
		    );

		    $cadena = str_replace(
		        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
		        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
		        $cadena );

		    $cadena = str_replace(
		        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
		        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
		        $cadena );

		    $cadena = str_replace(
		        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
		        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
		        $cadena );

		    $cadena = str_replace(
		        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
		        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
		        $cadena );

		    $cadena = str_replace(
		        array('ñ', 'Ñ', 'ç', 'Ç', ':', ',', "'", '"', ',', '_'),
		        array('n', 'N', 'c', 'C',  '',  '',  '',  '',  '',  ''),
		        $cadena
		    );

		    return $cadena;
		}

		public function super_unique($array) {
		    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
		    foreach ($result as $key => $value) {
		        if (is_array($value)) {
		            $result[$key] = self::super_unique($value);
		        }
		    }
		    return $result;
		}

		public function obtenerDocentes() {
			$buscar = $_POST['buscar'];
			$buscar = strtolower($buscar);
			$campo = $_POST['campo'];
			
			$docentes = (new Administrador())->docentes();
			$grupos = "";
			foreach ($docentes as $key => $docente) {
				if ($docente['usuarioid'] == $docente['usuarioid']) {
					$data[] = array(
						'usuarioid' => $docente['usuarioid'],
						'nombre' => $docente['nombre']
					);
				}
			}

			$teachers = $this->super_unique($data);
			foreach ($teachers as $key => $docente) {
				$grupos = "";
				$alumnos = "";
				$nivel = "";
				$gruposid = "";
				$moduloid = "";
				foreach ($docentes as $key1 => $docent) {
					if ($docent['nivel'] == "" || $docent['nivel'] == null) {
						$docent['nivel'] = 0;
					}
					if ($docente['usuarioid'] == $docent['usuarioid']) {
						if ($key1 == 0) {
							$gruposid = $docent['grupoid'];
							$grupos = $docent['gruponame'];
							$alumnos = $docent['alumnos'];
							$nivel = $docent['nivel'];
							$moduloid = $docent['moduloid'];
						} else {
							$gruposid.= ",".$docent['grupoid'];
							$grupos.= ",".$docent['gruponame'];
							$alumnos.= ",".$docent['alumnos'];
							$nivel.= ",".$docent['nivel'];
							$moduloid.= ",".$docent['moduloid'];
						}
					}
				}
				
				$newData[] = array(
					'usuarioid' => $docente['usuarioid'],
					'nombre' => $docente['nombre'],
					'grupo' => trim($grupos, ","),
					'alumnos' => trim($alumnos, ","),
					'nivel' => trim($nivel, ","),
					'gruposid' => trim($gruposid, ","),
					'moduloid' => trim($moduloid, ","),
				);
			}

			$posiciones = array();
			if (!empty($buscar)) {
				foreach ($newData as $key => $value) {
					if (strpos(strtolower($value['nombre']), $buscar) !== false) {
						array_push($posiciones, $key);
					}
					if (strpos(strtolower($value['grupo']), $buscar) !== false) {
						array_push($posiciones, $key);
					}
				}
				// echo "<pre>";
				// print_r($posiciones);
				// echo "</pre>";
				$posiciones = self::super_unique($posiciones);
				$data = array();
				for ($i=0; $i < count($posiciones); $i++) {
					$data[] = $newData[$posiciones[$i]];
				}
			} else {
				$data = $newData;
			}
			
			$this->renderJSON(array("cuerpo" => $data));
		}
		
		public function obtener_clase($nivel) {
		    if ($nivel == 1) {
		      $clase = "preescolar";
		    } else if ($nivel >= 2 && $nivel <= 7) {
		      $clase = "primaria";
		    } else if ($nivel >= 8 && $nivel <= 10) {
		      $clase = "secundaria";
		    } else {
		      $clase = "complemento";
		    }
		    return $clase;
		}

		public function convertir_modulo_grado($modulo) {
			if ($modulo == 1) {
		      $grado = "3° Preescolar";
		    } elseif ($modulo >= 2 && $modulo <= 7) {
		      $grado = ($modulo - 1)."° Primaria";
		    } else {
		      switch ($modulo) {
		        case '8':
		          $grado = "1 ° Secundaria";
		        break;
		        case '9':
		          $grado = "2 ° Secundaria";
		        break;
		        case '10':
		          $grado = "3 ° Secundaria";
		        break;
		      }
		    }
		    return $grado;
		}

		public function validarMatricula() {
			$matricula = $_POST['matricula'];
			$id = $_POST['clave'];
			$check = (new Administrador())->check_matricula($matricula);
			if (empty($check)) {
				$this->renderJSON(array("error" => 0));
			} else {
				if ($check[0]['LGF0010001'] == $id) {
					$this->renderJSON(array("error" => 0));
				} else {
					$this->renderJSON(array("error" => 1));
				}
			}
		}

		public function mostrarLecciones() {
			$modulo = $_POST['modulo'];
			$accion = $_POST['accion'];

			$tabla = "";
			/*if ($modulo != "") {
				$modulo = "WHERE LGF0160004 = ".$modulo;
			}*/
			$respuesta = (new Administrador())->mostrarLecciones($modulo);
			if ($accion == 1) { // Tabla lecciones
				if (count($respuesta) > 0) {
					$iconos = ARCHIVO_FISICO."iconosLecciones/";
					foreach ($respuesta as $resp) {
						if ($resp['LGF0160005'] == 1) {
							$estatus = "Activo";
						} else {
							$estatus = "Inactivo";
						}

						if ($resp['LGF0160004'] == 1) {
							$nameModulo = "3° Preescolar";
						} else if ($resp['LGF0160004'] >= 2 && $resp['LGF0160004'] <= 7) {
							$nameModulo = ($resp['LGF0160004'] - 1)."° Primaria";
						} else if ($resp['LGF0160004'] >= 8) {
							switch ($resp['LGF0160004']) {
								case '8':
									$nameModulo = "1° Secundaria";
								break;
								case '9':
									$nameModulo = "2° Secundaria";
								break;
								case '10':
									$nameModulo = "3° Secundaria";
								break;
							}
						}

						if ($resp['LGF0160004'] == 1) {
							$nivel = 1;
						} else if ($resp['LGF0160004'] >=2 && $resp['LGF0160004'] <=7) {
							$nivel = 2;
						} else {
							$nivel = 3;
						}
						if ($resp['LGF0160003'] != "" || $resp['LGF0160003'] != null) {
							$principal = $iconos."/n".$nivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007']."/".$resp['LGF0160003'];
						} else {
							$principal = $iconos."icono_temporal.png";
						}
						
						/*if (!file_get_contents($principal)) {
							$principal = $iconos."icono_temporal.png";
						}*/

						if ($resp['LGF0160006'] != "" || $resp['LGF0160006'] != null) {
							$secundario = $iconos."/n".$nivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007']."/".$resp['LGF0160006'];
						} else {
							$secundario = $iconos."icono_temporal.png";
						}
						/*if (!file_get_contents($secundario)) {
							$secundario = $iconos."icono_temporal.png";
						}*/
						// echo "#".$resp['LGF0160007'].")".$principal."\n";
						$tabla.="<tr><td>".$resp['LGF0160007']."</td><td>".$nameModulo."</td><td>".$resp['LGF0160002']."</td><td><img src='".$principal."' class='img-fluid'></td><td style='background-color: lightgray;'><img src='".$secundario."' class='img-fluid'></td><td>".$estatus."</td><td><span><a href='#' onclick='editar(".$resp['LGF0160001'].",".$resp['LGF0160007'].")'><i class='fa fa-pencil' aria-hidden='true'></i> Editar</a></span></td></tr>";
					}
				} else {
					$tabla.="";
				}
			} else if ($accion == 2) { // Listar lecciones
				if (count($respuesta) > 0) {
					$contador = 0;
					$inicio = 0;
					foreach ($respuesta as $resp) {
						if ($resp['LGF0160005'] == 1) {
							$estatus = "Activo";
						} else {
							$estatus = "Inactivo";
						}
						$tabla.="<li id='".$resp['LGF0160001']."' class='list-group-item' data-iden=".$resp['LGF0160001']." data-id=".$resp['LGF0160007']." data-order=".$resp['LGF0160007']." data-inicia='".$inicio."' data-modulo='".$modulo."'><span id='span_".$resp['LGF0160001']."'>".$resp['LGF0160007']." )</span> ".$resp['LGF0160002']."<span class='text-estatus'>".$estatus."</span></li>";
						$contador++;
					}
				}
			} else if ($accion == 3) {
				$tabla = "<div class='row'>";
				foreach ($respuesta as $resp) {
					$tabla.="<div class='col-lg-4' style='text-align: left;'>
						<input type='checkbox' name='tipo[]' id='modulo_".$resp['LGF0160001']."' class='modulos' value='".$resp['LGF0160001']."'>
						<label for='modulo_".$resp['LGF0160001']."'>".$resp['LGF0160002']." (Lección #".$resp['LGF0160007'].")</label>
					</div>";
				}
				$tabla.= "</div>";
			}
			return $this->renderJSON(array('contenido'=>$tabla));
		}

		public function informacionLeccion() {
			$leccion = $_POST['valor'];
			$respuesta = (new Administrador())->informacionLeccion($leccion);
			$informacion = array();
			$iconos = ARCHIVO_FISICO."iconosLecciones/";
			foreach ($respuesta as $resp) {
				if ($resp['LGF0160003'] != "" || $resp['LGF0160003'] != null) {
					$principal = $iconos."/n".$resp['LGF0160004']."/m".$resp['LGF0160004']."/l".$resp['LGF0160007']."/".$resp['LGF0160003'];
				}
				
				if (!file_get_contents($principal)) {
					$principal = $iconos."/icono_temporal.png";
				}

				if ($resp['LGF0160006'] != "" || $resp['LGF0160006'] != null) {
					$secundario = $iconos."/n".$resp['LGF0160004']."/m".$resp['LGF0160004']."/l".$resp['LGF0160007']."/".$resp['LGF0160006'];
				}
				if (!file_get_contents($secundario)) {
					$secundario = $iconos."/icono_temporal.png";
				}
				$informacion = array(
					"nombre" => $resp['LGF0160002'],
					"icono" => $principal,
					"icono2" => $secundario,
					"status" => $resp['LGF0160005'],
					"modulo" => $resp['LGF0160004']
				);
			}
			$this->renderJSON(array("info" => $informacion));
		}

		public function accionesLeccion() {
			$nombre = $_POST['nombre'];
			$nombre = trim($nombre);
			$clave = $_POST['clave'];
			$seccion = $_POST['seccion'];
			$orden = $_POST['orden'];
			$status = $_POST['status'];
			$nmodulo = $_POST['nmodulo'];
			
			$iconoP = $_FILES['iconoP']['name'];
			$iconoS = $_FILES['iconoS']['name'];
            #echo ">>>>>>>>>>>>>>".$iconoP."_______________".$iconoS."<<<<<<<<<<<<<<<<<<<<<<<";
            #echo "Nombre: ".$nombre.", clave: ".$clave.", seccion: ".$seccion.", orden: ".$orden.", status: ".$status.", nmodulo: ".$nmodulo.", clave: ".$clave;
			
			if ($clave == "") {
				$query = " WHERE LGF0160004 = ".$nmodulo;
				$leccion = (new Administrador())->obtenerMaxLecciones($query);
				$orden = ($leccion[0]['num'] + 1);
				if ($nmodulo == 1) {
					$nivel = 1;
				} else if ($nmodulo >= 2 && $nmodulo <= 7) {
					$nivel = 2;
				} else {
					$nivel = 3;
				}

				$arrayRutas = array(
					__DIR__."/../../portal/archivos/iconosLecciones/n".$nivel."/m".$nmodulo."/l".$orden,
					__DIR__."/../../portal/archivos/guiasEstudio/n".$nivel."/m".$nmodulo."/l".$orden,
					__DIR__."/../../portal/archivos/recursosLecciones/n".$nivel."/m".$nmodulo."/l".$orden,
					__DIR__."/../../portal/oda/n".$nivel."/m".$nmodulo."/l".$orden
				);

				// print_r($arrayRutas);
				for ($i=0; $i < count($arrayRutas); $i++) { 
					if(!is_dir($arrayRutas[$i])){
						// echo "Se crea";
					    mkdir($arrayRutas[$i], 0777, true);
						chown($arrayRutas[$i], "root");
						chmod($arrayRutas[$i], 0777);
					}
				}

				$name = self::eliminar_acentos($nombre);
				$data = array(
					'LGF0160002' => $nombre,
					'LGF0160004' => $nmodulo,
					'LGF0160005' => $status,
					'LGF0160007' => $orden
				);

				if ($iconoP != "" && $iconoS != "") {
					$aux = explode(".", $iconoP);
					$aux1 = explode(".", $iconoS);
					$imgP = "PRI".$nmodulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
					$imgS = "PRI".$nmodulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux1[1];

					self::subir_iconos('iconoP', $ruta, $imgP);
					self::subir_iconos('iconoS', $ruta, $imgS);
					$data['LGF0160003'] = $imgP;
					$data['LGF0160006'] = $imgS;
				} else if ($iconoP != "" && $iconoS == "") {
					$aux = explode(".", $iconoP);
					$imgP = "PRI".$nmodulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
					self::subir_iconos('iconoP', $ruta, $imgP);
					$data['LGF0160003'] = $imgP;
				} else if ($iconoP == "" && $iconoS != "") {
					$aux = explode(".", $iconoS);
					// $imgOld = $img
					$imgS = "PRI".$nmodulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux[1];

					self::subir_iconos('iconoS', $ruta, $imgS);
					$data['LGF0160006'] = $imgS;
				}
				/*echo "<pre>";
				print_r($data);
				echo "</pre>";*/
				$respuesta = (new Leccion())->agregarLeccion((object) $data);
				$this->renderJSON(array("error"=>0,"mensaje" => "información actualizada exitosamente."));
			} else {
				$name = self::eliminar_acentos($nombre);

				$cadena = $clave." AND LGF0160002 = '$nombre' AND LGF0160005 = $status";
				$check = (new Administrador())->informacionLeccion($cadena);
				if ($seccion == 1) {
					$nivel = 1;
				} else if ($seccion >= 2 && $seccion <= 7) {
					$nivel = 2;
				} else {
					$nivel = 3;
				}
				// $iconos = ARCHIVO_FISICO."iconosLecciones/n".$seccion."/m".$seccion."/l".$orden."/";
				$ruta = __DIR__."/../../portal/archivos/iconosLecciones/n".$nivel."/m".$seccion."/l".$orden."/";
				if ($seccion == 1) {
					$modulo = 3;
				} else {
					$modulo = ($seccion - 1);
				}

				/*echo $ruta;
				die();*/
				
				$data = array();
				// die();
				if (count($check) == 1) {
					if ($iconoP != "" && $iconoS != "") {
						if ($check[0]['LGF0160003'] != "") {
							unlink($ruta.$check[0]['LGF0160003']);
						}
						if ($check[0]['LGF0160006'] != "") {
							unlink($ruta.$check[0]['LGF0160006']);
						}
						$aux = explode(".", $iconoP);
						$aux1 = explode(".", $iconoS);
						$imgP = "PRI".$modulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
						$imgS = "PRI".$modulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux1[1];

						self::subir_iconos('iconoP', $ruta, $imgP);
						self::subir_iconos('iconoS', $ruta, $imgS);
						$data = array(
							'LGF0160003' => $imgP,
							'LGF0160006' => $imgS
						);
					}
                    else if ($iconoP != "" && $iconoS == "") {
						if ($check[0]['LGF0160003'] != "") {
							unlink($ruta.$check[0]['LGF0160003']);
						}

						$aux = explode(".", $iconoP);
						$imgP = "PRI".$modulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
						self::subir_iconos('iconoP', $ruta, $imgP);
						$data = array(
							'LGF0160003' => $imgP
						);
					}
                    else if ($iconoP == "" && $iconoS != "") {
						if ($check[0]['LGF0160006'] != "") {
							unlink($ruta.$check[0]['LGF0160006']);
						}
						$aux = explode(".", $iconoS);
						// $imgOld = $img
						$imgS = "PRI".$modulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux[1];

						self::subir_iconos('iconoS', $ruta, $imgS);
						$data = array(
							'LGF0160006' => $imgS
						);
					}
					if (!empty($data)) {
						$respuesta = (new Leccion())->actualizarLeccion((object) $data, (object) array (
							"LGF0160001" => $clave
						));
						$this->renderJSON(array("error"=>0,"mensaje" => "información actualizada exitosamente 1."));
					} else {
						$this->renderJSON(array("error"=>0,"mensaje" => "información actualizada exitosamente 2."));
					}
					/*echo "<pre>";
					print_r($data);
					echo "</pre>";*/
				} else {
                    /*################### LLego aqui*/
					if ($iconoP != "" && $iconoS != "") {
						if ($check[0]['LGF0160003'] != "") {
							unlink($ruta.$check[0]['LGF0160003']);
						}
						if ($check[0]['LGF0160006'] != "") {
							unlink($ruta.$check[0]['LGF0160006']);
						}
						$aux = explode(".", $iconoP);
						$aux1 = explode(".", $iconoS);
						$imgP = "PRI".$modulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
						$imgS = "PRI".$modulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux1[1];
                        #echo join('_____', $aux);
                        #echo "imgP".$imgP.">>>>>>>>>>>imgP".$imgP;

						self::subir_iconos('iconoP', $ruta, $imgP);
						self::subir_iconos('iconoS', $ruta, $imgS);
						$data = array(
							'LGF0160003' => $imgP,
							'LGF0160006' => $imgS
						);
					} else if ($iconoP != "" && $iconoS == "") {
						if ($check[0]['LGF0160003'] != "") {
							unlink($ruta.$check[0]['LGF0160003']);
						}

						$aux = explode(".", $iconoP);
						$imgP = "PRI".$modulo."_L".$orden."_".str_replace(" ", "_", $name).".".$aux[1];
						self::subir_iconos('iconoP', $ruta, $imgP);
						$data = array(
							'LGF0160003' => $imgP
						);
					} else if ($iconoP == "" && $iconoS != "") {
						if ($check[0]['LGF0160006'] != "") {
							unlink($ruta.$check[0]['LGF0160006']);
						}
						$aux = explode(".", $iconoS);
						// $imgOld = $img
						$imgS = "PRI".$modulo."_L".$orden."S-".str_replace(" ", "-", $name).".".$aux[1];

						self::subir_iconos('iconoS', $ruta, $imgS);
						$data = array(
							'LGF0160006' => $imgS
						);
					}
					if ($nombre != "") {
						$data['LGF0160002'] = $nombre;
					}
					$data['LGF0160005'] = $status;
					if (!empty($data)) {
						$respuesta = (new Leccion())->actualizarLeccion((object) $data, (object) array (
							"LGF0160001" => $clave
						));
						$this->renderJSON(array("error"=>0,"mensaje" => "información actualizada exitosamente 3."));
					} else {
						$this->renderJSON(array("error"=>0,"mensaje" => "información actualizada exitosamente 4."));
					}
				}
			}
		}

		public function subir_iconos($campo, $ruta, $nombre) {
			$fileTmpPath = $_FILES[$campo]['tmp_name'];
			$fileName = $_FILES[$campo]['name'];
			$fileSize = $_FILES[$campo]['size'];
			$fileType = $_FILES[$campo]['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileName = str_replace(" ", "_", $fileNameCmps[0]);
			$fileExtension = strtolower(end($fileNameCmps));

			$allowedfileExtensions = array('jpg', 'png', 'jpeg', 'PNG');
			if (in_array($fileExtension, $allowedfileExtensions)) {
				$dest_path = $ruta.$nombre;
                #echo "Ruta: ".$ruta;

                if(!file_exists($ruta)){
                    mkdir($ruta, 0777, true);
                }

				if(move_uploaded_file($fileTmpPath, $dest_path)) {
					return 1;
				} else {
					return 0;
				}
			}
		}

		public function ordenarLecciones() {
			$posicion = $_POST['posicion'];
			$id = $_POST['id'];
			$old = $_POST['old'];
			$modulo = $_POST['modulo'];
			
			if (!empty($id)) {
				if ($modulo == 1) {
					$nivel = 1;
				} else if ($modulo >= 2 && $modulo <=7) {
					$nivel = 2;
				} else {
					$nivel = 3;
				}
				/*foreach ($_POST as $key => $value) {
					echo $key." => ".$value."<br>";
				}*/

				$iconos = __DIR__."/../../portal/archivos/iconosLecciones/n".$nivel."/m".$modulo."/";
				$guias = __DIR__."/../../portal/archivos/guiasEstudio/n".$nivel."/m".$modulo."/";
				$recursos = __DIR__."/../../portal/archivos/recursosLecciones/n".$nivel."/m".$modulo."/";
				$oda = __DIR__."/../../portal/oda/n".$nivel."/m".$modulo."/";
				// echo $directorio."<br>";

				$rutaI  = scandir($iconos);
				$rutaOda  = scandir($oda);
				$rutaGuia  = scandir($guias);
				$rutaRecurso  = scandir($recursos);
				$carpetasI = array();
				$carpetasOda = array();
				$carpetasGuia = array();
				$carpetasRecurso = array();
				for ($i=2; $i < count($rutaI); $i++) { 
					array_push($carpetasI, $rutaI[$i]);
				}
				for ($i=2; $i < count($rutaOda); $i++) { 
					array_push($carpetasOda, $rutaOda[$i]);
				}
				for ($i=2; $i < count($rutaGuia); $i++) { 
					array_push($carpetasGuia, $rutaGuia[$i]);
				}
				for ($i=2; $i < count($rutaRecurso); $i++) { 
					array_push($carpetasRecurso, $rutaRecurso[$i]);
				}
				$lista = array();
				$j = 1;
				for ($i=0; $i < count($carpetasI); $i++) { 
					$lista[$j] = "l".($i + 1);
					$j++;
				}

				$odas = array();
				$h = 1;
				for ($i=0; $i < count($carpetasOda); $i++) { 
					$odas[$h] = "l".($i + 1);
					$h++;
				}

				$aguias = array();
				$h = 1;
				for ($i=0; $i < count($carpetasGuia); $i++) { 
					$aguias[$h] = "l".($i + 1);
					$h++;
				}

				$arecursos = array();
				$h = 1;
				for ($i=0; $i < count($carpetasRecurso); $i++) { 
					$arecursos[$h] = "l".($i + 1);
					$h++;
				}

				/*echo "<pre>";
				print_r($lista);
				echo "</pre>";*/

				$oldP = explode(",", $old);
				$newP = explode(",", $posicion);

				if ($newP[0] < $oldP[0]) {
					rename($iconos.$lista[$oldP[0]], $iconos.$lista[$oldP[0]]."_old"); // Renombrar carpetas iconosLecciones
					// $lista[$oldP[0]] = $lista[$oldP[0]]."_old";
					for ($i= $oldP[0]; $i > $newP[0]; $i--) { 
						rename($iconos.$lista[$i - 1], $iconos.$lista[$i]); // Renombrar carpetas iconosLecciones
						/*$lista[$i - 1] = "l#".($i);
						echo "<pre>";
						print_r($lista);
						echo "</pre>";*/
					}
					// $lista[$oldP[0]] = "l".$newP[0];
					rename($iconos.$lista[$oldP[0]]."_old", $iconos.$lista[$newP[0]]); // Renombrar carpetas iconosLecciones

					rename($oda.$odas[$oldP[0]], $oda.$odas[$oldP[0]]."_old"); // Renombrar carpetas ODA
					for ($i= $oldP[0]; $i > $newP[0]; $i--) { 
						rename($oda.$odas[$i - 1], $oda.$odas[$i]); // Renombrar carpetas ODA
					}
					rename($oda.$odas[$oldP[0]]."_old", $oda.$odas[$newP[0]]); // Renombrar carpetas Guias

					rename($guias.$aguias[$oldP[0]], $guias.$aguias[$oldP[0]]."_old"); // Renombrar carpetas Guias
					for ($i= $oldP[0]; $i > $newP[0]; $i--) { 
						rename($guias.$aguias[$i - 1], $guias.$aguias[$i]); // Renombrar carpetas Guias
					}
					rename($guias.$aguias[$oldP[0]]."_old", $guias.$aguias[$newP[0]]); // Renombrar carpetas ODA

					rename($recursos.$arecursos[$oldP[0]], $recursos.$arecursos[$oldP[0]]."_old"); // Renombrar carpetas Recursos
					for ($i= $oldP[0]; $i > $newP[0]; $i--) { 
						rename($recursos.$arecursos[$i - 1], $recursos.$arecursos[$i]); // Renombrar carpetas Recursos
					}
					rename($recursos.$arecursos[$oldP[0]]."_old", $recursos.$arecursos[$newP[0]]); // Renombrar carpetas Recursos
				} else {
					// $lista[$oldP[0]] = $lista[$oldP[0]]."_old";
					/*echo "<pre>";
					print_r($lista);
					echo "</pre>";*/
					rename($iconos.$lista[$oldP[0]], $iconos.$lista[$oldP[0]]."_old"); // Renombrar carpetas iconosLecciones
					for ($i= $oldP[0]; $i < $newP[0]; $i++) { 
						rename($iconos.$lista[$i+1], $iconos.$lista[$i]); // Renombrar carpetas iconosLecciones
						/*$lista[$i+1] = "l#".($i);
						echo "<pre>";
						print_r($lista);
						echo "</pre>";*/
					}
					// $lista[$oldP[0]] = "l".$newP[0];
					rename($iconos.$lista[$oldP[0]]."_old", $iconos.$lista[$newP[0]]); // Renombrar carpetas iconosLecciones

					rename($oda.$odas[$oldP[0]], $oda.$odas[$oldP[0]]."_old"); // Renombrar carpetas ODA
					for ($i= $oldP[0]; $i < $newP[0]; $i++) { 
						rename($oda.$odas[$i+1], $oda.$odas[$i]); // Renombrar carpetas ODA
					}
					rename($oda.$odas[$oldP[0]]."_old", $oda.$odas[$newP[0]]); // Renombrar carpetas ODA

					rename($guias.$aguias[$oldP[0]], $guias.$aguias[$oldP[0]]."_old"); // Renombrar carpetas Guias
					for ($i= $oldP[0]; $i < $newP[0]; $i++) { 
						rename($guias.$aguias[$i+1], $guias.$aguias[$i]); // Renombrar carpetas Guias
					}
					rename($guias.$aguias[$oldP[0]]."_old", $guias.$aguias[$newP[0]]); // Renombrar carpetas Guias

					rename($recursos.$arecursos[$oldP[0]], $recursos.$arecursos[$oldP[0]]."_old"); // Renombrar carpetas Recursos
					for ($i= $oldP[0]; $i < $newP[0]; $i++) { 
						rename($recursos.$arecursos[$i+1], $recursos.$arecursos[$i]); // Renombrar carpetas Recursos
					}
					rename($recursos.$arecursos[$oldP[0]]."_old", $recursos.$arecursos[$newP[0]]); // Renombrar carpetas Recursos
				}

				/*echo "<pre>";
				print_r($lista);
				echo "</pre>";
				die();*/

				$aux = explode(",", $posicion);
				$aux1 = explode(",", $id);
				for ($i=0; $i < count($aux); $i++) { 
					$up['LGF0160007'] = $aux[$i];
					// echo $up['LGF0160007']." --- ".$aux1[$i]."<br>";
					$respuesta = (new Leccion())->actualizarLeccion((object) $up, (object) array (
						"LGF0160001" => $aux1[$i]
					));
				}
				$this->renderJSON(array("res"=>true));
			}
		}

		public function migrarLecciones1() {
			$oldModulo = $_POST["oldM"];
			$newModulo = $_POST["newM"];
			$lecciones = $_POST["leccion"];
			// $lecciones = "17,20,103";

			// foreach ($_POST as $key => $value) {
			// 	echo $key." => ".$value."<br>";
			// }

			if ($oldModulo == 1) {
				$oldNivel = 1;
			} else if ($oldModulo >= 2 && $oldModulo <= 7) {
				$oldNivel = 2;
			} else {
				$oldNivel = 3;
			}

			if ($newModulo == 1) {
				$newNivel = 1;
			} else if ($newModulo >= 2 && $newModulo <= 7) {
				$newNivel = 2;
			} else {
				$newNivel = 3;
			}

			$respuesta = (new Administrador())->informacionLeccion($lecciones);
			$nModulo = (new Administrador())->modulos($newModulo);
			if (count($respuesta)==1) {
				$texto = "Se migro la lección <b>".$respuesta[0]['LGF0160002']."<b> al módulo <b>".$nModulo[0]['nombre']."</b> exitosamente";
			} else {
				foreach ($respuesta as $key => $value) {
					if ($key == 0) {
						$lec = $value['LGF0160002'];
					} else {
						$lec.=",".$value['LGF0160002'];
					}
				}
				$texto = "Se migraron la lecciones <b>".$lec."<b> al módulo <b>".$nModulo[0]['nombre']."</b> exitosamente";
			}
			// Paso A) Obtener ruta de los viejos y nuevos directorios
			$oldDirIconos = array();
			$oldDirGuias = array();
			$oldDirRecursos = array();
			$oldDirOdas = array();
			foreach ($respuesta as $resp) {
				$rutaIconos = __DIR__."/../../portal/archivos/iconosLecciones/n".$oldNivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007'];
				$rutaGuias = __DIR__."/../../portal/archivos/guiasEstudio/n".$oldNivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007'];
				$rutaRecursos = __DIR__."/../../portal/archivos/recursosLecciones/n".$oldNivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007'];
				$rutaOdas = __DIR__."/../../portal/oda/n".$oldNivel."/m".$resp['LGF0160004']."/l".$resp['LGF0160007'];
				if (is_dir($rutaIconos)) {
					array_push($oldDirIconos, $rutaIconos);
				}
				if (is_dir($rutaGuias)) {
					array_push($oldDirGuias, $rutaGuias);
				}
				if (is_dir($rutaRecursos)) {
					array_push($oldDirRecursos, $rutaRecursos);
				}
				if (is_dir($rutaOdas)) {
					array_push($oldDirOdas, $rutaOdas);
				}
			}
			/*echo "<pre>";
			print_r($oldDirIconos);
			print_r($oldDirGuias);
			print_r($oldDirRecursos);
			print_r($oldDirOdas);
			echo "</pre>";*/

			$query = " WHERE LGF0160004 = ".$newModulo;
			$maxLeccionesNewModulo = (new Administrador())->obtenerMaxLecciones($query);
			$newDirIconos = array();
			$newDirGuias = array();
			$newDirRecursos = array();
			$newDirOdas = array();

			for ($i= ($maxLeccionesNewModulo[0]['num'] +1); $i <= ($maxLeccionesNewModulo[0]['num'] + count($respuesta)); $i++) { 
				$ruta = __DIR__."/../../portal/archivos/iconosLecciones/n".$newNivel."/m".$newModulo."/l".$i;
				array_push($newDirIconos, $ruta);
				$rutaG = __DIR__."/../../portal/archivos/guiasEstudio/n".$newNivel."/m".$newModulo."/l".$i;
				array_push($newDirGuias, $rutaG);
				$rutaR = __DIR__."/../../portal/archivos/recursosLecciones/n".$newNivel."/m".$newModulo."/l".$i;
				array_push($newDirRecursos, $rutaR);
				$rutaO = __DIR__."/../../portal/oda/n".$newNivel."/m".$newModulo."/l".$i;
				array_push($newDirOdas, $rutaO);
			}

			/*echo "**********<pre>";
			print_r($newDirIconos);
			print_r($newDirGuias);
			print_r($newDirRecursos);
			print_r($newDirOdas);
			echo "</pre>";*/
			// die();


			// Paso 1) Actualizar lecciones a mover con el nuevo modulo y posicion
			$query = " WHERE LGF0160004 = ".$newModulo;
			$leccion = (new Administrador())->obtenerMaxLecciones($query);
			$cont = ($leccion[0]['num']);
			for ($i=0; $i < count($respuesta); $i++) { 
				$cont++;
				$respuesta[$i]['LGF0160004'] = $newModulo;
				$respuesta[$i]['LGF0160007'] = $cont;

				$ok = (new Leccion())->actualizarLeccion((object) $respuesta[$i], (object) array (
					"LGF0160001" => $respuesta[$i]['LGF0160001']
				));
			}

			// Paso 1.1) Mover los antiguos directorios por los nuevos
			if (!empty($oldDirIconos)) {
				for ($i=0; $i < count($oldDirIconos); $i++) { 
					rename($oldDirIconos[$i], $newDirIconos[$i]);
				}
			}

			if (!empty($oldDirGuias)) {
				for ($i=0; $i < count($oldDirGuias); $i++) { 
					rename($oldDirGuias[$i], $newDirGuias[$i]);
				}
			}

			if (!empty($oldDirRecursos)) {
				for ($i=0; $i < count($oldDirRecursos); $i++) { 
					rename($oldDirRecursos[$i], $newDirRecursos[$i]);
				}
			}

			if (!empty($oldDirOdas)) {
				for ($i=0; $i < count($oldDirOdas); $i++) { 
					rename($oldDirOdas[$i], $newDirOdas[$i]);
				}
			}

			// Paso 2) Actualizar modulo de origen con las nuevas posiciones en BD y directorios
			$oldLecciones = (new Administrador())->mostrarLecciones($oldModulo);
			$ordenOldiconos = array();
			$ordenNewiconos = array();
			$ordenOldGuias = array();
			$ordenNewGuias = array();
			$ordenOldRecursos = array();
			$ordenNewRecursos = array();
			$ordenOldOdas = array();
			$ordenNewOdas = array();
			$cont = 1;
			foreach ($oldLecciones as $lec) {
				array_push($ordenOldiconos, __DIR__."/../../portal/archivos/iconosLecciones/n".$oldNivel."/m".$lec['LGF0160004']."/l".$lec["LGF0160007"]);
				array_push($ordenNewiconos, __DIR__."/../../portal/archivos/iconosLecciones/n".$oldNivel."/m".$lec['LGF0160004']."/l".$cont);

				array_push($ordenOldGuias, __DIR__."/../../portal/archivos/guiasEstudio/n".$oldNivel."/m".$lec['LGF0160004']."/l".$lec["LGF0160007"]);
				array_push($ordenNewGuias, __DIR__."/../../portal/archivos/guiasEstudio/n".$oldNivel."/m".$lec['LGF0160004']."/l".$cont);

				array_push($ordenOldRecursos, __DIR__."/../../portal/archivos/recursosLecciones/n".$oldNivel."/m".$lec['LGF0160004']."/l".$lec["LGF0160007"]);
				array_push($ordenNewRecursos, __DIR__."/../../portal/archivos/recursosLecciones/n".$oldNivel."/m".$lec['LGF0160004']."/l".$cont);

				array_push($ordenOldOdas, __DIR__."/../../portal/oda/n".$oldNivel."/m".$lec['LGF0160004']."/l".$lec["LGF0160007"]);
				array_push($ordenNewOdas, __DIR__."/../../portal/oda/n".$oldNivel."/m".$lec['LGF0160004']."/l".$cont);
				$cont++;
			}
			$inicia = 1;
			for ($i=0; $i < count($oldLecciones); $i++) { 
				$oldLecciones[$i]['LGF0160007'] = $inicia;
				// echo $i.") ".$ordenOldGuias[$i]." <br>$i) ".$ordenNewGuias[$i]."<br>";
				$ok = (new Leccion())->actualizarLeccion((object) $oldLecciones[$i], (object) array (
					"LGF0160001" => $oldLecciones[$i]['LGF0160001']
				));
				rename($ordenOldiconos[$i], $ordenNewiconos[$i]);
				rename($ordenOldGuias[$i], $ordenNewGuias[$i]);
				rename($ordenOldRecursos[$i], $ordenNewRecursos[$i]);
				rename($ordenOldOdas[$i], $ordenNewOdas[$i]);
				$inicia++;
			}

			// Paso 3) Actualizar la estructura de navegacion con la nueva leccion
			if ($newModulo == 1) {
				$newNivel = 1;
			} else if ($newModulo >= 2 && $newModulo <= 7) {
				$newNivel = 2;
			} else {
				$newNivel = 3;
			}
			$query = "WHERE LGF0180003 = $oldModulo AND LGF0180004 in ($lecciones)";
			$eval = (new Administrador())->obtener_evaluaciones($query);
			for ($i=0; $i < count($eval); $i++) { 
				$eval[$i]['LGF0180002'] = $newNivel;
				$eval[$i]['LGF0180003'] = $newModulo;

				$ok = (new EstructuraNavegacion())->actualizarEstructuraNavegacion((object) $eval[$i], (object) array(
					"LGF0180001" => $eval[$i]['LGF0180001']
				));
			}

			// Paso 4) Actualizar campos en guias y recursos
			$_guias = (new Administrador())->guias($oldModulo, $lecciones, 1);
			$_nguias = (new Administrador())->guias($newModulo, $lecciones, 2);
			$guias = ($_nguias[0]['num'] + 1);
			for ($i=0 ; $i < count($_guias); $i++) { 
				$_guias[$i]['LGF0310002'] = $newNivel;
				$_guias[$i]['LGF0310003'] = $newModulo;
				$_guias[$i]['LGF0310005'] = $guias;

				$ok = (new Guias())->actualizarGuia((object) $_guias[$i], (object) array(
					"LGF0310001" => $_guias[$i]['LGF0310001']
				));
				$guias++;
			}
			$_guias = (new Administrador())->guias($oldModulo, $lecciones, 3);
			$guias = 1;
			for ($i=0 ; $i < count($_guias); $i++) { 
				$_guias[$i]['LGF0310005'] = $guias;

				$ok = (new Guias())->actualizarGuia((object) $_guias[$i], (object) array(
					"LGF0310001" => $_guias[$i]['LGF0310001']
				));
				$guias++;
			}
			$_recursos = (new Administrador())->recursos($oldModulo, $lecciones, 1);
			$_nrecursos = (new Administrador())->recursos($newModulo, $lecciones, 2);
			$ordenR = ($_nrecursos[0]['num'] + 1);
			for ($i=0 ; $i < count($_recursos); $i++) { 
				$_recursos[$i]['LGF0320002'] = $newNivel;
				$_recursos[$i]['LGF0320003'] = $newModulo;
				$_recursos[$i]['LGF0320005'] = $ordenR;

				$ok = (new Recurso())->actualizarRecurso((object) $_recursos[$i], (object) array(
					"LGF0320001" => $_recursos[$i]['LGF0320001']
				));
				$ordenR++;
			}

			$_recursos = (new Administrador())->recursos($oldModulo, $lecciones, 3);
			$ordenR = 1;
			for ($i=0 ; $i < count($_recursos); $i++) { 
				$_recursos[$i]['LGF0320005'] = $ordenR;

				$ok = (new Recurso())->actualizarRecurso((object) $_recursos[$i], (object) array(
					"LGF0320001" => $_recursos[$i]['LGF0320001']
				));
				$ordenR++;
			}

			// Paso 5) Actualizar sección de evaluaciones
			$evaluacion = (new Administrador())->obtener_evaluacion($lecciones);
			for ($i=0; $i < count($evaluacion); $i++) { 
				$evaluacion[$i]['LGF0190005'] = $newNivel;
				$evaluacion[$i]['LGF0190006'] = $newModulo;
				$ok = (new Evaluacion ())->actualizarEvaluacion((object) $evaluacion[$i], (object) array(
					"LGF0190001" => $evaluacion[$i]['LGF0190001']
				));
			}
			$this->renderJSON(array("res"=>$texto));
		}

		public function reportime() {
			$tipo = $_POST['tipo']; // 1: Tiempo en plataforma. 2: Tiempo en lecciones
			$combo = $_POST['combo']; // Combo de instituciones
			$lista = (new Administrador())->listarUsuarios($combo);
			// print_r($lista);
			// die();
			// $data = array();
			/*foreach ($lista as $key => $value) {
				$minutos = $this->obtenerTiempos($value['id'], $tipo);
				if ($tipo == 1) {
					$data[] = array(
						"id" => $value['id'],
						"nombre" => $value['LGF0010002']." ".$value['LGF0010003']." ".$value['LGF0010004'],
						"curp" => $value['curp'],
						"cct" => $value['cct'],
						"ins" => ((empty($value['ins'])) ? "S/A" : $value['ins']),
						"tiempo" => $this->seg_a_dhms($minutos)
					);
				} else {
					$data[] = array(
						"id" => $value['id'],
						"nombre" => $value['LGF0010002']." ".$value['LGF0010003']." ".$value['LGF0010004'],
						"curp" => $value['curp'],
						"cct" => $value['cct'],
						"ins" => ((empty($value['ins'])) ? "S/A" : $value['ins']),
						"tiempo" => $this->seg_a_dhms($minutos[0]['minutos']),
						"nivel" => (empty($minutos[0]['nivel']) ? "N/A" : $minutos[0]['nivel']),
						"modulo" => (empty($minutos[0]['modulo']) ? "N/A" : $minutos[0]['modulo']),
						"leccion" => (empty($minutos[0]['leccion']) ? "N/A" : $minutos[0]['leccion'])
					);
				}
			}*/
			$data = array();
			foreach ($lista as $key => $value) {
				array_push($data, array(
					'id' => $value['id'],
					'nombre' => $value['LGF0010002']." ".$value['LGF0010003']." ".$value['LGF0010004'],
					'curp' => $value['curp'],
					'ins' => $value['ins'],
					'cct' => $value['cct']
				));
			}
			$data = $this->super_unique($data);

			$newData = array();
			foreach ($data as $k => $val) {
				$total = 0;	
				foreach ($lista as $key => $value) {
					if ($value['id'] == $val['id']) {
						$minutos = $this->minutosTranscurridos($value['inicio'], $value['fin']);
						$total = $total + $minutos;
					}
				}
				$data[$k]['tiempo'] = $this->seg_a_dhms($total);
			}
			
			$this->renderJSON(array("res"=>$data));
		}

		public function obtenerTiempos($id, $tipo) {
			$total = 0;
			$fechaI = "";
			$fechaF = "";
			$tiempo = (new Administrador())->logregistros($id, $tipo, $fechaI, $fechaF);
			if ($tipo == 1) {
				foreach ($tiempo as $key => $tmp) {
					if ($tmp['LGF0360005'] != "") {
						$minutos = $this->minutosTranscurridos($tmp['LGF0360004'], $tmp['LGF0360005']);
						$total = $total + $minutos;
					}
				}
				return $total;
			} else {
				foreach ($tiempo as $key => $tmp) {
					if ($tmp['LGF0360005'] != "") {
						$minutos = $this->minutosTranscurridos($tmp['LGF0360004'], $tmp['LGF0360005']);
						$total = $total + $minutos;

						$data[] = array(
							"nivel" => $tmp['nivel'],
							"modulo" => $tmp['modulo'],
							"leccion" => $tmp['leccion'],
							"minutos" => $total
						);
					}
				}
				return $data;
			}
		}

		public function seg_a_dhms($seg) { 
			if ($seg == 0) {
				return "Sin actividad";
			} else {
				$dtF = new DateTime("@0");
			    $dtT = new DateTime("@$seg");
			    return $dtF->diff($dtT)->format('%a días, %h horas, %i minutos y %s segundos');
			}
		}

		public function minutosTranscurridos($fecha_i,$fecha_f) {
			$minutos = (strtotime($fecha_i)-strtotime($fecha_f));
			$minutos = abs($minutos);
			$minutos = floor($minutos);
			return $minutos;
		}

		public function subir_datos() {
			$ruta = __DIR__."/../../importar/temp/";
			// $file = file_get_contents($file['tmp_name']);
			$opcion = $_POST['tipo'];
			$nombre = $_FILES['files']['name'];
			$temporal = $_FILES['files']['tmp_name'];
			$aux = explode(".", $nombre);
			$nameFile = str_replace(" ", "_", $aux[0]);
			$nombre_csv = $aux[0]."_".date("H:i:s").".csv";
			$nombre_csv = str_replace(":", "_", $nombre_csv);
			$destino = $ruta.$nombre_csv;

			if($aux[1] != "csv"){
				// echo "N/A";
				$move = 0;
			}else{
				if(move_uploaded_file($temporal, $destino)){
					// echo "Se movio";
					$move = 1;
				}
			}
			if ($move == 1) {
				$x=0;
				$regAdd = 0;
				$noRegistrado = array();
				$fichero=fopen($destino, "r");
				if ($opcion == 1 || $opcion == 3) { // Usuarios
					$noRegistrado = array();
					$usuarios=array();
					while(($datos = fgetcsv($fichero,10000)) != FALSE){
						$x++;
						if($x > 1){
							// Validar campo CURP que no venga vacio desde el Excel
							if (!empty($datos[3])) {
								// Validar CURP existente
								$check = (new Administrador())->check_matricula($datos[3]);
								if (count($check) == 0) {
									// Validar institucion
									$checkR = array('LGF0270028' => $datos[6]);
									$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
									if (!empty($obtenerInstitucion[0]['LGF0270001'])) {
										$username = substr($datos[3], 0, 10);
										
										$totalReg++;
										$modulo = $datos[5];
										$nivel = (new Administrador())->obtener_nivel_modulo($modulo);
										$leccion = (new Administrador())->obtenerLeccion($modulo);
										$idInstitucion = $obtenerInstitucion[0]['LGF0270001'];
										$nick = $username;
										if (isset($datos[8]) && $datos[8] != "") { // fecha de nacimineto
											$aux = explode("/", $datos[8]);
											$fechaN = $aux[2]."-".$aux[1]."-".$aux[0];
										} else {
											$fechaN = null;
										}
										$checkGrupo = (new Grupos())->obtenGrupo((object) array(
											"LGF0290002" => $datos[7], // nombre del grupo,
											"LGF0290004" => $obtenerInstitucion[0]['LGF0270001'], // ID institucion
											"LGF0290005" => $modulo // ID modulo
										));
										if (!empty($checkGrupo[0]['LGF0290001'])) {
											$grupo = $checkGrupo[0]['LGF0290001'];
										} else {
											$grupo = null;
										}
										$usuarios[] = array(
											'LGF0010002' => (!empty($datos[0]) ? utf8_encode($datos[0]) : null), // nombre
											'LGF0010003' => (!empty($datos[1]) ? utf8_encode($datos[1]) : null), // ape Paterno
											'LGF0010004' => (!empty($datos[2]) ? utf8_encode($datos[2]) : null), // ape Materno
											'LGF0010005' => $nick, // user
											'LGF0010006' => sha1($nick), // password
											'LGF0010007' => ($opcion == 1 ? 2 : 6), // perfil 2.- Alumno 6.- Docente
											'LGF0010008' => 1, // activo/inactivo
											'LGF0010021' => $datos[4], // genero
											'LGF0010023' => $nivel[0]['nivel'], // nivel
											'LGF0010024' => $modulo, // modulo/grado escolar
											'LGF0010025' => $leccion[0]['leccion'], // leccion
											'LGF0010026' => 1, // seccion actual
											'LGF0010030' => date("Y-m-d H:i:s"), // fecha y hora de creacion
											'LGF0010038' => $idInstitucion, // institucion
											'LGF0010039' => $grupo, // institucion
											'LGF0010040' => $datos[3] // curp
										);
									} else {
										array_push($noRegistrado, array(
											"Nombre" => utf8_encode($datos[0]),
											"ApellidoPaterno" => utf8_encode($datos[1]),
											"ApellidoMaterno" => utf8_encode($datos[2]),
											"Genero" => $datos[4],
											"CURP" => $datos[3],
											"GradoEscolar" => $datos[5],
											"Insitucion" => $datos[6],
											"Motivo" => "La institución con el C.C.T ".$datos[6]." no se encuentra registrada en el sistema."
										));
									}
								} else {
									array_push($noRegistrado, array(
										"Nombre" => utf8_encode($datos[0]),
										"ApellidoPaterno" => utf8_encode($datos[1]),
										"ApellidoMaterno" => utf8_encode($datos[2]),
										"Genero" => $datos[4],
										"CURP" => $datos[3],
										"GradoEscolar" => $datos[5],
										"Insitucion" => $datos[6],
										"Motivo" => "La siguiente CURP ".$datos[3]." ya se encuentra registrada en el sistema."
									));
								}
							} else {
								array_push($noRegistrado, array(
									"Nombre" => utf8_encode($datos[0]),
									"ApellidoPaterno" => utf8_encode($datos[1]),
									"ApellidoMaterno" => utf8_encode($datos[2]),
									"Genero" => $datos[4],
									"CURP" => $datos[3],
									"GradoEscolar" => $datos[5],
									"Insitucion" => $datos[6],
									"Motivo" => "La columna CURP se encuentra vacía, favor de verificar bien los datos."
								));
							}
						}
					}
					fclose($fichero);
					unlink($destino);
					// die();
					if (count($usuarios) > 0) {
						$totalReg = count($usuarios);
						$regAdd = 0;
						for ($i=0; $i < count($usuarios); $i++) {
							// Validación de CURP
							$check = (new Administrador())->check_matricula($usuarios[$i]['LGF0010040']);
							if (count($check) == 0) {
								$usuarios[$i]['LGF0010005'] = $this->validarUsuario($usuarios[$i]['LGF0010005']);
								$usuarios[$i]['LGF0010006'] = sha1($usuarios[$i]['LGF0010005']);
								// print_r($usuarios[$i]);
								$respuesta = (new Usuarios())->agregarUsuario((object) $usuarios[$i]);
								// echo "Respuesta: ".$respuesta;
								if ($respuesta) {
									$regAdd++;
									$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$usuarios[$i]['LGF0010005'], "LGF0330003"=>$usuarios[$i]['LGF0010007']);
									$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
								}
							} else {
								$checkR = array('LGF0270028' => $usuarios[$i]['LGF0010038']);
								$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
								array_push($noRegistrado, array(
									"Nombre" => $usuarios[$i]['LGF0010002'],
									"ApellidoPaterno" => $usuarios[$i]['LGF0010003'],
									"ApellidoMaterno" => $usuarios[$i]['LGF0010004'],
									"Genero" => $usuarios[$i]['LGF0010021'],
									"CURP" => $usuarios[$i]['LGF0010040'],
									"GradoEscolar" => ($usuarios[$i]['LGF0010024'] == 1 ? 1 : ($usuarios[$i]['LGF0010005']-1)),
									"Insitucion" => $obtenerInstitucion[0]['LGF0270028'],
									"Motivo" => "La siguiente CURP ".$usuarios[$i]['LGF0010040']." ya se encuentra registrada en el sistema."
								));
							}
						}
						// echo "</pre>";
						$mensaje = "Se registro un total de ".$regAdd." usuarios de ".$totalReg." registros.";
					} else {
						$mensaje = "no hay registros para importar";
					}

					if (count($noRegistrado) > 0) {
						// $cadena = $this->convertirutf8($noRegistrado);
						$cadena = json_encode($noRegistrado);
					} else {
						$cadena = "";
					}
					$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$cadena));
				} else if ($opcion == 2) { // Instituciones
					$instituciones = array();
					$modulos = "";
					while(($datos = fgetcsv($fichero,1000)) != FALSE){
						$x++;
						if($x > 1){
							$checkR = array('LGF0270028' => $datos[0]);
							// echo "Aqui";
							$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
							if (count($obtenerInstitucion) == 0) {
								$regAdd++;
								$nombre = utf8_encode($datos[1]);
								$fecha_actual = date("Y-m-d H:i:s");
								$fecha_termino = date("Y-m-d H:i:s",strtotime($fecha_actual."+ 1 year"));
								array_push($instituciones, array(
									'LGF0270002' => $nombre, // Nombre
									'LGF0270004' => $fecha_actual, // Fecha de inicio del contrato
									'LGF0270005' => $fecha_termino, // Fecha de termino del contrato
									'LGF0270012' => 1, // Activo/Inactivo
									'LGF0270013' => $fecha_actual, // fecha y hora de creacion
									'LGF0270016' => 1, // usuario que dio de alta
									'LGF0270019' => 10000, // numero de licencias contratadas
									'LGF0270021' => 1, // ID Cliente
									'LGF0270022' => $nombre, // nombre corto
									'LGF0270023' => 4, // ID Perfil => 4 institucion
									'LGF0270024' => trim($datos[0]), // usuario
									'LGF0270025' => sha1(trim($datos[0])), // contraseña
									'LGF0270027' => null, /// correo
									'LGF0270028' => trim($datos[0]), // CCT
									'modulos' => $datos[2],
									'grupos' => $datos[3]
								));
							}
						}
					}
					fclose($fichero);
					unlink($destino);
					
					for ($i=0; $i < count($instituciones); $i++) { 
						$auxMod = explode("|", $instituciones[$i]['modulos']);
						$auxGrupo = explode("|", $instituciones[$i]['grupos']);
						unset($instituciones[$i]['modulos']);
						unset($instituciones[$i]['grupos']);
						$ok = (new Instituciones())->agregarInstitucion((object) $instituciones[$i]);
						if (!empty($auxMod)) {
							// Asignacion de accesos a los modulos por instituciones
							// print_r($auxMod);
							for ($j=0; $j < count($auxMod); $j++) { 
								$modulosIns = array(
									'LGF0300002' => $ok,
									'LGF0300003' => $auxMod[$j]
								);
								$modulo_institucion = (new ModuloInstitucion())->addModuloInst((object) $modulosIns);
								// print_r($modulosIns);
							}
						}
						if (!empty($auxGrupo)) {
							// Asignacion de grupos por instituciones
							for ($j=0; $j < count($auxGrupo); $j++) { 
								$aux = explode("-", $auxGrupo[$j]);
								$gruposIns = array(
									'LGF0290002' => $aux[0],
									'LGF0290003' => 1,
									'LGF0290004' => $ok,
									'LGF0290005' => $aux[1]
								);
								$grupo_institucion = (new Grupos())->addGrupo((object) $gruposIns);
							}
						}
						// Guardar contraseña de instituciones
						$recover = array("LGF0330001"=>$ok,"LGF0330002"=>$instituciones[$i]['LGF0270024'], "LGF0330003"=>4);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					}

					$totalReg = ($x-1);
					$mensaje = "Se registro un total de ".$regAdd." instituciones de ".$totalReg." registros.";
					$this->renderJSON(array("error"=>0,"mensaje" => $mensaje));
				} else if ($opcion == 4) { // Grupos
					$grupos = array();
					$modulos = "";
					$contador = 0;
					while(($datos = fgetcsv($fichero,1000)) != FALSE){
						$x++;
						if($x > 1){
							$contador++;
							$checkR = array('LGF0270028' => $datos[0]);
							$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
							array_push($grupos, array(
								'LGF0290002' => utf8_encode($datos[1]),
								'LGF0290003' => 1,
								'LGF0290004' => $obtenerInstitucion[0]['LGF0270001'],
								'LGF0290005' => (isset($datos[2]) ? $datos[2] : null)
							));
						}
					}
					fclose($fichero);
					unlink($destino);
					$regAdd = 0;
					for ($i=0; $i < count($grupos); $i++) { 
						$respuesta = (new Grupos())->addGrupo((object) $grupos[$i]);
						if ($respuesta) {
							$regAdd++;
						}
					}

					$totalReg = ($contador);
					$mensaje = "Se registro un total de ".$regAdd." grupos de ".$totalReg." registros.";

					$this->renderJSON(array("error"=>0,"mensaje" => $mensaje));
				}
			}
		}

		private function validarUsuario($usuario) {
			$checkUser = (new Usuarios())->obtenUsuario((object) array("LGF0010005" => $usuario));
			if (count($checkUser) > 0) {
				$cadena = substr($usuario, 4, 6);
				$random = $this->generateRandomString();
				$newUser = $random.$cadena;
				return $this->validarUsuario($newUser);
			} else {
				return $usuario;
			}
		}

		private function generateRandomString($length = 4) {
		    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

		/* Sección administrable de guias de estudio*/
		public function admguias() {
			$accion = $_POST['accion']; // 1 Agregar, 2 Editar
			$modulo = $_POST['smodulo'];
			$leccion = $_POST['sLecciones'];
			
			$estatus = $_POST['estatus'];

			if ($accion == 1) {
				$archivo_temp = $_FILES['fileG']['tmp_name'];
				$name_archivo = $_FILES['fileG']['name'];
				$aux = explode(".", $name_archivo);
				$extension = strtolower($aux[1]);
				if ($extension == "pdf") {
					
					$obtener_orden_leccion = (new Administrador())->obtener_orden_leccion($modulo, $leccion);
					$destino = __DIR__."/../../portal/archivos/guiasEstudio/n".$obtener_orden_leccion[0]['LGF0150004']."/m".$modulo."/l".$obtener_orden_leccion[0]['LGF0160007']."/";

					$nomenclatura_file = "GL".$obtener_orden_leccion[0]['LGF0160007']."_";
					$nombre = str_replace(" ", "_", $aux[0]);
					$nomenclatura_file.=$nombre.".pdf";
					// echo $destino.$nomenclatura_file."<br>";
					$rutaFile = $destino.=$nomenclatura_file;
					// echo $rutaFile."<br>";
					// die();
					$check = (new Guias())->obtenGuia((object) array(
						"LGF0310003" => $modulo, // modulo,
						"LGF0310004" => $leccion, // leccion
						"LGF0310005" => $obtener_orden_leccion[0]['LGF0160007'] // orden
					));
					if ($check[0]['LGF0310007'] != "") {
						$guiapdf = $destino.=$check[0]['LGF0310007'];
						if (file_exists($guiapdf)) {
							unlink($guiapdf);
						}
					}
					if ($this->mover_recursos($archivo_temp, $rutaFile)) {
						if (count($check) > 0) {
							// print_r($check[0]['LGF0310001']);
							$data = array(
								"LGF0310007" => $nomenclatura_file, // nombre del archivo
								"LGF0310006" => $estatus, // activo/inactivo
								"LGF0310009" => 1 // tipo guia 1) usuario final
							);
							$ok = (new Guias())->actualizarGuia((object) $data, (object) array("LGF0310001" => $check[0]['LGF0310001']));
							$this->renderJSON(array("error" => 0, "mensaje" => "Se actualizo la guía de estudio"));
						} else {
							$data = array(
								"LGF0310002" => $obtener_orden_leccion[0]['LGF0150004'], // nivel
								"LGF0310003" => $modulo, // modulo,
								"LGF0310004" => $leccion, // leccion
								"LGF0310005" => $obtener_orden_leccion[0]['LGF0160007'], // orden
								"LGF0310006" => $estatus, // activo/inactivo
								"LGF0310007" => $nomenclatura_file, // nombre del archivo
								"LGF0310009" => 1 // tipo guia 1) usuario final
							);
							$ok = (new Guias())->agregarGuia((object) $data);
							$this->renderJSON(array("error" => 0, "mensaje" => "Se agrego exitosamente la guía de estudio"));
						}
					} else {
						$this->renderJSON(array("error" => 1, "mensaje" => "No se pudo mover el archivo"));
					}
				} else {
					$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes subir archivos PDF"));
				}
			} else {
				// $this->renderJSON(array("error" => 0, "mensaje" => "Se actualizo la guía de estudio"));
				$tamanio = $_FILES['fileG']['size'];
				$valor = $_POST['valor'];
				if ($tamanio != 0) {
					$archivo_temp = $_FILES['fileG']['tmp_name'];
					$name_archivo = $_FILES['fileG']['name'];
					$aux = explode(".", $name_archivo);
					$extension = strtolower($aux[1]);
					if ($extension == "pdf") {
						$obtener_orden_leccion = (new Administrador())->obtener_orden_leccion($modulo, $leccion);
						$destino = __DIR__."/../../portal/archivos/guiasEstudio/n".$obtener_orden_leccion[0]['LGF0150004']."/m".$modulo."/l".$obtener_orden_leccion[0]['LGF0160007']."/";

						$nomenclatura_file = "GL".$obtener_orden_leccion[0]['LGF0160007']."_";
						$nombre = str_replace(" ", "_", $aux[0]);
						$nomenclatura_file.=$nombre.".pdf";
						// echo $destino.$nomenclatura_file."<br>";
						$rutaFile = $destino.=$nomenclatura_file;
						// echo $rutaFile."<br>";
						// die();
						if ($this->mover_recursos($archivo_temp, $rutaFile)) {
							$data = array(
								"LGF0310007" => $nomenclatura_file, // nombre del archivo
								"LGF0310006" => $estatus, // activo/inactivo
								"LGF0310009" => 1 // tipo guia 1) usuario final
							);
							$ok = (new Guias())->actualizarGuia((object) $data, (object) array("LGF0310001" => $valor));
							$this->renderJSON(array("error" => 0, "mensaje" => "Se actualizo la guía de estudio"));
						} else {
							$this->renderJSON(array("error" => 1, "mensaje" => "No se pudo mover el archivo"));
						}
					} else {
						$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes subir archivos PDF"));
					}
				} else {
					$data = array(
						"LGF0310006" => $estatus, // activo/inactivo
						"LGF0310009" => 1 // tipo guia 1) usuario final
					);
					$ok = (new Guias())->actualizarGuia((object) $data, (object) array("LGF0310001" => $valor));
					$this->renderJSON(array("error" => 0, "mensaje" => "Se actualizo la guía de estudio"));
				}
			}
		}

		public function mover_recursos($temporal, $destino) {
            /*#################*/
            $ruta_completa = explode('/', $destino);
            array_pop($ruta_completa);
            $target_path = join('/', $ruta_completa);

            /*#################*/

            if(!file_exists($target_path)){
                mkdir($target_path, 0777, true);
            }

			if(move_uploaded_file($temporal, $destino)){
				return true;
			} else {
				return false;
			}
		}

		public function cargar_lecciones() {
			$nivel = $_POST['clave'];
			$lecciones = (new Administrador())->mostrarLecciones($nivel, 1);
			$data = array();
			foreach ($lecciones as $key => $value) {
				$data[] = array(
					'cvl' => $value['LGF0160001'],
					'nombre' => $value['LGF0160002'],
				);
			}

			$this->renderJSON(array("data"=>$data));
		}

		public function obtenerGuias() {
			$modulo = $_POST['modulo'];
			
			$guias = (new Administrador())->mostrar_guias($modulo);
			/*$rutaImagen = __DIR__."/../../portal/archivos/iconosLecciones/";
			$rutaPDF = __DIR__."/../../portal/archivos/guiasEstudio/";
			$pdfG = __DIR__."/../../portal/archivos/guiasEstudio/";*/
			$rutaImagen = ARCHIVO_FISICO."iconosLecciones/";
			$rutaPDF = ARCHIVO_FISICO."guiasEstudio/";
			$pdfG = ARCHIVO_FISICO."guiasEstudio/";

			$img = ARCHIVO_FISICO."iconosLecciones/";
			$pdf = ARCHIVO_FISICO."guiasEstudio/";
			$data = array();
			foreach ($guias as $value) {
				if ($value['orden'] == 0) {
					$checkPDF = $rutaPDF."n".$value['nivel']."/m".$value['modulo']."/".$value['archivo'];
					/*if (file_exists($checkPDF)) {
						$urlG = $pdf."n".$value['nivel']."/m".$value['modulo']."/P".($value['modulo'] - 1)."_GUIA.pdf";
					} else {
						$urlG = '';
					}*/
					$urlG = $pdf."n".$value['nivel']."/m".$value['modulo']."/P".($value['modulo'] - 1)."_GUIA.pdf";
					array_push($data, array(
						'clave' => (int) $value['id'],
						'icono' => $img."scope.png",
						'leccion' => "Scope and sequence",
						'leccionid' => (int) $value['leccionid'],
						'modulo' => (int) $value['modulo'],
						'moduloname' => $value['moduloname'],
						'guia' => $img."pdf.png",
						'urlG' => $urlG,
						'tipo' => (int) 0, // Guia general
						'estatus' => (int) $value['estatus']
					));
				} else {
					if ($value['icono'] == "" || $value['icono'] == null) {
						$icono = $img."icono_temporal.png";
					}

					$checkImg = $rutaImagen."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					/*############################*/
                    /*if (!file_exists($checkImg)) {
						$icono = $img."icono_temporal.png";
					} else {
						$icono = $img."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					}*/
					$icono = $img."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					/*############################*/

					if ($value['archivo'] == "" || $value['archivo'] == null) {
						$iconoG = '';
					} else {
						$iconoG = 1;

						$checkPDF = $rutaPDF."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['archivo'];
					    /*############################*/
						/*if (file_exists($checkPDF)) {
							$urlG = $pdf."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['archivo'];
						} else {
							$urlG = '';
						}*/
						$urlG = $pdf."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['archivo'];
					    /*############################*/
					}

					array_push($data, array(
						'clave' => (int) $value['id'],
						'icono' => $icono,
						'leccion' => "Lección ".$value['orden'].") ".$value['leccion'],
						'leccionid' => (int) $value['leccionid'],
						'modulo' => (int) $value['modulo'],
						'moduloname' => $value['moduloname'],
						'guia' => $iconoG,
						'urlG' => $urlG,
						'tipo' => (int) $value['tipo'], // 1.- Usuario 2.- Docente
						'estatus' => (int) $value['estatus']
					));
				}
			}

			$this->renderJSON(array("data"=>$data));
		}

		public function saveGuide() {
			$fileName = $_FILES['fileG']['name'];
			$aux = explode(".", $fileName);
			$extension = strtolower($aux[1]);
			$grado = $_POST['grado'];
			$leccion = $_POST['leccion'];
			$tipoGuia = $_POST['tipoG'];
			$estatus = $_POST['estatus'];

			$extra = (new Administrador())->obtener_nivel_leccion($grado, $leccion);
			$nivel = $extra[0]['nivel'];
			$orden = $extra[0]['orden'];

			// echo "nivel => ".$nivel."<br>orden => ".$orden;
			if ($tipoGuia == 0) {
				$name_archivo = "P".($grado - 1)."_GUIA.pdf";
				$destino = __DIR__."/../../portal/archivos/guiasEstudio/n".$nivel."/m".$grado."/";
				$datos = array(
					"LGF0310002" => $nivel, // nivel,
					"LGF0310003" => $grado, // modulo,
					"LGF0310005" => 0, // orden
					"LGF0310009" => $tipoGuia
				);
			} else {
				$destino = __DIR__."/../../portal/archivos/guiasEstudio/n".$nivel."/m".$grado."/l".$orden."/";
				$name = str_replace(" ", "_", $fileName);
				if ($tipoGuia == 1) {
					$name_archivo = "GL".($orden)."_".$name;
				} else {
					$name_archivo = "GLD".($orden)."_".$name;
				}
				// echo time();
				$datos = array(
					"LGF0310002" => $nivel, // nivel,
					"LGF0310003" => $grado, // modulo,
					"LGF0310004" => $leccion, // leccion
					"LGF0310009" => $tipoGuia
				);
			}

			$temporal = $_FILES['fileG']['tmp_name'];

			$check = (new Guias())->obtenGuia((object) $datos);

			$data = array(
				"LGF0310002" => $nivel, // nivel,
				"LGF0310003" => $grado, // modulo,
				"LGF0310004" => (($tipoGuia == 0) ? null : $leccion), // leccion
				"LGF0310005" => (($tipoGuia == 0) ? 0 : $orden), // orden
				"LGF0310006" => $estatus, // activo/inactivo
				"LGF0310009" => $tipoGuia
			);

			if ($_FILES['fileG']['size'] > 0) {
				$data["LGF0310007"] = $name_archivo; // nombre del archivo']
			}

			if (count($check) > 0) {
				if ($_FILES['fileG']['size'] > 0) {
					if ($check[0]['LGF0310007'] != "") {
						unlink($destino.$check[0]['LGF0310007']);
					}
					$rutaFile = $destino.=$name_archivo;
					$this->mover_recursos($temporal, $rutaFile);
				}
				$ok = (new Guias())->actualizarGuia((object) $data, (object) array(
					"LGF0310001" => $check[0]['LGF0310001']
				));
				$this->renderJSON(array("error" => 0, "mensaje" => "Se actualizo la información del registro"));
			} else {
				$rutaFile = $destino.=$name_archivo;
				$this->mover_recursos($temporal, $rutaFile);
				$ok = (new Guias())->agregarGuia((object) $data);
				$this->renderJSON(array("error" => 0, "mensaje" => "Se agrego exitosamente la guía de estudio"));
			}
		}

		public function obtenRecursos() {
			$modulo = $_POST['modulo'];
			$recursos = (new Administrador())->mostrar_recursos($modulo);
			$rutaImagen = __DIR__."/../../portal/archivos/iconosLecciones/";
			$rutaRecurso = __DIR__."/../../portal/archivos/recursosLecciones/";
			$img = ARCHIVO_FISICO."iconosLecciones/";
			$urlRecurso = ARCHIVO_FISICO."recursosLecciones/";
			$data = array();

			$tabla = "";
			foreach ($recursos as $value) {
				if ($value['icono'] == "" || $value['icono'] == null) {
					$icono = $img."icono_temporal.png";
				} else {
					$checkIcono = $rutaImagen."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];

					/*##########################################*/
					/*if ($this->check_recurso($checkIcono)) {
						$icono = $img."icono_temporal.png";
					} else {*/
					$icono = $img."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['icono'];
					/*}*/
					/*##########################################*/
				}
				
				if ($value['recurso1'] == "" || $value['recurso1'] == null) {
					$rec1 = "";
				} else {
					$checkRec1 = $rutaRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1'];
					/*##########################################*/
					/*if ($this->check_recurso($checkRec1)) {
						$rec1 = "";
					} else {*/
					$rec1 = $urlRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso1'];
					/*}*/
					/*##########################################*/
				}

				if ($value['recurso2'] == "" || $value['recurso2'] == null) {
					$rec2 = "";
				} else {
					$checkRec2 = $rutaRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso2'];
					/*##########################################*/
					/*if ($this->check_recurso($checkRec2)) {
						$rec2 = "";
					} else {*/
					$rec2 = $urlRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso2'];
					/*}*/
					/*##########################################*/
				}

				if ($value['recurso3'] == "" || $value['recurso3'] == null) {
					$rec3 = "";
				} else {
					$checkRec3 = $rutaRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso3'];
					/*##########################################*/
					/*if ($this->check_recurso($checkRec3)) {
						$rec3 = "";
					} else {*/
					$rec3 = $urlRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso3'];
					/*}*/
					/*##########################################*/
				}

				if ($value['recurso4'] == "" || $value['recurso4'] == null) {
					$rec4 = "";
				} else {
					$checkRec4 = $rutaRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso4'];
					/*##########################################*/
					/*if ($this->check_recurso($checkRec4)) {
						$rec4 = "";
					} else {*/
						$rec4 = $urlRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso4'];
					/*}*/
					/*##########################################*/
				}

                if ($value['recurso5'] == "" || $value['recurso5'] == null) {
                    $rec5 = "";
                } else {
                    $checkRec5 = $rutaRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso5'];
					/*##########################################*/
                    /*if ($this->check_recurso($checkRec5)) {
                        $rec5 = "";
                    } else {*/
                    $rec5 = $urlRecurso."n".$value['nivel']."/m".$value['modulo']."/l".$value['orden']."/".$value['recurso5'];
                    /*}*/
					/*##########################################*/
                }

				array_push($data, array(
					'clave' => (int) $value['id'],
					'nivel' => (int) $value['nivel'],
					'modulo' => (int) $value['modulo'],
					'moduloname' => $value['moduloname'],
					'leccion' => (int) $value['leccionid'],
					'name' => "Lección ".$value['orden'].") ".$value['leccion'],
					'orden' => (int) $value['orden'],
					'tipo' => (int) $value['tipo'],
					'estatus' => (int) $value['estatus'],
					'icono' => $icono,
					'rec1' => $rec1,
					'rec2' => $rec2,
					'rec3' => $rec3,
					'rec4' => $rec4,
					'rec5' => $rec5
				));
			}

			$this->renderJSON(array("data"=>$data));
		}

		public function check_recurso($ruta) {
			/*####################################################*/
			/*if (file_exists($ruta)) {
				return false;
			} else {*/
				return true;
			/*}*/
			/*####################################################*/
		}

		public function saveRecurso() {

			$grado = $_POST['grado'];
			$leccion = $_POST['leccion'];
			$tipoRecurso = $_POST['tipoR'];
			$estatus = $_POST['estatus'];

			$extra = (new Administrador())->obtener_nivel_leccion($grado, $leccion);
			$nivel = $extra[0]['nivel'];
			$orden = $extra[0]['orden'];

			// validar registro
			$checkR = array(
				'LGF0320002' => $nivel,
				'LGF0320003' => $grado,
				'LGF0320004' => $leccion,
				'LGF0320005' => $orden,
				'LGF0320012' => $tipoRecurso
			);

			// nueva información
            $registro_actualizar = array(
				'LGF0320002' => $nivel,
				'LGF0320003' => $grado,
				'LGF0320004' => $leccion,
				'LGF0320005' => $orden,
				'LGF0320006' => $estatus,
				'LGF0320012' => $tipoRecurso
			);

			$ruta_recursos = __DIR__."/../../portal/archivos/recursosLecciones/n".$nivel."/m".$grado."/l".$orden."/";

			$check = (new Recurso())->obtenRecurso((object) $checkR);


            /*#############################################################################################*/
            $tipo_recursos   = ['Listening',  'For Fun',    'Reading',    'Evaluation', 'Exercises'];
            $nombre_recursos = ['upRec1',     'upRec2',     'upRec3',     'upRec4',     'upRec5'];
            $campos_recursos = ['LGF0320008', 'LGF0320009', 'LGF0320010', 'LGF0320011', 'LGF0320013'];

            $extRecursoAudio = ['mp3'];
            $extensionesDocumentos = ["pdf","doc","docx","xls","xlsx","ppt","pptx"];

            $extensiones = join(', ', $extensionesDocumentos);
            $extensiones2 = join(', ', $extRecursoAudio);

            $temporalRecursosSave = [];
            $nombreRecursosSave   = [];

            foreach ($nombre_recursos as $key => $recurso_peticion_upload_usuario) {

                /*Si el usuario manda el archivo se procesa, SE VERIFICA SI EL ERROR 0 SIGNIFICA SE PUEDE PROCESAR ARCHIVO EN SERVIDOR*/
                if($_FILES[$recurso_peticion_upload_usuario]['name'] != ""){
                    # $verificaQueArchivoCarga .=$recurso_peticion_upload_usuario.", ";

                    $tamRecurso = $_FILES[$recurso_peticion_upload_usuario]['size'];

                    if ($tamRecurso > 0) {

                        $nameRecurso = $_FILES[$recurso_peticion_upload_usuario]['name'];
                        $aux = explode(".", $nameRecurso);
                        #$extension = strtolower($aux[1]);
                        $extension = pathinfo($nameRecurso,PATHINFO_EXTENSION);

                        /*Si el recurso que se intenta subir es audio se verifica contra: $extRecursoAudio, en caso contrario contra: $extensionesDocumentos */
                        if (in_array($extension, $tipo_recursos[$key] == 'Listening' ? $extRecursoAudio:$extensionesDocumentos)) {

                            /*RCD(Numero recurso)_M(grado)_(Alumno, Docente)_nombreArchivo.extension*/
                            $recursoAlumno_o_Docente = $tipoRecurso == 1 ? 'A':'D';
                            $nombreRecurso = $nombreRecursosSave[] = "RCD".($key+1)."_M".($grado - 1)."_".$recursoAlumno_o_Docente."_".str_replace(" ", "-", $aux[0]).".".$extension;

                            $temporalRecurso = $temporalRecursosSave[] = $_FILES[$recurso_peticion_upload_usuario]['tmp_name'];

                            /*#######  Este registro es el que se va a actualizar en base al final del recorrido foreach*/
                            $registro_actualizar[$campos_recursos[$key]] = $nombreRecurso;

                            /*###################################################################################*/
                            /*Comprobamos a nivel de base de datos si existe el archivo en carpeta se borra y se actualizara al nuevo*/
                            if ($check[0][$campos_recursos[$key]] != "") {
                                unlink($ruta_recursos.$check[0][$campos_recursos[$key]]);
                            }
                            $recurso = $ruta_recursos.$nombreRecurso;
                            $this->mover_recursos($temporalRecurso, $recurso);
                            /*###################################################################################*/
                        } else {
                            $this->renderJSON(
                                array(
                                    "error" => 1,
                                    "mensaje" => "Solo puedes cargar archivos con los formatos ".$tipo_recursos[$key] == 'Listening' ? $extensiones2:$extensiones." en recurso digital: ".$tipo_recursos[$key]
                                )
                            );
                        }
                    }
                }
            }
            /*Sio hay registros */
            if (count($check) > 0) {
                $accion = 1;
                $ok = (new Recurso())->actualizarRecurso((object)$registro_actualizar, (object)array(
                    "LGF0320001" => $check[0]['LGF0320001']
                ));
            }else{
                $accion = 2;
                foreach ($nombreRecursosSave as $key => $recurso) {
                    $recursoMover = $ruta_recursos . $recurso;
                    $this->mover_recursos($temporalRecursosSave[$key], $recursoMover);
                }
                $ok = (new Recurso())->agregarRecurso((object)$registro_actualizar);
            }
            /*Verificamos la accion y si se ejecuto la operacion correspondiente*/
            if($ok){
                $this->renderJSON(array("error" => 0, "mensaje" => "Recurso digital agregado correctamente."));
            }else{
                if($accion == 1){
                    $this->renderJSON(array("error" => 1, "mensaje" => "Fallo al actualizar el recurso."));
                }else{
                    $this->renderJSON(array("error" => 1, "mensaje" => "Fallo al mover los recursos al directorio."));
                }
            }
            /*#############################################################################################*/

			/*$tamRec1 = $_FILES['upRec1']['size'];
			if ($tamRec1 > 0) {
				$nameRec1 = $_FILES['upRec1']['name'];
				$aux = explode(".", $nameRec1);
				$extension = strtolower($aux[1]);
				$extRecurso1 = array('mp3', 'zip');
				if (in_array($extension, $extRecurso1)) {
					if ($tipoRecurso == 1) {
						$nombreRec1 = "RCD1_M".($grado - 1)."_A_".str_replace(" ", "-", $aux[0]).".".$extension;
					} else {
						$nombreRec1 = "RCD1_M".($grado - 1)."_D_".str_replace(" ", "-", $aux[0]).".".$extension;
					}
					$temporalRec1 = $_FILES['upRec1']['tmp_name'];
					$data['LGF0320008'] = $nombreRec1;
				} else {
					$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes cargar audios en formato MP3 o archivos comprimidos en formato Zip"));
				}
			}

			$extensionesPermitidas = array("pdf","doc","docx","xls","xlsx","ppt","pptx");*/
            /*$extensiones = "";
            foreach ($extensionesPermitidas as $key => $value) {
                if ($key == 0) {
                    $extensiones = $value;
                } else {
                    $extensiones.=", ".$value;
                }
            }*/
            /*$extensiones = join(', ', $extensionesPermitidas);

			$tamRec2 = $_FILES['upRec2']['size'];
			if ($tamRec2 > 0) {
				$nameRec2 = $_FILES['upRec2']['name'];
				$aux = explode(".", $nameRec2);
				$extension = strtolower($aux[1]);
				if (in_array($extension, $extensionesPermitidas)) {
					if ($tipoRecurso == 1) {
						$nombreRec2 = "RCD2_M".($grado - 1)."_A_".str_replace(" ", "-", $aux[0]).".".$extension;
					} else {
						$nombreRec2 = "RCD2_M".($grado - 1)."_D_".str_replace(" ", "-", $aux[0]).".".$extension;
					}
					$temporalRec2 = $_FILES['upRec2']['tmp_name'];
					$data['LGF0320009'] = $nombreRec2;
				} else {
					$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes cargar archivos con los formatos ".$extensiones." en recurso digital 2"));
				}
			}

			$tamRec3 = $_FILES['upRec3']['size'];
			if ($tamRec3 > 0) {
				$nameRec3 = $_FILES['upRec3']['name'];
				$aux = explode(".", $nameRec3);
				$extension = strtolower($aux[1]);
				if (in_array($extension, $extensionesPermitidas)) {
					if ($tipoRecurso == 1) {
						$nombreRec3 = "RCD3_M".($grado - 1)."_A_".str_replace(" ", "-", $aux[0]).".".$extension;
					} else {
						$nombreRec3 = "RCD3_M".($grado - 1)."_D_".str_replace(" ", "-", $aux[0]).".".$extension;
					}
					$temporalRec3 = $_FILES['upRec3']['tmp_name'];
					$data['LGF0320010'] = $nombreRec3;
				} else {
					$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes cargar archivos con los formatos ".$extensiones." en recurso digital 3"));
				}
			}

			$tamRec4 = $_FILES['upRec4']['size'];
			if ($tamRec4 > 0) {
				$nameRec4 = $_FILES['upRec4']['name'];
				$aux = explode(".", $nameRec4);
				$extension = strtolower($aux[1]);
				if (in_array($extension, $extensionesPermitidas)) {
					if ($tipoRecurso == 1) {
						$nombreRec4 = "RCD4_M".($grado - 1)."_A_".str_replace(" ", "-", $aux[0]).".".$extension;
					} else {
						$nombreRec4 = "RCD4_M".($grado - 1)."_D_".str_replace(" ", "-", $aux[0]).".".$extension;
					}
					$temporalRec4 = $_FILES['upRec4']['tmp_name'];
					$data['LGF0320011'] = $nombreRec4;
				} else {
					$this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes cargar archivos con los formatos ".$extensiones." en recurso digital 4"));
				}
			}

            $tamRec5 = $_FILES['upRec5']['size'];
            if ($tamRec5 > 0) {
                $nameRec5 = $_FILES['upRec5']['name'];
                $aux = explode(".", $nameRec5);
                $extension = strtolower($aux[1]);
                if (in_array($extension, $extensionesPermitidas)) {
                    if ($tipoRecurso == 1) {
                        $nombreRec5 = "RCD5_M".($grado - 1)."_A_".str_replace(" ", "-", $aux[0]).".".$extension;
                    } else {
                        $nombreRec5 = "RCD5_M".($grado - 1)."_D_".str_replace(" ", "-", $aux[0]).".".$extension;
                    }
                    $temporalRec5 = $_FILES['upRec5']['tmp_name'];
                    $data['LGF0320013'] = $nombreRec5;
                } else {
                    $this->renderJSON(array("error" => 1, "mensaje" => "Solo puedes cargar archivos con los formatos ".$extensiones." en recurso digital 5"));
                }
            }*/

            /*if (count($check) > 0) {
                // echo "Actualiza";
                if ($tamRec1 > 0) {
                    if ($check[0]['LGF0320008'] != "") {
                        unlink($ruta_recursos.$check[0]['LGF0320008']);
                    }
                    $recurso1 = $ruta_recursos.$nombreRec1;
                    $this->mover_recursos($temporalRec1, $recurso1);
                }
                if ($tamRec2 > 0) {
                    if ($check[0]['LGF0320009'] != "") {
                        unlink($ruta_recursos.$check[0]['LGF0320009']);
                    }
                    $recurso2 = $ruta_recursos.$nombreRec2;
                    $this->mover_recursos($temporalRec2, $recurso2);
                }
                if ($tamRec3 > 0) {
                    if ($check[0]['LGF0320010'] != "") {
                        unlink($ruta_recursos.$check[0]['LGF0320010']);
                    }
                    $recurso3 = $ruta_recursos.$nombreRec3;
                    $this->mover_recursos($temporalRec3, $recurso3);
                }
                if ($tamRec4 > 0) {
                    if ($check[0]['LGF0320011'] != "") {
                        // echo "Hola";
                        unlink($ruta_recursos.$check[0]['LGF0320011']);
                    }
                    $recurso4 = $ruta_recursos.$nombreRec4;
                    $this->mover_recursos($temporalRec4, $recurso4);
                }
                if ($tamRec5 > 0) {
                    if ($check[0]['LGF0320013'] != "") {
                        // echo "Hola";
                        unlink($ruta_recursos.$check[0]['LGF0320013']);
                    }
                    $recurso5 = $ruta_recursos.$nombreRec5;
                    $this->mover_recursos($temporalRec5, $recurso5);
                }*/

				/*$ok = (new Recurso())->actualizarRecurso((object) $data, (object) array(
					"LGF0320001" => $check[0]['LGF0320001']
				));
				$this->renderJSON(array("error" => 0, "mensaje" => "Recurso digital actualizado correctamente"));*/
			/*} else {
				$recurso1 = $ruta_recursos.$nombreRec1;
				$this->mover_recursos($temporalRec1, $recurso1);
				$recurso2 = $ruta_recursos.$nombreRec2;
				$this->mover_recursos($temporalRec2, $recurso2);
				$recurso3 = $ruta_recursos.$nombreRec3;
				$this->mover_recursos($temporalRec3, $recurso3);
				$recurso4 = $ruta_recursos.$nombreRec4;
				$this->mover_recursos($temporalRec4, $recurso4);
                $recurso5 = $ruta_recursos.$nombreRec5;
                $this->mover_recursos($temporalRec5, $recurso5);
				$ok = (new Recurso())->agregarRecurso((object) $data);
				$this->renderJSON(array("error" => 0, "mensaje" => "Recurso digital agregado correctamente"));
			}*/
		}

		public function informacionRecurso() {
			$idLeccion = $_POST['valor'];
			$recurso = (new Recurso())->obtenRecurso((object) array('LGF0320001' => $idLeccion));
			// print_r($recurso);
			$data = array();
			foreach ($recurso as $value) {
				array_push($data, array(
					'clave' => (int) $value['LGF0320001'],
					'modulo' => (int) $value['LGF0320003'],
					'leccion' => (int) $value['LGF0320004'],
					'estatus' => (int) $value['LGF0320006'],
					'tipoR' => (int) $value['LGF0320012']
				));
			}
			$this->renderJSON(array("data" => $data));
		}

		public function limpiar_datos() {
			$accion = $_POST['accion'];

			$ruta = __DIR__."/../../importar/";
			// $file = file_get_contents($file['tmp_name']);
			$nombre = $_FILES['limpiar']['name'];
			$temporal = $_FILES['limpiar']['tmp_name'];
			$aux = explode(".", $nombre);
			#$nameFile = str_replace(" ", "_", $aux[0]);
			#$nombre_csv = $aux[0]."_".date("H:i:s").".csv";
            $extension = pathinfo($nombre, PATHINFO_EXTENSION);

            $nombre_csv = substr($nombre, 0, strrpos($nombre, ".".$extension))."_".date("H:i:s").".csv";;
			$nombre_csv = str_replace(":", "_", $nombre_csv);

			$destino = $ruta.$nombre_csv;

			if($extension != "csv"){
				$move = 0;
			}else{
				if(move_uploaded_file($temporal, $destino)){
					$move = 1;

				} else {
					$move = 0;

				}
			}

			if ($move == 1) {
				switch ($accion) {
					case '1': // Limpiar datos de la institución

                        if(strpos($nombre, 'plantilla_instituciones') === false){
                            $mensaje = "Verifica que si estes cargando el archivo plantilla_instituciones.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }

						$fichero1=fopen($destino, "r");
						$y = 0;

						$ccts = array();
						while (($claves = fgetcsv($fichero1, 10000)) != FALSE) {
                            if($y == 0){
                                if(count($claves) != 5 || $claves[0] != 'CCT' || $claves[1] != 'Nombre' || $claves[2] != 'Modulo' || $claves[3] != 'Grado' || $claves[4] != 'Letra'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }
							$y++;
							if ($y > 1) {
								$cctL = $this->eliminar_espacio($claves[0]);

                                if(strlen($cctL) != 10){
                                    $mensaje = "Verifica que el CCT este correcto (10 letras), error en CCT: ".$cctL." ubicado en la linea: ".$y." de tu archivo.";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }

								array_push($ccts, array($cctL));
							}
						}
						fclose($fichero1);

						$cctL = $this->super_unique($ccts);
						$json = array();
						for ($b=0; $b < count($ccts); $b++) { 
							if (!empty($cctL[$b][0])) {
								array_push($json, array($cctL[$b][0]));
							}
						}
						
						$fichero=fopen($destino, "r");
						$x = 0;
						$tabla = "<table border=1><thead><tr><th></th><th>Nombre</th><th>Paterno</th><th>Materno</th><th>Grupo</th><th>Genero</th><th>CCT</th><th>SQL</th></tr></thead><tbody>";
						$data = array();
						while (($datos = fgetcsv($fichero, 10000)) != FALSE) {
							$x++;
							if ($x > 1) {
								$nombre = $this->eliminar_espacio($datos[1]);
								$data[] = array(
									$datos[0],$nombre,$datos[2],$datos[3],$datos[4]
								);
							}
						}

						fclose($fichero);
						unlink($destino);
						$tabla.="</tbody></table>";
						$cadena = json_encode($data);
						$valores = json_decode($cadena);
						
						$informacion = array();
						for ($i=0; $i < count($json); $i++) { 
							$contador = 0;
							$contador1 = 0;
							$grupo = "";
							$modulos = "";
							
							$cctInstitucional = $json[$i][0];
							for ($j=0; $j < count($valores); $j++) { 
								if ($json[$i][0] == $valores[$j][0]) {
									if ($valores[$j][2] == 1) {
										if ($contador == 0) {
											$nombreInstitucion = $valores[$j][1];
											$modulos.=$valores[$j][2];
											$grupo.="Grupo ".$valores[$j][3].$valores[$j][4]."-".$valores[$j][2];
										} else {
											$grupo.="|Grupo ".$valores[$j][3].$valores[$j][4]."-".$valores[$j][2];
										}
										$contador++;
									} else {
										if ($contador1 == 0) {
											$nombreInstitucion = $valores[$j][1];
											$tabla.="<td>".$valores[$j][1]."</td>";
											$modulos.=$valores[$j][2];
											$grupo.="Grupo ".$valores[$j][3].$valores[$j][4]."-".$valores[$j][2];
										} else {
											$grupo.="|Grupo ".$valores[$j][3].$valores[$j][4]."-".$valores[$j][2];
											$modulos.="|".$valores[$j][2];
										}
										$contador1++;
									}
								}
							}
							$aux = explode("|", $modulos);
							$ids = "";
							if (count($aux) > 1) {
								$modulo = $this->super_unique($aux);
								
								$newIds = array();
								for ($a=0; $a < 20; $a++) { 
									if (!empty($modulo[$a])) {
										array_push($newIds, array($modulo[$a]));
									}
								}
								
								for ($k=0; $k < count($newIds); $k++) { 
									if ($k == 0) {
										$ids.=$newIds[$k][0];
									} else {
										$ids.="|".$newIds[$k][0];
									}
								}
							} else {
								$ids = $modulos;
							}

							$accesoModulos = $ids;
							$nombreGrupos = $grupo;

							array_push($informacion, array(
								"CCT"=>$cctInstitucional,
								"NombreInstitucion"=>$nombreInstitucion,
								"Accesos"=>$accesoModulos,
								"Grupos"=>$nombreGrupos
							));
						}
						$informacionjson = null;
						if (count($informacion) > 0) {
							$informacionjson = $informacion;
						}
                        $mensaje = "Formateo de información completo.";
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$informacionjson, "titulo" => "importar_instituciones"));
					    break;
					case '2': // Limpiar datos del alumno

                        if(strpos($nombre, 'plantilla_alumnos') === false){
                            $mensaje = "Verifica que si estes cargando el archivo plantilla_alumnos.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }


						$fichero = fopen($destino, "r");
						$usuariosOk = array();
						$usuariosBad = array();
                        $x = 0;

						while (($datos = fgetcsv($fichero, 10000)) != FALSE) {
                            if($x == 0){
                                if(count($datos) != 9 || $datos[0] != 'Nombre' || $datos[1] != 'Apellido paterno' || $datos[2] != 'Apellido materno' || $datos[3] != 'CURP' || $datos[4] != 'Genero' || $datos[5] != 'Modulo' || $datos[6] != 'Institucion' || $datos[7] != 'Grado' || $datos[8] != 'Letra'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }

							$x++;
							if ($x > 1) {
								$nombre = strtoupper($this->eliminar_espacio($datos[0]) );
								$paterno = strtoupper($this->eliminar_espacio($datos[1]) );
								$materno = strtoupper($this->eliminar_espacio($datos[2]) );
								$curp = strtoupper($this->eliminar_espacio($datos[3], 1) );
								$genero = strtoupper($this->eliminar_espacio($datos[4]) );
								$modulo = $this->eliminar_espacio($datos[5]);
								$cct = strtoupper($this->eliminar_espacio($datos[6],1) );

								$grado = $this->eliminar_espacio($datos[7]);
								$letra = $this->eliminar_espacio($datos[8]);
								$grupo = "GRUPO ".$grado.$letra;

								$curp = empty($curp) ? strtoupper( substr( md5($nombre.$paterno.$materno.$grado) ,0, 18) ) : $curp;

                                if(strlen($curp) != 18){
                                    $mensaje = "Verifica que el CURP este correcto (18 letras), error en CURP: ".$curp." ubicado en la linea: ".$x." de tu archivo.";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
								
								if (!empty($curp)) {
									array_push($usuariosOk, array(
										'Nombre' => $nombre,
										'Paterno' => $paterno,
										'Materno' => $materno,
										'CURP' => $curp,
										'Genero' => $genero,
										'Modulo' => $modulo,
										'Institucion' => $cct,
										'Grupo' => $grupo
									));
								} else {
									array_push($usuariosBad, array(
										'Nombre' => $nombre,
										'Paterno' => $paterno,
										'Materno' => $materno,
										'CURP' => $curp,
										'Genero' => $genero,
										'Modulo' => $modulo,
										'Institucion' => $cct,
										'Grupo' => $grupo,
										'Motivo' => "Campo CURP vacio"
									));
								}
							}
						}
						fclose($fichero);
						unlink($destino);
						$jsonUsuariosOk = null;
						$jsonUsuariosBad = null;
						if (count($usuariosOk) > 0) {
							$jsonUsuariosOk = $usuariosOk;
						}
						if (count($usuariosBad) > 0) {
							$jsonUsuariosBad = $usuariosBad;
						}
						$mensaje = "Formateo de información completo.";
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$jsonUsuariosOk, "titulo" => "importar_alumnos", "data1" => $jsonUsuariosBad, "titulo1" => "informacion_incompleta_alumnos"));
					    break;
					case '3': // Limpiar datos del docente
                        if(strpos($nombre, 'plantilla_docentes') === false){
                            $mensaje = "Verifica que si estes cargando el archivo plantilla_docentes.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }


						$fichero = fopen($destino, "r");
						
						$docentesOk = array();
						$docentesBad = array();
                        $x = 0;

						while (($datos = fgetcsv($fichero, 10000)) != FALSE) {
                            if($x == 0){
                                if(count($datos) != 6 || $datos[0] != 'Nombre' || $datos[1] != 'Apellido paterno' || $datos[2] != 'Apellido materno' || $datos[3] != 'CURP' || $datos[4] != 'Genero' || $datos[5] != 'Institucion'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }

							$x++;
							if ($x > 1) {
								$nombre = strtoupper($this->eliminar_espacio($datos[0]) );
								$paterno = strtoupper($this->eliminar_espacio($datos[1]) );
								$materno = strtoupper($this->eliminar_espacio($datos[2]) );
								$curp = strtoupper($this->eliminar_espacio($datos[3], 1) );
								$genero = strtoupper($this->eliminar_espacio($datos[4]) );
								$cct = strtoupper($this->eliminar_espacio($datos[5],1) );

								$curp = empty($curp) ? strtoupper(substr( md5($nombre.$paterno.$materno.$cct) ,0, 18) ) : $curp;

                                if(strlen($curp) != 18){
                                    $mensaje = "Verifica que el CURP este correcto (18 letras), error en CURP: ".$curp." ubicado en la linea: ".$x." de tu archivo.";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }

								$auxCCT = explode(",", $cct);
								for ($i=0; $i < count($auxCCT); $i++) { 
									$newCurp = "";
									if (!empty($curp)) {
										if (strlen($curp) == 18) {
											if (empty($genero)) {
												$genero = substr($curp, 10,1);
											}
											if ($i == 0) {
												$newCurp = $curp;
											} else {
												$newCurp = $curp."-".$i;
											}

                                            if(strlen($auxCCT[$i]) != 10){
                                                $mensaje = "Verifica que el CCT este correcto (10 letras), error en CCT: ".$auxCCT[$i]." ubicado en la linea: ".$x." de tu archivo.";
                                                $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                                exit;
                                            }

											array_push($docentesOk, array(
												'Nombre' => $nombre,
												'Paterno' => $paterno,
												'Materno' => $materno,
												'CURP' => $newCurp,
												'Genero' => $genero,
												'Institucion' => $auxCCT[$i]
											));
										} else {
											array_push($docentesBad, array(
												'Nombre' => $nombre,
												'Paterno' => $paterno,
												'Materno' => $materno,
												'CURP' => $curp,
												'Genero' => $genero,
												'Institucion' => $auxCCT[$i],
												'Motivo' => 'El campo CURP tiene '.strlen($curp).' caracteres, verifica bien este dato (18 letras).'
											));
										}
									} else {
										array_push($docentesBad, array(
											'Nombre' => $nombre,
											'Paterno' => $paterno,
											'Materno' => $materno,
											'CURP' => $newCurp,
											'Genero' => $genero,
											'Institucion' => $auxCCT[$i],
											'Motivo' => 'Falta el CURP del usuario'
										));
									}
								}
							}
						}
						fclose($fichero);
						unlink($destino);
						
						$jsonDocentesOk = null;
						$jsonDocentesBad = null;
						if (count($docentesOk) > 0) {
							$jsonDocentesOk = $docentesOk;
						}
						if (count($docentesBad) > 0) {
							$jsonDocentesBad = $docentesBad;
						}
						$mensaje = "Formateo de información completo.";
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$jsonDocentesOk, "titulo" => "importar_docentes", "data1" => $jsonDocentesBad, "titulo1" => "informacion_incompleta_docentes"));
					    break;
					case '4': // Registrar instituciones

                        if(strpos($nombre, 'importar_instituciones') === false){
                            $mensaje = "Verifica que si estes cargando el archivo importar_instituciones.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }


						$fichero = fopen($destino, "r");
						$x = 0;
						$instituciones = array();
						while(($datos = fgetcsv($fichero,1000)) != FALSE){
                            if($x == 0){
                                if(count($datos) != 4 || $datos[0] != 'CCT' || $datos[1] != 'NombreInstitucion' || $datos[2] != 'Accesos' || $datos[3] != 'Grupos'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }

							$x++;
							if($x > 1){
								$checkR = array('LGF0270028' => $datos[0]);
								// echo "Aqui";
								$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
								if (count($obtenerInstitucion) == 0) {
									$regAdd++;
									$nombre = utf8_encode($datos[1]);
									$fecha_actual = date("Y-m-d H:i:s");
									$fecha_termino = date("Y-m-d H:i:s",strtotime($fecha_actual."+ 1 year"));
									array_push($instituciones, array(
										'LGF0270002' => $nombre, // Nombre
										'LGF0270004' => $fecha_actual, // Fecha de inicio del contrato
										'LGF0270005' => $fecha_termino, // Fecha de termino del contrato
										'LGF0270012' => 1, // Activo/Inactivo
										'LGF0270013' => $fecha_actual, // fecha y hora de creacion
										'LGF0270016' => 1, // usuario que dio de alta
										'LGF0270019' => 10000, // numero de licencias contratadas
										'LGF0270021' => 1, // ID Cliente
										'LGF0270022' => $nombre, // nombre corto
										'LGF0270023' => 4, // ID Perfil => 4 institucion
										'LGF0270024' => trim($datos[0]), // usuario
										'LGF0270025' => sha1(trim($datos[0])), // contraseña
										'LGF0270027' => null, /// correo
										'LGF0270028' => trim($datos[0]), // CCT
										'modulos' => $datos[2],
										'grupos' => $datos[3]
									));
								}
							}
						}
						fclose($fichero);
						unlink($destino);
						
						for ($i=0; $i < count($instituciones); $i++) { 
							$auxMod = explode("|", $instituciones[$i]['modulos']);
							$auxGrupo = explode("|", $instituciones[$i]['grupos']);
							unset($instituciones[$i]['modulos']);
							unset($instituciones[$i]['grupos']);
							$ok = (new Instituciones())->agregarInstitucion((object) $instituciones[$i]);
							if (!empty($auxMod)) {
								// Asignacion de accesos a los modulos por instituciones
								// print_r($auxMod);
								for ($j=0; $j < count($auxMod); $j++) { 
									$modulosIns = array(
										'LGF0300002' => $ok,
										'LGF0300003' => $auxMod[$j]
									);
									$modulo_institucion = (new ModuloInstitucion())->addModuloInst((object) $modulosIns);
									// print_r($modulosIns);
								}
							}
							if (!empty($auxGrupo)) {
								// Asignacion de grupos por instituciones
								for ($j=0; $j < count($auxGrupo); $j++) { 
									$aux = explode("-", $auxGrupo[$j]);
									$gruposIns = array(
										'LGF0290002' => $aux[0],
										'LGF0290003' => 1,
										'LGF0290004' => $ok,
										'LGF0290005' => $aux[1]
									);
									$grupo_institucion = (new Grupos())->addGrupo((object) $gruposIns);
								}
							}
							// Guardar contraseña de instituciones
							$recover = array("LGF0330001"=>$ok,"LGF0330002"=>$instituciones[$i]['LGF0270024'], "LGF0330003"=>4);
							$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
						}

                        if(count($instituciones) == 0){
						    $mensaje = "Las ".$regAdd." instituciones ya habian sido registradas.";
                        }else{
						    $mensaje = "Se registro un total de ".$regAdd." instituciones de ".$totalReg." registros.";
                        }

						$totalReg = ($x-1);
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje));
					    break;
					case '5': // Registrar usuarios

                        if(strpos($nombre, 'importar_alumnos') === false){
                            $mensaje = "Verifica que si estes cargando el archivo importar_alumnos.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }

						$userRegister = null;
						$fichero = fopen($destino, "r");
						$noRegistrado = array();
						$usuarios=array();
						$x = 0;

						while(($datos = fgetcsv($fichero,1000)) != FALSE){

                            if($x == 0){
                                if(count($datos) != 8 || $datos[0] != 'Nombre' || $datos[1] != 'Paterno' || $datos[2] != 'Materno' || $datos[3] != 'CURP' || $datos[4] != 'Genero' || $datos[5] != 'Modulo' || $datos[6] != 'Institucion' || $datos[7] != 'Grupo'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }

							$x++;
							if($x > 1){
								// Validar campo CURP que no venga vacio desde el Excel
								$curp = $this->eliminar_espacio($datos[3]);
								$nombre = $this->eliminar_espacio($datos[0]);
								$paterno = $this->eliminar_espacio($datos[1]);
								$materno = $this->eliminar_espacio($datos[2]);
								$cct = $this->eliminar_espacio($datos[6]);
								if (!empty($curp)) {
									// Validar CURP existente
									$check = (new Administrador())->check_matricula($curp);
									if (count($check) == 0) {
										// Validar institucion
										$checkR = array('LGF0270028' => $cct);
										$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
										if (!empty($obtenerInstitucion[0]['LGF0270001'])) {
											$username = substr($curp, 0, 10);
											
											$totalReg++;
											$modulo = $datos[5];
											$nivel = (new Administrador())->obtener_nivel_modulo($modulo);
											$leccion = (new Administrador())->obtenerLeccion($modulo);
											$idInstitucion = $obtenerInstitucion[0]['LGF0270001'];
											$nick = $username;
											
											$checkGrupo = (new Grupos())->obtenGrupo((object) array(
												"LGF0290002" => $datos[7], // nombre del grupo,
												"LGF0290004" => $obtenerInstitucion[0]['LGF0270001'], // ID institucion
												"LGF0290005" => $modulo // ID modulo
											));
											if (!empty($checkGrupo[0]['LGF0290001'])) {
												$grupo = $checkGrupo[0]['LGF0290001'];
											} else {
												$grupo = null;
											}
											$usuarios[] = array(
												'LGF0010002' => (!empty($nombre) ? $nombre : ""), // nombre
												'LGF0010003' => (!empty($paterno) ? $paterno : ""), // ape Paterno
												'LGF0010004' => (!empty($materno) ? $materno : ""), // ape Materno
												'LGF0010005' => $nick, // user
												'LGF0010006' => sha1($nick), // password
												'LGF0010007' => 2, // perfil 2.- Alumno 6.- Docente
												'LGF0010008' => 1, // activo/inactivo
												'LGF0010021' => $datos[4], // genero
												'LGF0010023' => $nivel[0]['nivel'], // nivel
												'LGF0010024' => $modulo, // modulo/grado escolar
												'LGF0010025' => $leccion[0]['leccion'], // leccion
												'LGF0010026' => 1, // seccion actual
												'LGF0010030' => date("Y-m-d H:i:s"), // fecha y hora de creacion
												'LGF0010038' => $idInstitucion, // institucion
												'LGF0010039' => $grupo, // institucion
												'LGF0010040' => $curp // curp
											);
											$usuariosNew[] = array(
												'LGF0010002' => (!empty($nombre) ? $nombre : ""), // nombre
												'LGF0010003' => (!empty($paterno) ? $paterno : ""), // ape Paterno
												'LGF0010004' => (!empty($materno) ? $materno : ""), // ape Materno
												'LGF0010005' => $nick, // user
												'LGF0010006' => sha1($nick), // password
												'LGF0010007' => 2, // perfil 2.- Alumno 6.- Docente
												'LGF0010008' => 1, // activo/inactivo
												'LGF0010021' => $datos[4], // genero
												'LGF0010023' => $nivel[0]['nivel'], // nivel
												'LGF0010024' => $modulo, // modulo/grado escolar
												'LGF0010025' => $leccion[0]['leccion'], // leccion
												'LGF0010026' => 1, // seccion actual
												'LGF0010030' => date("Y-m-d H:i:s"), // fecha y hora de creacion
												'LGF0010038' => $idInstitucion, // institucion
												'LGF0010039' => $datos[7], //Nombre del grupo obtenido del excel
												'LGF0010040' => $curp, // curp
												'LGF0010041' => $cct // cct
											);
										} else {
											array_push($noRegistrado, array(
												"Nombre" => $nombre,
												"ApellidoPaterno" => $paterno,
												"ApellidoMaterno" => $materno,
												"Genero" => $datos[4],
												"CURP" => $curp,
												"GradoEscolar" => $datos[5],
												"Insitucion" => $cct,
												"Motivo" => "La institución con el C.C.T ".$cct." no se encuentra registrada en el sistema."
											));
										}
									} else {
										array_push($noRegistrado, array(
											"Nombre" => $nombre,
											"ApellidoPaterno" => $paterno,
											"ApellidoMaterno" => $materno,
											"Genero" => $datos[4],
											"CURP" => $curp,
											"GradoEscolar" => $datos[5],
											"Insitucion" => $cct,
											"Motivo" => "La siguiente CURP ".$curp." ya se encuentra registrada en el sistema."
										));
									}
								} else {
									array_push($noRegistrado, array(
										"Nombre" => $nombre,
										"ApellidoPaterno" => $paterno,
										"ApellidoMaterno" => $materno,
										"Genero" => $datos[4],
										"CURP" => $curp,
										"GradoEscolar" => $datos[5],
										"Insitucion" => $cct,
										"Motivo" => "La columna CURP se encuentra vacía, favor de verificar bien los datos."
									));
								}
							}
						}
						fclose($fichero);
						unlink($destino);
						$registerOk = array();
						if (count($usuarios) > 0) {
							$totalReg = count($usuarios);
							$regAdd = 0;
							for ($i=0; $i < count($usuarios); $i++) {
								// Validación de CURP
								$check = (new Administrador())->check_matricula($usuarios[$i]['LGF0010040']);
								//$checkR = array('LGF0270028' => $usuarios[$i]['LGF0010038']);
								//$obtenerInstitucion = (new Instituciones())->obtenInstitucion( (object) $checkR);
								//var_dump( $obtenerInstitucion );
								if (count($check) == 0) {
									$usuarios[$i]['LGF0010005'] = $this->validarUsuario($usuarios[$i]['LGF0010005']);
									$usuarios[$i]['LGF0010006'] = sha1($usuarios[$i]['LGF0010005']);
									// print_r($usuarios[$i]);
									$respuesta = (new Usuarios())->agregarUsuario((object) $usuarios[$i]);
									// echo "Respuesta: ".$respuesta;
									if ($respuesta) {
										$regAdd++;
										$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$usuarios[$i]['LGF0010005'], "LGF0330003"=>$usuarios[$i]['LGF0010007']);
										$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
										array_push( $registerOk, array(
											"Institucion" => $usuariosNew[$i]['LGF0010041'],
											"Grupo" => $usuariosNew[$i]['LGF0010039'],
											"Nombre" => $usuarios[$i]['LGF0010002'],
											"ApellidoPaterno" => $usuarios[$i]['LGF0010003'],
											"ApellidoMaterno" => $usuarios[$i]['LGF0010004'],
											"Usuario" => $usuarios[$i]['LGF0010005'],
											"Contraseña" => $usuarios[$i]['LGF0010005']
										) );
									}
								} else {
									array_push($noRegistrado, array(
										"Nombre" => $usuariosNew[$i]['LGF0010002'],
										"ApellidoPaterno" => $usuarios[$i]['LGF0010003'],
										"ApellidoMaterno" => $usuarios[$i]['LGF0010004'],
										"Genero" => $usuarios[$i]['LGF0010021'],
										"CURP" => $usuarios[$i]['LGF0010040'],
										"GradoEscolar" => ($usuarios[$i]['LGF0010024'] == 1 ? 1 : ($usuarios[$i]['LGF0010024']-1)),
										"Insitucion" => $usuarios[$i]['LGF0010041'],
										"Motivo" => "La siguiente CURP ".$usuarios[$i]['LGF0010040']." ya se encuentra registrada en el sistema."
									));
								}
							}
							// echo "</pre>";
							$mensaje = "Se registro un total de ".$regAdd." usuarios de ".$totalReg." registros.";
						} else {
							$totalReg = count($noRegistrado);
							$mensaje = "Los ".$totalReg." registros del archivo seleccionado ya se encuentran cargados en el sistema.";
						}
						$cadena1 = null;
						if (count($noRegistrado) > 0) {
							$cadena1 = $noRegistrado;
						}
						$cadena2 = null;
						if( count( $registerOk ) > 0 ) {
							$cadena2 = $registerOk;
						}
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$cadena2, "titulo" => "usuarios_cargados", "data1" => $cadena1, "titulo1" => "usuarios_no_cargados"));
						//$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$cadena1, "titulo"=>"datos_existentes_alumnos"));
					    break;
					case '6': // Registrar docentes

                        if(strpos($nombre, 'importar_docentes') === false){
                            $mensaje = "Verifica que si estes cargando el archivo importar_docentes.csv correctamente.";
                            $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                            exit;
                        }

						$fichero=fopen($destino, "r");
						$noRegistrado = array();
						$usuarios=array();
						$x = 0;
						while(($datos = fgetcsv($fichero,1000)) != FALSE){

                            if($x == 0){
                                if(count($datos) != 6 || $datos[0] != 'Nombre' || $datos[1] != 'Paterno' || $datos[2] != 'Materno' || $datos[3] != 'CURP' || $datos[4] != 'Genero' || $datos[5] != 'Institucion'){
                                    $mensaje = "Fallo al verificar la información, verifica que el archivo sea el correcto (error en nombre de columnas requeridas).";
                                    $this->renderJSON(array("error"=>1,"mensaje" => $mensaje));
                                    exit;
                                }
                            }

							$x++;
							if($x > 1){
								// Validar campo CURP que no venga vacio desde el Excel
								$curp = $this->eliminar_espacio($datos[3]);
								if (!empty($curp)) {
									// Validar CURP existente
									$check = (new Administrador())->check_matricula($datos[3]);
									if (count($check) == 0) {
										// Validar institucion
										$checkR = array('LGF0270028' => $datos[5]);
										$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
										if (!empty($obtenerInstitucion[0]['LGF0270001'])) {
											$username = substr($datos[3], 0, 10);
											$totalReg++;
											$idInstitucion = $obtenerInstitucion[0]['LGF0270001'];
											
											$usuarios[] = array(
												'LGF0010002' => (!empty($datos[0]) ? utf8_encode($datos[0]) : ""), // nombre
												'LGF0010003' => (!empty($datos[1]) ? utf8_encode($datos[1]) : ""), // ape Paterno
												'LGF0010004' => (!empty($datos[2]) ? utf8_encode($datos[2]) : ""), // ape Materno
												'LGF0010005' => $username, // user
												'LGF0010006' => sha1($username), // password
												'LGF0010007' => 6, // perfil 2.- Alumno 6.- Docente
												'LGF0010008' => 1, // activo/inactivo
												'LGF0010021' => $datos[4], // genero
												'LGF0010030' => date("Y-m-d H:i:s"), // fecha y hora de creacion
												'LGF0010038' => $idInstitucion, // institucion
												'LGF0010040' => $datos[3] // curp
											);
											$usuariosNew[] = array(
												'LGF0010002' => (!empty($datos[0]) ? utf8_encode($datos[0]) : ""), // nombre
												'LGF0010003' => (!empty($datos[1]) ? utf8_encode($datos[1]) : ""), // ape Paterno
												'LGF0010004' => (!empty($datos[2]) ? utf8_encode($datos[2]) : ""), // ape Materno
												'LGF0010005' => $username, // user
												'LGF0010006' => sha1($username), // password
												'LGF0010007' => 6, // perfil 2.- Alumno 6.- Docente
												'LGF0010008' => 1, // activo/inactivo
												'LGF0010021' => $datos[4], // genero
												'LGF0010030' => date("Y-m-d H:i:s"), // fecha y hora de creacion
												'LGF0010038' => $idInstitucion, // institucion
												'LGF0010040' => $datos[3], // curp
												'LGF0010041' => $datos[5] // cct
											);
										} else {
											array_push($noRegistrado, array(
												"Nombre" => utf8_encode($datos[0]),
												"ApellidoPaterno" => utf8_encode($datos[1]),
												"ApellidoMaterno" => utf8_encode($datos[2]),
												"Genero" => $datos[4],
												"CURP" => $datos[3],
												"Insitucion" => $datos[5],
												"Motivo" => "La institución con el C.C.T ".$datos[5]." no se encuentra registrada en el sistema."
											));
										}
									} else {
										array_push($noRegistrado, array(
											"Nombre" => utf8_encode($datos[0]),
											"ApellidoPaterno" => utf8_encode($datos[1]),
											"ApellidoMaterno" => utf8_encode($datos[2]),
											"Genero" => $datos[4],
											"CURP" => $datos[3],
											"Insitucion" => $datos[5],
											"Motivo" => "La siguiente CURP ".$datos[3]." ya se encuentra registrada en el sistema."
										));
									}
								} else {
									array_push($noRegistrado, array(
										"Nombre" => utf8_encode($datos[0]),
										"ApellidoPaterno" => utf8_encode($datos[1]),
										"ApellidoMaterno" => utf8_encode($datos[2]),
										"Genero" => $datos[4],
										"CURP" => $datos[3],
										"Insitucion" => $datos[5],
										"Motivo" => "La columna CURP se encuentra vacía, favor de verificar bien los datos."
									));
								}
							}
						}
						fclose($fichero);
						unlink($destino);
						$docentesOk = array();
						if (count($usuarios) > 0) {
							$totalReg = count($usuarios);
							$regAdd = 0;
							for ($i=0; $i < count($usuarios); $i++) {
								// Validación de CURP
								$check = (new Administrador())->check_matricula($usuarios[$i]['LGF0010040']);
								if (count($check) == 0) {
									$usuarios[$i]['LGF0010005'] = $this->validarUsuario($usuarios[$i]['LGF0010005']);
									$usuarios[$i]['LGF0010006'] = sha1($usuarios[$i]['LGF0010005']);
									// print_r($usuarios[$i]);
									$respuesta = (new Usuarios())->agregarUsuario((object) $usuarios[$i]);
									// echo "Respuesta: ".$respuesta;
									if ($respuesta) {
										$regAdd++;
										$recover = array("LGF0330001"=>$respuesta,"LGF0330002"=>$usuarios[$i]['LGF0010005'], "LGF0330003"=>$usuarios[$i]['LGF0010007']);
										$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
										array_push( $docentesOk, array(
											"Institucion" => $usuariosNew[$i]['LGF0010041'],
											"Nombre" => $usuarios[$i]['LGF0010002'],
											"ApellidoPaterno" => $usuarios[$i]['LGF0010003'],
											"ApellidoMaterno" => $usuarios[$i]['LGF0010004'],
											"Usuario" => $usuarios[$i]['LGF0010005'],
											"Contraseña" => $usuarios[$i]['LGF0010005']
										));
									}
								} else {
									$checkR = array('LGF0270028' => $usuarios[$i]['LGF0010038']);
									$obtenerInstitucion = (new Instituciones())->obtenInstitucion((object) $checkR);
									array_push($noRegistrado, array(
										"Nombre" => $usuarios[$i]['LGF0010002'],
										"ApellidoPaterno" => $usuarios[$i]['LGF0010003'],
										"ApellidoMaterno" => $usuarios[$i]['LGF0010004'],
										"Genero" => $usuarios[$i]['LGF0010021'],
										"CURP" => $usuarios[$i]['LGF0010040'],
										"Insitucion" => $obtenerInstitucion[0]['LGF0270028'],
										"Motivo" => "La siguiente CURP ".$usuarios[$i]['LGF0010040']." ya se encuentra registrada en el sistema."
									));
								}
							}
							// echo "</pre>";
							$mensaje = "Se registro un total de ".$regAdd." usuarios de ".$totalReg." registros.";
						} else {
							$mensaje = "no hay registros para importar";
						}
						$cadena1 = null;
						if (count($noRegistrado) > 0) {
							$cadena = $noRegistrado;
						}
						$cadena2 = null;
						if (count($docentesOk) > 0) {
							$cadena2 = $docentesOk;
						}
						//$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$cadena, "titulo"=>"datos_existentes_docente"));
						$this->renderJSON(array("error"=>0,"mensaje" => $mensaje, "data"=>$cadena2, "titulo" => "docentes_cargados", "data1" => $cadena1, "titulo1" => "datos_existentes_docente"));
					break;
				}
			}
		}

		public function eliminar_espacio($value, $opc = 0) { 
			for ($i=0; $i < strlen($value); $i++) { 
				if ($opc == 1) {
					$value = str_replace(" ", "", utf8_decode($value));
					$value = str_replace("?", "", utf8_decode($value));
				} else {
					//if (utf8_decode($value[0]) == "?") {
					//	$value = str_replace("?", "", utf8_decode($value));
					//}
				}
			}
			$value = trim($value);
			return utf8_encode($value);
		}
	}