<?php
class AjaxHomeController extends Controller_Learnglish {
	public function __construct() {
		parent::__construct ();
	}

    public function obtenerLeccionesAlumnoDesdeId(){
        $id = $_POST['id'];
        $_SESSION['alumnoQueRealizaEvaluacion'] = $id;
        $modulo = (new Usuarios())->obtenerLeccionesParaAlumnos($id);

        $lecciones = (new Administrador())->mostrarLecciones($leccion = $modulo[0]['LGF0010024']);

        $object = array (
            'data' => $lecciones
        );

        $this->renderJSON ( $object );

    }

    public function obtenerUsuariosBusquedaEvaluacionTrimestral(){
        $nombre = $_POST['nombre'];
        $alumnos = (new Usuarios())->obtenerUsuariosDesdeInstitucion($nombre);

        $object = array (
            'data' => $alumnos
        );

        $this->renderJSON ( $object );
    }

    public function guardarAvanceAlumno(){
        $creado = false;
        $data = explode('_', $_POST['parte1']);
        $seccion = $_POST['seccion'];
        $usuario = $_SESSION ["idUsuario"];

        $avance = (new AvancesAlumno())->agregarAvance((object) array(
            "LGF0410002" => $data[0], #nivel
            "LGF0410003" => $data[1], #modulo
            "LGF0410004" => $data[2], #leccion
            "LGF0410005" => $seccion, #seccion
            "LGF0410006" => $usuario, #usuario
        ));

        if($avance){
            $creado = true;
        }

        $object = array (
            'creado' => $creado
        );

        $this->renderJSON ( $object );
    }

	public function setDataOda() {
		$usuario = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"LGF0010001" => $this->userid 
		) );
		$usuario = $usuario [0];
		$usuario ["LGF0010002"] = $_POST ['nombre'];
		$usuario ["LGF0010037"] = $_POST ['edad'];
		$usuario ["LGF0010036"] = $_POST ['ciudad'];
		$usuario ["LGF0010022"] = date ( "Y-m-d", strtotime ( $_POST ['nacimiento'] ) );
		$usuario ["LGF0010009"] = $this->archivo_base64 ( "file" );
		$ok = (new Usuarios ())->actualizarUsuario ( ( object ) $usuario, ( object ) array (
				"LGF0010001" => $this->userid 
		) );
		if ($ok) {
			$object = array (
					'msg' => 'Los datos fueron insertados correctamente' 
			);
		} else {
			$object = array (
					'msg' => 'Error los datos no se almacenaron' 
			);
		}
		$this->renderJSON ( $object );
	}
	public function getDataOda() {
		$usuario = (new Usuarios ())->obtenUsuario ( ( object ) array (
				"LGF0010001" => $this->userid 
		) );
		$datos ['nombre'] = $usuario [0] ["LGF0010002"];
		$datos ['edad'] = $usuario [0] ["LGF0010037"];
		$datos ['ciudad'] = $usuario [0] ["LGF0010036"];
		$datos ['nacimiento'] = $usuario [0] ["LGF0010022"];
		$datos ['imagen'] = $usuario [0] ["LGF0010009"];
		$datos ['g'] = $usuario [0] ["LGF0010002"];
		$datos ['c'] = $usuario [0] ["LGF0010037"];
		$datos ['a'] = $usuario [0] ["LGF0010036"];
		$datos ['f'] = $usuario [0] ["LGF0010022"];
		$datos ['file'] = $usuario [0] ["LGF0010009"];
		$this->renderJSON ( $datos );
	}
	/* Trae nombre de la evalaucion con preguntas y respuestas. */
	public function getEvaluacion() {
		$e = array ();
		// echo ":D ".$_POST['repetir'];
		// print_r($_POST);
		$mostrar = 0;
		$datos = (new Administrador())->evaluacion($_POST["modulo"], $_POST["leccion"]);
		$evaluacion = (new Administrador())->existe_evaluacion($this->userid, $datos[0]['idprueba']);

		if ($_POST['repetir'] == 1) {
			if (!empty($datos)) {
				$mostrar = $datos[0]["preguntas_mostrar"];
				foreach($datos as $obj) {
					array_push($e, array(
						'idprueba' => $obj["idprueba"],
						'prueba' => $obj["prueba"],
						'id_pregunta' => $obj["idpreg"],
						'pregunta' => $obj["pregunta"],
						'pregunta_img' => $this->retornarArchivo($obj["pregunta_img"]),
						'file' => $this->tipo_conversion($obj["pregunta_img"]),
						'ruta' => ARCHIVO_FISICO,
						'tipo_pregunta' => (!empty($obj["pregunta"]) && ! empty($obj["pregunta_img"]) ? 3 : (empty($obj["pregunta"]) ? 2 : 1)),
						'modulo' => $obj["modulo"],
						'leccion' => $obj["leccion"],
						'tipo'=>$obj["tipo"],
						'respuestas' => [
							[
								// 'tipo' => (!empty($obj["resp1"]) && ! empty($obj["resp1_img"])) ? 3 : (empty($obj["resp2"]) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp1_img"], $obj["resp1"]),
								'texto' => empty($obj["resp1"]) ? $obj["resp1_img"] : $obj["resp1"],
								// 'img' => empty($obj["resp1"]) ? $obj["resp1_img"] : $obj["resp1"],
								'img' => $obj["resp1_img"],
								'ID' => $obj["rid1"]
							],
							[
								// 'tipo' => (!empty($obj["resp2"]) && !empty($obj["resp2_img"])) ? 3 : (empty($obj["resp2"]) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp2_img"], $obj["resp2"]),
								'texto' => $obj["resp2"],
								'img' => $obj["resp2_img"],
								'ID' => $obj["rid2"]
							],
							[
								// 'tipo' => (!empty ( $obj ["resp3"] ) && ! empty ( $obj ["resp3_img"] )) ? 3 : (empty ( $obj ["resp3"] ) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp3_img"], $obj["resp3"]),
								'texto' => $obj ["resp3"],
								'img' => $obj ["resp3_img"],
								'ID' => $obj ["rid3"]
							],
							[
								// 'tipo' => (! empty ( $obj ["resp4"] ) && ! empty ( $obj ["resp4_img"] )) ? 3 : (empty ( $obj ["resp4"] ) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp4_img"], $obj["resp4"]),
								'texto' => $obj ["resp4"],
								'img' => $obj ["resp4_img"],
								'ID' => $obj ["rid4"]
							]
						]
					));
				}

				foreach($e as $keys => $value) {
					if($value["tipo"] == 0) {
						unset($e[$keys]["respuestas"]["2"]);
						unset($e[$keys]["respuestas"]["3"]);
					}
				}
				$e = array_slice($e, 0, $mostrar);
			}

			$this->renderJSON($e);
		}

		if (!empty($evaluacion)) {
			array_push($e, array(
				'mensaje' => 'Ha finalizado la evaluación.',
				'porcentaje' => $evaluacion[0]['porcentaje'],
				'idprueba' => $datos[0]["idprueba"]
			));
			$this->renderJSON($e);
		} else {
			if (!empty($datos)) {
				$mostrar = $datos[0]["preguntas_mostrar"];
				foreach($datos as $obj) {
					array_push($e, array(
						'idprueba' => $obj["idprueba"],
						'prueba' => $obj["prueba"],
						'id_pregunta' => $obj["idpreg"],
						'pregunta' => $obj["pregunta"],
						'pregunta_img' => $this->retornarArchivo($obj["pregunta_img"]),
						'file' => $this->tipo_conversion($obj["pregunta_img"]),
						// 'ruta' => ARCHIVO_FISICO,
						'ruta' => "Hola",
						'tipo_pregunta' => (!empty($obj["pregunta"]) && ! empty($obj["pregunta_img"]) ? 3 : (empty($obj["pregunta"]) ? 2 : 1)),
						'modulo' => $obj["modulo"],
						'leccion' => $obj["leccion"],
						'tipo'=>$obj["tipo"],
						'respuestas' => [
							[
								// 'tipo' => (!empty($obj["resp1"]) && ! empty($obj["resp1_img"])) ? 3 : (empty($obj["resp2"]) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp1_img"], $obj["resp1"]),
								'texto' => empty($obj["resp1"]) ? $obj["resp1_img"] : $obj["resp1"],
								// 'img' => empty($obj["resp1"]) ? $obj["resp1_img"] : $obj["resp1"],
								'img' => $obj["resp1_img"],
								'ID' => $obj["rid1"]
							],
							[
								// 'tipo' => (!empty($obj["resp2"]) && !empty($obj["resp2_img"])) ? 3 : (empty($obj["resp2"]) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp2_img"], $obj["resp2"]),
								'texto' => $obj["resp2"],
								'img' => $obj["resp2_img"],
								'ID' => $obj["rid2"]
							],
							[
								// 'tipo' => (!empty ( $obj ["resp3"] ) && ! empty ( $obj ["resp3_img"] )) ? 3 : (empty ( $obj ["resp3"] ) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp3_img"], $obj["resp3"]),
								'texto' => $obj ["resp3"],
								'img' => $obj ["resp3_img"],
								'ID' => $obj ["rid3"]
							],
							[
								// 'tipo' => (! empty ( $obj ["resp4"] ) && ! empty ( $obj ["resp4_img"] )) ? 3 : (empty ( $obj ["resp4"] ) ? 2 : 1),
								'tipo' => self::obtenerTipo($obj["resp4_img"], $obj["resp4"]),
								'texto' => $obj ["resp4"],
								'img' => $obj ["resp4_img"],
								'ID' => $obj ["rid4"]
							]
						]
					));
				}

				foreach($e as $keys => $value) {
					if($value["tipo"] == 0) {
						unset($e[$keys]["respuestas"]["2"]);
						unset($e[$keys]["respuestas"]["3"]);
					}
				}
				$e = array_slice($e, 0, $mostrar);
			}

			$this->renderJSON($e);
		}
	}

	public function obtenerTipo($imagen, $texto) {
		if ($imagen != "") {
			if (strpos($imagen, 'data:image') !== false && $texto != "") {
				$tipo = 3;
			} else if (strpos($imagen, 'data:image') !== false && $texto == "") {
				$tipo = 2;
			} else if (strpos($imagen, 'data:audio') !== false && $texto != "") {
				$tipo = 4;
			} else if (strpos($imagen, 'data:audio') !== false && $texto == "") {
				$tipo = 5;
			}
		} else {
			$tipo = 1;
		}
		return $tipo;
	}
	
	/* Guardado de la evaluacion por leccion. */
	public function setEvaluacion() {
		$data = json_decode ( $_POST ["preguntas"] );
		$res = json_decode ( $_POST ["preguntas"], true );

		$evaluacion = (new Administrador())->existe_evaluacion($this->userid, $res[0][0]['id_evaluacion']);

		$detalles = array ();
		$resultados = array ();
		$this->resultadoPrueba ( $data, $detalles, $resultados );
		$porcentaje_obtenido = $resultados['LGF0220003'];
		if (count($evaluacion) == 1) {
			// print_r($resultados);
			$nuevo_porcentaje = $resultados['LGF0220003'];
			$porcentaje_anterior = $evaluacion[0]['porcentaje'];
			if ($nuevo_porcentaje > $porcentaje_anterior) {
				$informacion = array('LGF0220003' =>$resultados['LGF0220003']);
				
				if ($porcentaje_obtenido >= 60) {
					$this->actualizar_modulo_leccion($evaluacion[0]['leccion']);
				}

				$obtenerDetalleResultadoEvaluacion = (new Administrador())->obtenerDetalleResultadoEvaluacion($evaluacion[0]['id']);
				// print_r($obtenerDetalleResultadoEvaluacion);
				for ($i=0; $i < count($obtenerDetalleResultadoEvaluacion); $i++) { 
					$eliminarDetalleResultadoEvaluacion = (new DetalleResultadosEvaluacion())->eliminaDetalleResultadosEvaluacion((object) array (
						"LGF0230001" => $obtenerDetalleResultadoEvaluacion[$i]['id']
					));
				}

				// print_r($detalles);

				foreach ( $detalles as $detalle ) {
					$detalle ["LGF0230002"] = $evaluacion[0]['id'];
					(new DetalleResultadosEvaluacion ())->agregarDetalleResultadosEvaluacion ( ( object ) $detalle );
				}

				$id_resultado_evaluacion = (new ResultadosEvaluacion ())->actualizarResultadosEvaluacion((object) $informacion, (object) array (
					"LGF0220001" => $evaluacion[0]['id']
				));
			} else {
				$id_resultado_evaluacion = true;
			}
			// echo "Respuesta: ";print_r($id_resultado_evaluacion);
		} else {
			if ($porcentaje_obtenido >= 60) {
				$this->actualizar_modulo_leccion($evaluacion[0]['leccion']);
			}
			$id_resultado_evaluacion = (new ResultadosEvaluacion ())->agregarResultadosEvaluacion ( ( object ) $resultados );
			foreach ( $detalles as $detalle ) {
				$detalle ["LGF0230002"] = $id_resultado_evaluacion;
				(new DetalleResultadosEvaluacion ())->agregarDetalleResultadosEvaluacion ( ( object ) $detalle );
			}
		}
		
			
		if ($id_resultado_evaluacion) {
			$this->renderJSON ( array (
					"mensaje" => "Ha finalizado la evaluación.",
					'porcentaje' => $resultados ["LGF0220003"] 
			) );
		} else {
			$this->renderJSON ( array (
					"mensaje" => "Error al guardar la evaluación, favor de realizarla nuevamente." 
			) );
		}
	}
	/* Se arma el objeto para el resultado de la prueba. */
	private function resultadoPrueba($data, &$detalle, &$resultados) {
		$porcentaje = 0;
		$id_evaluacion = 0;
		$total = 0;
		foreach ( $data as $value ) {
			$value = $value [0];
			$c = 0;
			$total ++;
			$res = (new RespuestasEvaluacion ())->obtenRespuestasEvaluacion ( ( object ) array (
					"LGF0210001" => $value->id_respuesta 
			) );
			$res = $res [0];
			if ($res ["LGF0210005"] == "V") {
				$porcentaje ++;
				$c = 1;
			}
			array_push ( $detalle, array (
					"LGF0230003" => $value->id_pregunta,
					"LGF0230004" => $value->id_respuesta,
					"LGF0230005" => $c,
					"LGF0230006" => date ( "Y-m-d H:i:s" ) 
			) );
			if (empty ( $id_evaluacion ))
				$id_evaluacion = $value->id_evaluacion;
		}
		$resultados ["LGF0220002"] = $this->userid;
		//se modifico para que guarde la calificacion en lugar de los aciertos -> $resultados ["LGF0220003"] = $acierto;
		$resultados ["LGF0220003"] = ($porcentaje * 100)/$total;
		// $resultados["LGF0220004"] = $tiempo;
		$resultados ["LGF0220005"] = date ( "Y-m-d H:i:s" );
		$resultados ["LGF0220006"] = $id_evaluacion;
	}

	public function tipo_conversion($objeto) {
		if (!empty($objeto)) {
			if (strpos($objeto, 'data:image/png') !== false || strpos($objeto, 'data:image/jpeg') !== false) {
				$file = "imagen";
			} else if (strpos($objeto, 'data:audio/mp3') !== false) {
				$file = "audio";
			} else if (strpos($objeto, 'data:video/mp4') !== false) {
				$file = "video";
			} else {
				$extension = explode(".", $objeto);
				if ($extension[1] == "png" || $extension[1] == "jpg") {
					$file = "imagen";
				} else if ($extension[1] == "mp3") {
					$file = "audio";
				} else {
					$file = "video";
				}
			}
		} else {
			$file = "";
		}
		return $file;
	}

	public function retornarArchivo($objeto) {
		if (!empty($objeto)) {
			if (strpos($objeto, 'data:image/png') !== false || strpos($objeto, 'data:image/jpeg') !== false) {
				return $objeto;
			} else if (strpos($objeto, 'data:audio/mp3') !== false) {
				return $objeto;
			} else if (strpos($objeto, 'data:video/mp4') !== false) {
				return $objeto;
			} else {
				$extension = explode(".", $objeto);
				if ($extension[1] == "png" || $extension[1] == "jpg") {
					return ARCHIVO_FISICO.$objeto;
				} else if ($extension[1] == "mp3") {
					return ARCHIVO_FISICO.$objeto;
				} else {
					return ARCHIVO_FISICO.$objeto;
				}
			}
		} else {
			$file = "";
		}
		return $file;
	}

	private function actualizar_modulo_leccion($leccion) {
		return true;
		if ($_SESSION['perfil'] == 2) {
			$datos = (new Usuarios ())->obtenUsuario ( ( object ) array (
					"LGF0010001" => $this->userid 
			) );
			$datos = $datos[0];
			$nivelOld = $datos["LGF0010023"];
			$moduloOld = $datos["LGF0010024"];
			$leccionOld = $datos["LGF0010025"];
			if ($_SESSION['perfil'] == 2) {
				if ($nivel >= $nivelOld) {
					if ($modulo > $moduloOld) {
						if ($leccion > $leccionOld) {
							$nueva_leccion = $leccion + 1;
							$modulo_paso = (new Administrador())->ultima_seccion($nueva_leccion);
							
							$usuario = array(
								"LGF0010023" => $modulo_paso[0]['nivel'],
								"LGF0010024" => $modulo_paso[0]['modulo'],
								"LGF0010025" => $modulo_paso[0]['leccion'],
								"LGF0010026" => $modulo_paso[0]['seccion']
							);
							
							(new Usuarios ())->actualizarUsuario ( ( object ) $usuario, ( object ) array (
									"LGF0010001" => $this->userid 
							) );
						}
					}
				}
			}
		}
	}

	/**
	 * funciones del docente
	 */
	public function mostrar_grupos() {
		$grupos = (new Administrador())->docente_grupos($_SESSION['idUsuario']);
		$tabla = "";
		$clase = "preescolar";
		if (empty($grupos)) {
			$error = 1;
		} else {
			$error = 0;
		}

		foreach ($grupos as $grupo) {
			if ($grupo['nivelid'] == 2) {
				$clase = "primaria";
			} else if ($grupo['nivelid'] == 3) {
				$clase = "secundaria";
			}
			// Linea con opcion de configuración de acceso a lecciones por criterio del docente
			$tabla.="<tr>
                        <td>".$grupo['grupo']."</td>
                        <td>".$grupo['alumnos']."</td>
                        <td class='".$clase."'>".$grupo['nivel']."</td>
                        <td class='".$clase."'>".$grupo['lecciones']."</td>
                        <td class='".$clase."'>
                            <a href='".CONTEXT."home/guides/".$grupo['modulo']."/".$grupo['id']."' >Guías</a>
                        </td>
                        <td class='".$clase."'>
                            <a href='".CONTEXT."home/means/".$grupo['modulo']."/".$grupo['id']."' >Recursos</a>
                        </td>
                        <td class='".$clase."'>
                            <a href='".CONTEXT."home/results/".$grupo['id']."/".$grupo['nivelid']."' >Reportes</a>
                        </td>
                        <td>
                            <a style='color: #0d6efd;' onclick='gestionar_lecciones(".$grupo['modulo'].",".$grupo['id'].",".$grupo['docenteid'].")'>Gestionar accesos a lecciones</a>
                        </td>
                        <td>
                            <button class='btn my-2 d-block boton-mostrar-alumnos' data-bs-toggle='modal' grupo='".$grupo['id']."' data-bs-target='#modalAlumnosMostrar' style='color: #0d6efd;'   >
                                Ver alumnos de grupo
                            </button>
                        </td>
                     </tr>";
			
			// Linea original
			//$tabla.="<tr><td>".$grupo['grupo']."</td><td>".$grupo['alumnos']."</td><td class='".$clase."'>".$grupo['nivel']."</td><td class='".$clase."'>".$grupo['lecciones']."</td><td class='".$clase."'><a href='".CONTEXT."home/guides/".$grupo['modulo']."/".$grupo['id']."' >Guías</a></td><td class='".$clase."'><a href='".CONTEXT."home/means/".$grupo['modulo']."/".$grupo['id']."' >Recursos</a></td><td class='".$clase."'><a href='".CONTEXT."home/results/".$grupo['id']."/".$grupo['nivelid']."' >Reportes</a></td></tr>";
		}
		$this->renderJSON(array("contenido" => $tabla, "error" => $error));
	}

	public function cargar_registros() {
		$seccion = $_POST['seccion'];
		$grupo = $_POST['grupo'];
		$fecha = $_POST['fecha'];
        $origen = $grupo;

        /**
		 * Seccion del tutor
		 */
		$tutor = false;
		$alumno = 0;

		/*if (!is_numeric($grupo)) {
			for ($i=0; $i < strlen($grupo); $i++) {
				if (!is_numeric($grupo[$i])) {
					$tutor = true;
                    $origen = $grupo[$i];
					$aux = explode($grupo[$i], $grupo);
					$posicion = $i;
					$alumno = $aux[1];
				}
			}
		}*/
		// echo "Alumno: ".$alumno."\n";

		$usuariosid = "";
		if ($origen != "T") {
			// echo "1";
			$users = (new Usuarios())->obtenUsuario((object) array("LGF0010039" => $grupo));
			$cont = 0;
			foreach ($users as $user) {
				if ($user["LGF0010008"] == 1 && $user["LGF0010007"] == 2) {
					$modulo = $user["LGF0010024"];
					if ($cont == 0) {
						$usuariosid = $user["LGF0010001"];
					} else {
						$usuariosid.= ", ".$user["LGF0010001"];
					}
					$cont++;
				}
			}
		} else {
			// echo "2";
			$usuariosid = $alumno;
			$users = (new Usuarios())->obtenUsuario((object) array("LGF0010001" => $alumno));
			// print_r($users);
			$modulo = $users[0]["LGF0010024"];
		}
        #echo "Ini2: ".$seccion." > $grupo";

		if ($seccion == 1) {
			$this->registro_evaluaciones($usuariosid, $modulo, $fecha);
		} else {
			$this->registro_habilidades($usuariosid, $modulo, $fecha);
		}
	}

	public function registro_evaluaciones($usuariosid, $modulo, $fecha) {
		$lecciones = (new Administrador())->obtenerMaxLecciones();
        
		$datos = (new Administrador())->registro_evaluaciones($usuariosid, $lecciones[0]['num'], $modulo);

		foreach ($datos as $key => $value) {
			for ($i=1; $i <= $lecciones[0]['num']; $i++) { 
				$posicion = 0;
				
				$suma = (new Administrador())->obtener_promedios($i, 3, $value['id'], $fecha);

                try{
				    $promedio = round($suma[0]["promL".$i] / $suma[0]['total']);
                }catch(DivisionByZeroError $e){
                    $promedio = 0;
                }
				if ($i==1) {
					$total = $promedio;
				} else {
					$total.= "|".$promedio;
				}
				if ($suma[0]['id'] == $value['id']) {
					$datos[$key]['promedio'] = $total;
				}
			}
			$datos[$key]['promedio'] = $total;
		}

		$columnas = "";
		$cont = 1;
		foreach ($datos as $dato) {
			$aux = explode("|", $dato['promedio']);
			$nombre = $dato['nombre']." ".$dato['apepat']." ".$dato['apemat'];
			$columnas.="<tr>
                            <td><a target='_blank' href='".CONTEXT."admin/editUsuario/".$dato["id"]."'>$nombre</a></td>";
			$suma = 0;
			$contador1 = 0;
			for ($i=0; $i < count($aux); $i++) { 
				$columnas.="<td>".$aux[$i]."</td>";
				$suma = $suma + $aux[$i];
				if ($aux[$i] != 0) {
					$contador1++;
				}
			}
			if ($contador1 == 0) {
				$contador1 = $lecciones[0]['num'];
			}
			$promedioL = ($suma/$contador1);
			$columnas.="<td>".$promedioL."</td></tr>";
			$cont++;
		}
		$this->renderJSON(array("contenido" => $columnas));
	}

	public function registro_habilidades($usuariosid, $modulo, $fecha) {
		$datos = (new Administrador())->registro_habilidades($usuariosid, $modulo, $fecha);
		
		$columnas = "";
		$promedio = 0;
		foreach ($datos as $dato) {
			$nombre = $dato['nombre']." ".$dato['apepat']." ".$dato['apemat'];
			$vocabulary = round($dato['vocabulary']);
			$grammar = round($dato['grammar']);
			$reading = round($dato['reading']);
			$listening = round($dato['listening']);
			$speaking = round($dato['speaking']);
			$columnas.="<tr><td>".$nombre."</td>";
			$promedio = ($vocabulary+$grammar+$reading+$listening+$speaking) / 5;
			$columnas.="<td>".$vocabulary."</td><td>".$grammar."</td><td>".$reading."</td><td>".$listening."</td><td>".$speaking."</td><td>".$promedio."</td></tr>";
		}

		$this->renderJSON(array("contenido" => $columnas));
	}

	public function profile() {
		/*$password = $_POST['password'];
		$pass = $_POST['pass'];
		$email = $_POST['email'];*/
		$foto = $_FILES['foto']['name'];
		/*$informacion = $_POST['informacion'];*/

		/*if ($informacion == 1) {
			$check = (new Administrador())->informacion_usuario($_SESSION['idUsuario']);
			if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
				$datos = $check[0]['LGF0010002']."|".$check[0]['LGF0010003']."|".$check[0]['LGF0010004']."|".$check[0]['LGF0010005'];
			} else if ($_SESSION['perfil'] == 4) {
				$datos = $check[0]['LGF0270002'];
			} else if ($_SESSION['perfil'] == 3) {
				$datos = $check[0]['LGF0280002'];
			}
			$this->renderJSON(array("datos" => $datos));
		} else if ($informacion == 2) {
			$check = (new Administrador())->informacion_usuario($_SESSION['idUsuario']);
			if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
				$datos = $check[0]['LGF0010005'];
			} else if ($_SESSION['perfil'] == 4) {
				$datos = $check[0]['LGF0270024'];
			} else if ($_SESSION['perfil'] == 3) {
				$datos = $check[0]['LGF0280019'];
			}
			$this->renderJSON(array("datos" => $datos));
		} else if ($informacion == 3) {
			$username = $_POST['user'];
			$check = (new Administrador())->check_nombre_usuario($username);
			$this->renderJSON(array("error" => $check[0]['total']));
		} else {*/
			$nombreIMG = "";
			if ($foto != "") {
				$fileTmpPath = $_FILES['foto']['tmp_name'];
				$fileName = $_FILES['foto']['name'];
				$fileSize = $_FILES['foto']['size'];
				$fileType = $_FILES['foto']['type'];
				$fileNameCmps = explode(".", $fileName);
				$fileName = str_replace(" ", "_", $fileNameCmps[0]);
				$fileExtension = strtolower(end($fileNameCmps));

				$time = time();
				$newFileName = $time.'.'.$fileExtension;
				
				$allowedfileExtensions = array('jpg', 'png');
                $uploadFileDir = __DIR__.'./../../portal/IMG/perfil/';
				if (in_array($fileExtension, $allowedfileExtensions)) {
					$dest_path = $uploadFileDir.$newFileName;
					if(move_uploaded_file($fileTmpPath, $dest_path)) {
						$nombreIMG = $newFileName;
					} else {
						$nombreIMG = $this->archivo_base64($campo);
					}
				}

                $data = [];
                if ($nombreIMG != "") {
                    $data["LGF0010009"] = $nombreIMG;

                    $verificaHayFotoUsuario = (new Usuarios())->obtenUsuario((object) array(
                        "LGF0010001" => $_SESSION['idUsuario']
                    ));

                    if(is_file($uploadFileDir.$verificaHayFotoUsuario[0]['LGF0010009'])){
                        unlink($uploadFileDir.$verificaHayFotoUsuario[0]['LGF0010009']);
                    }

                    (new Usuarios())->actualizarUsuario((object) $data, (object) array (
                        "LGF0010001" => $_SESSION['idUsuario']
                    ));

                    $this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
                }
                else{
                    $this->renderJSON(array("mensaje" => "Tipo de archivo no compatible."));
                }
			}else{
                $this->renderJSON(array("mensaje" => "Archivo requerido."));
            }


			/*if ($_SESSION['perfil'] == 3) {
				if ($_POST['uName'] != "") {
					$data['LGF0280002'] = $_POST['uName'];
				}
				if ($_POST['cUser'] != "") {
					$data['LGF0280019'] = $_POST['cUser'];
				}
				if ($pass != "") {
					$checkPassUser = (new Administrador())->checkPassUser($_SESSION['idUsuario'], $_SESSION['perfil']);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$_SESSION['idUsuario'], "LGF0330003"=>$_SESSION['perfil']));
					}
				}

				if ($password != "" && $email != "") {
					$data['LGF0280020'] = $password;
					$data['LGF0280018'] = $email;

					if ($nombreIMG != "") {
						$data['LGF0280023'] = $nombreIMG;
					}
					$respuesta = (new Clientes())->actualizar((object) $data, (object) array (
						"LGF0280001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else if ($password == "" && $email != "") {
					$data['LGF0280018'] = $email;
					if ($nombreIMG != "") {
						$data['LGF0280023'] = $nombreIMG;
					}
					$respuesta = (new Clientes())->actualizar((object) $data, (object) array (
						"LGF0280001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else if ($password != "" && $email == "") {
					$data['LGF0280020'] = $password;
					if ($nombreIMG != "") {
						$data['LGF0280023'] = $nombreIMG;
					}
					$respuesta = (new Clientes())->actualizar((object) $data, (object) array (
						"LGF0280001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else {
					if ($nombreIMG != "") {
						$data['LGF0280023'] = $nombreIMG;
					}
					$respuesta = (new Clientes())->actualizar((object) $data, (object) array (
						"LGF0280001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				}
			} else if ($_SESSION['perfil'] == 4) {
				if ($_POST['uName'] != "") {
					$data['LGF0270002'] = $_POST['uName'];
				}
				if ($_POST['cUser'] != "") {
					$data['LGF0270024'] = $_POST['cUser'];
				}

				if ($pass != "") {
					$checkPassUser = (new Administrador())->checkPassUser($_SESSION['idUsuario'], $_SESSION['perfil']);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$respuesta = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$_SESSION['idUsuario'], "LGF0330003"=>$_SESSION['perfil']));
					}
				}
				if ($password != "" && $email != "") {
					// echo 1;
					$data['LGF0270025'] = $password;
					$data['LGF0270027'] = $email;
					if ($nombreIMG != "") {
						$data['LGF0270026'] = $nombreIMG;
					}
					$respuesta = (new Instituciones())->actualizarInstitucion((object) $data, (object) array (
						"LGF0270001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else if ($password == "" && $email != "") {
					// echo 2;
					$data['LGF0270027'] = $email;
					if ($nombreIMG != "") {
						$data['LGF0270026'] = $nombreIMG;
					}
					$respuesta = (new Instituciones())->actualizarInstitucion((object) $data, (object) array (
						"LGF0270001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else if ($password != "" && $email == "") {
					// echo 3;
					$data['LGF0270025'] = $password;
					if ($nombreIMG != "") {
						$data['LGF0270026'] = $nombreIMG;
					}
					$respuesta = (new Instituciones())->actualizarInstitucion((object) $data, (object) array (
						"LGF0270001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else {
					// echo 4;
					if ($nombreIMG != "") {
						$data['LGF0270026'] = $nombreIMG;
					}
					$respuesta = (new Instituciones())->actualizarInstitucion((object) $data, (object) array (
						"LGF0270001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				}
			} else if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
				/*foreach ($_POST as $key => $value) {
					echo $key." => ".$value."\n<br>";
				}*/

				/*$username = $_POST['cUser'];
				$check = (new Administrador())->check_nombre_usuario($username);
				if ($check[0]['total'] == 1) {
					$this->renderJSON(array("mensaje" => "El nombre de usuario <b>$user</b> ya existe en el sistema"));
				}
				if ($_POST['cUser'] != "") {
					$data['LGF0010005'] = $_POST['cUser'];
				}

				if (!empty($_POST['uName'])) {
					$data['LGF0010002'] = $_POST['uName'];
				}
				if (!empty($_POST['uPat'])) {
					$data['LGF0010003'] = $_POST['uPat'];
				}
				
				if (!empty($_POST['uMat'])) {
					$data['LGF0010004'] = $_POST['uMat'];
				}
				
				if ($pass != "") {
					$checkPassUser = (new Administrador())->checkPassUser($_SESSION['idUsuario'], $_SESSION['perfil']);
					if (empty($checkPassUser)) {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$res = (new PasswordReset())->agregarPassUsuario((object) $recover);
					} else {
						$recover = array("LGF0330001"=>$_SESSION['idUsuario'],"LGF0330002"=>$pass, "LGF0330003"=>$_SESSION['perfil']);
						$up = (new PasswordReset())->actualizarPassUsuario((object) $recover, (object) array (
							"LGF0330001"=>$_SESSION['idUsuario'], "LGF0330003"=>$_SESSION['perfil']));
					}
				}
				
				if ($password != "" && $email != "") {
					$data['LGF0010012'] = $email;
					$data['LGF0010006'] = $password;*/

                    /*$data = [];
					if ($nombreIMG != "") {
						$data["LGF0010009"] = $nombreIMG;
					}*/

					/*echo "1<pre>";
					print_r($data);
					echo "</pre>";*/
					// die();

					/*$respuesta = (new Usuarios())->actualizarUsuario((object) $data, (object) array (
						"LGF0010001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));*/
				/*} else if ($password == "" && $email != "") {
					$data['LGF0010012'] = $email;
					if ($nombreIMG != "") {
						$data["LGF0010009"] = $nombreIMG;
					}*/
					/*echo "2<pre>";
					print_r($data);
					echo "</pre>";
					$respuesta = (new Usuarios())->actualizarUsuario((object) $data, (object) array (
						"LGF0010001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				/*} else if ($password != "" && $email == "") {
					$data['LGF0010006'] = $password;
					if ($nombreIMG != "") {
						$data["LGF0010009"] = $nombreIMG;
					}*/
					/*echo "3<pre>";
					print_r($data);
					echo "</pre>";*/
					/*$respuesta = (new Usuarios())->actualizarUsuario((object) $data, (object) array (
						"LGF0010001" => $_SESSION['idUsuario']
					));
					$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				} else {
					if ($nombreIMG != "") {
						$data["LGF0010009"] = $nombreIMG;
					}
					$respuesta = (new Usuarios())->actualizarUsuario((object) $data, (object) array (
						"LGF0010001" => $_SESSION['idUsuario']
					));*/
					/*echo "4<pre>";
					print_r($data);
					echo "</pre>";*/
					/*$this->renderJSON(array("mensaje" => "Información actualizada exitosamente."));
				}
			}*/
		/*}*/
	}

	/**
	 * Guarda la hora de salida del usuario de la leccion
	 */
	public function time() {
		if (isset($_SESSION['regLeccion'])) {
			$_checkLog = (new Administrador())->check_logregistros($_SESSION ["regLeccion"], 2);
			$data['LGF0360005'] = date("Y-m-d H:i:s");
    		$res = (new LogRegistros())->actualizarLogRegistros((object) $data, (object) array(
    			"LGF0360001" => $_SESSION['regLeccion']
    		));
    		unset($_SESSION['regLeccion']);
		}
	}

	public function obtenerLecciones() {
		switch ($_POST['accion']) {
			case '1':
				$nivel = $_POST['nivel'];
				if ($nivel != "") {
					$lecciones = (new Administrador())->mostrarLecciones($nivel);
					$level = (new Administrador())->obtenerLeccion($nivel);
					$data = array();
					$img = __DIR__."/../../portal/archivos/iconosLecciones/n".$level[0]['nivel']."/m".$nivel."/l";
					foreach ($lecciones as $key => $value) {
						$imagen = $img.$value['LGF0160007']."/".$value['LGF0160003'];
						if (file_get_contents($imagen)) {
							$imagen = ARCHIVO_FISICO."iconosLecciones/n".$level[0]['nivel']."/m".$nivel."/l".$value['LGF0160007']."/".$value['LGF0160003'];
						} else {
							$imagen = ARCHIVO_FISICO."iconosLecciones/icono_temporal.png";
						}
						$data[] = array(
							'cvl' => $value['LGF0160001'],
							'nombre' => $value['LGF0160002'],
							'img' => $imagen
						);
					}

					$this->renderJSON(array("data"=>$data));
				}
			break;
			case '2':
				$valor = $_POST['valor'];
				$check = (new Guias())->obtenGuia((object) array(
					"LGF0310001" => $valor, // ID Guia
				));
				if ($check[0]['LGF0310007'] == "") {
					$url = "";
				} else {
					$url = ARCHIVO_FISICO."guiasEstudio/n".$check[0]['LGF0310002']."/m".$check[0]['LGF0310003']."/l".$check[0]['LGF0310005']."/".$check[0]['LGF0310007'];
				}
				$data = array(
					"estatus" => (int) $check[0]['LGF0310006'],
					"url" => $url
				);
				$this->renderJSON(array("data"=>$data));
			break;
			case '3':
				$guias = (new Guias())->obtenGuia((object) array(
					"LGF0310001" => $valor, // ID Guia
				));
				
				$this->renderJSON(array("data"=>$data));
			break;
		}
	}

	public function obtenerGuias() {
		$nivel = $_POST['nivel'];
		$accion = $_POST['accion'];
		switch ($accion) {
			case '1': // Obtener guias
				$guias = (new Administrador())->obtenerGuias($nivel, 1);
				foreach ($guias as $key => $value) {
					if ($value['orden'] != 0) {
						$data[] = array(
							"cvl" => (int) $value['id'],
							"nombre" => $value['leccion'],
							"estatus" => (int) $value['estatus'],
							"orden" => (int) $value['orden']
						);
					}
				}
				$this->renderJSON(array("data"=>$data));
			break;
			case '2': // Activar/Desactivar guias
				$cadena = $_POST['cadena'];
				$aux = explode("|", $cadena);
				$valores = array();
				$activos = explode(",", $aux[1]);
				foreach ($activos as $key => $value) {
					array_push($valores, array(
						'id' => $value,
						'LGF0310006' => 1,
						'LGF0310009' => 1
					));
				}
				$inactivos = explode(",", $aux[2]);
				
				foreach ($inactivos as $key => $value) {
					array_push($valores, array(
						'id' => $value,
						'LGF0310006' => 0,
						'LGF0310009' => 1
					));
				}
				for ($i=0; $i < count($valores); $i++) { 
					$id = $valores[$i]['id'];
					$data = array(
						'LGF0310006' => $valores[$i]['LGF0310006'],
						'LGF0310009' => $valores[$i]['LGF0310009']
					);
					$ok = (new Guias())->actualizarGuia((object) $data, (object) array("LGF0310001" => $id));
				}
				$this->renderJSON(array("mensaje" => "Estado de guías actualizadas."));
			break;
		}
	}

	public function accesosLecciones() {
		$modulo = $_POST['nivel'];
		$docente = $_POST['docente'];
		$grupo = $_POST['grupo'];
		$lecciones = (new Administrador())->lecciones_docente_grupos($modulo, $grupo, $docente);

		$modulo = (new Modulo())->obtenModulo((object) array('LGF0150001'=>$modulo));
		$name = "Lecciones de ".$modulo[0]['LGF0150002'];

		$namegrupo = (new Grupos())->obtenGrupo((object) array('LGF0290001'=>$grupo));
		$nombregrupo = "Gestionar acceso a las lecciones del ".$namegrupo[0]['LGF0290002'];

		$datos = array();
		foreach ($lecciones as $key => $value) {
			if($value['LGF0160005'] == 1) {
				$activo = 0;
				if ($value['dato'] != "" || $value['dato'] != null) {
					$activo = 1;
				}
				$datos[] = array(
					'cvl' => (int) $value['LGF0160001'],
					'nombre' => "Lección ".$value['LGF0160007'].") ".$value['LGF0160002'],
					'activo' => $activo
				);
			}
		}

		$this->renderJSON(array("lecciones"=> $datos, "modulo"=>$name, "grupo"=>$nombregrupo));
	}

	public function saveAccesosL() {
		$modulo = $_POST['modulo'];
		$grupo = $_POST['grupo'];
		$docente = $_POST['docente'];
		$lecciones = $_POST['lecciones'];

		if ($lecciones != "") {
			$aux = explode(",", $lecciones);
			$data = (new Administrador())->obtener_accesos_grupos($docente, $grupo, $lecciones, $modulo, 1);
			
			$leccion_id = array();
			$leccion_id_old = array();
			$k=0;
			$cadena = "";
			for ($i=0; $i < count($aux); $i++) { 
				if ($aux[$i] != $data[$i]['LGF0370005']) {
					array_push($leccion_id, $aux[$i]);
				}
			}
			$data = (new Administrador())->obtener_accesos_grupos($docente, $grupo, $lecciones, $modulo, 2);
			for ($i=0; $i < count($data); $i++) { 
				if ($i == 0) {
					$cadena = $data[$i]['LGF0370001'];
				} else {
					$cadena.=",".$data[$i]['LGF0370001'];
				}
			}

			if (!empty($cadena)) {
				for ($i=0; $i < count($data); $i++) { 
					$oldData = array(
						'LGF0370001' => $data[$i]['LGF0370001']
					);
					$ok = (new AccesoLecciones())->eliminaAccesoLeccion((object) $oldData);
				}
			}

			if (!empty($leccion_id)) {
				for ($i=0; $i < count($leccion_id); $i++) { 
					$newData = array(
						'LGF0370002' => $docente,
						'LGF0370003' => $grupo,
						'LGF0370004' => $modulo,
						'LGF0370005' => $leccion_id[$i]
					);
					$check = (new AccesoLecciones())->obtenerAccesoLeccion((object) $newData);
					if (empty($check)) {
						$ok = (new AccesoLecciones())->agregarAccesoLeccion((object) $newData);
					}
				}
			}
			$this->renderJSON(array("mensaje"=>"Información actualizada"));
		} else {
			$data = (new Administrador())->obtener_accesos_grupos($docente, $grupo, $lecciones, $modulo);
			if (!empty($data)) {
				for ($i=0; $i < count($data); $i++) { 
					$oldData = array(
						'LGF0370001' => $data[$i]['LGF0370001']
					);
					$ok = (new AccesoLecciones())->eliminaAccesoLeccion((object) $oldData);
				}
			}
			$this->renderJSON(array("mensaje"=>"Información actualizada"));
		}
	}
}
?>