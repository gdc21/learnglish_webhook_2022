<?php
	class EvaluaciontrimestralController extends Controller_Learnglish {

		private $trimestre;
		public $oda = "";
		private $intentosPermitidos = 2;

		public function __construct() {
			parent::__construct ();

			$datos = (new Accesomodulos())->obtenAccesomodulos((object)array(
				"LGF0430002" => "ExamenTrimestral"
			));
			$trimestre_db = explode(',', $datos[0]['LGF0430008']);
			$this->trimestre = $trimestre_db[1];

			if (isset ( $_SESSION ["userLogged"] )) {
				if ($_SESSION ["tipoSesion"] != 2) {
					$img_usuario = (new Usuarios ())->obtenUsuario ( ( object ) array (
							"LGF0010001" => $this->userid
					) ) [0] ["LGF0010009"];
					$ruta = IMG."perfil/".$img_usuario;
					if (!is_array(@getimagesize($ruta))) {
						$ruta = IMG."default.png";
					}
					$this->temp ["img_usuario"] = $ruta;
				}
			}
		}


		public function webhookGit(){
			if (isset($_POST)) {
				$filename = __DIR__."/../../reportes_git_webhook/reportes_git_webhook.txt";
				if (is_writable($filename)) {
					if (!$fp = fopen($filename, 'a')) {
						echo "No se puede abrir en el archivo ($filename)";
						exit;
					}
					$json = file_get_contents('php://input');

					$data = json_decode($json, true, 10);
					$old_dir = __DIR__;
					fwrite($fp, "###############################################################################################". "\n");
					fwrite($fp, "############################# Cambios de Git el: ".date('d-m-y h:i:s')."#############################". "\n");
					foreach ($data as $key => $value) {
						if($key == "commits"){
							chdir ('/var/www/html/learnglishk10');
							exec("git checkout main");
							exec("git reset --hard");
							exec("git rebase --skip");
							exec("git pull --force");
							foreach ($value as $key2 => $value2){
								fwrite($fp, "########### Detalles commit ###########". "\n");
								fwrite($fp, json_encode($value2['message']). "\n");
								fwrite($fp, json_encode($value2['timestamp']). "\n");
								fwrite($fp, json_encode($value2['author']['name']. " - ".$value2['author']['username']). "\n");
								fwrite($fp, "########### Added ###########". "\n");
								fwrite($fp, json_encode($value2['added']). "\n");
								fwrite($fp, "########### Removed ###########". "\n");
								fwrite($fp, json_encode($value2['removed']). "\n");
								fwrite($fp, "########### Modified ###########". "\n");
								fwrite($fp, json_encode($value2['modified']). "\n");
							}
						}
					}
					fwrite($fp, "###############################################################################################". "\n");
					chdir($old_dir);
					echo "Listo, todo agregado al archivo ($filename)"; /*Cerramos la lectura y se libera memora buffer de lectura-escritura*/
					fclose($fp);
					exit;
				} else {
					echo "El archivo $filename no tiene permisos de escritura";
					exit;
				}
			}
		}

		public function mostrarevaluacionresumenalumno($id_resultado){

			if($id_resultado == "aunNo"){
				$_SESSION['mensajeUsuario'] = "Aún no haz hecho tu examen, en esta sección puedes realizarlo, mucha suerte.";
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}

			$datosEvaluacion = (new Usuarios())->obtenerDatosEvaluacion($id_resultado);

			$leccionesEscogidas = explode(',', $datosEvaluacion[0]['LGF0420003']);
			$respuestas = json_decode($datosEvaluacion[0]['LGF0420005']);

			$_SESSION['nombreAlumnoQueRealizaEvaluacion'] = $datosEvaluacion[0]['nombre'];
			$_SESSION['institucionAlumno'] = $datosEvaluacion[0]['institucion'];

			$resultadoProcesamiento = $this->procesarEvaluacion(
				$leccionesEscogidas,
				$respuestas
			);
			###############################################################################
			$_SESSION['respuestasComprobar'] = $resultadoProcesamiento['comprobacionRespuestas'];
			$_SESSION['preguntasFinales'] = $resultadoProcesamiento['preguntasFinales'];
			$_SESSION['respuestasExamen'] = $resultadoProcesamiento['respuestasComprobar'];

			$resultados = array(
				'id_usuario'    => $_SESSION['alumnoQueRealizaEvaluacion'],
				'lecciones'     => join(',', $_SESSION['leccionesEscogidas']),
				'calificacion'  => number_format( (10 * $resultadoProcesamiento['preguntasAcertadas']) / $resultadoProcesamiento['totalPreguntas']),
				'resumen'       => json_encode($resultadoProcesamiento['respuestas']),
				'acertadas'     => $resultadoProcesamiento['preguntasAcertadas'],
				'trimestre'     => $this->trimestre,
				'totalPreguntas'=> $resultadoProcesamiento['totalPreguntas'],
				'intentos'      => 1
			);

			$_SESSION['resultados'] = $resultados;

			$this->Redirect ('evaluaciontrimestral', 'guardarevaluaciontrimestralalumno2');
		}

		public function mostraravancesgenerales(){
			if(!verificaModuloSistemaActivo('AvancesExamenesTrimestrales')){
				return $this->Redirect();
			}

			$this->temp['hombres'] = 0;
			$this->temp['mujeres'] = 0;

			$this->temp['estadisticas']     = (new Usuarios ())->obtenerEstadisticasEvaluacionesTrimestrales($this->trimestre);
			$this->temp['alumnosPorInstitucion'] = (new Usuarios ())->obtenerEstadisticasAlumnosInstitucion($this->trimestre);
			#var_dump($this->temp['alumnosPorInstitucion']);

			foreach ($this->temp['estadisticas'] as $key => $estadistica){

				if($estadistica['genero'] == 'H'){
					$this->temp['hombres'] += 1;
				}else{
					$this->temp['mujeres'] += 1;
				}
				#Modificacion de fechas a un formato mas legible

				$fechaDB = strtotime( $estadistica['LGF0420007'] );
				$fecha = date( 'd-m-Y h:i A', $fechaDB );
				$this->temp['estadisticas'][$key]['fecha'] = $fecha;

				$lecciones = explode(',', $estadistica['LGF0420003']);
				$nombreLecciones = [];
				foreach ($lecciones as $leccion){
					$nombreLeccion = (new Usuarios ())->obtenerNombreLeccion($leccion);
					$nombreLecciones[] = $nombreLeccion[0]['LGF0160002'];
				}
				$this->temp['estadisticas'][$key]['nombreLecciones'] = join('<br> * ', $nombreLecciones);
			}
			#var_dump($this->temp['estadisticas']);
			$this->render();
		}

		public function guardarevaluaciontrimestralalumno2(){
			if(!verificaModuloSistemaActivo('ExamenTrimestral')){
				return $this->Redirect();
			}

			if(
				!isset($_SESSION['respuestasExamen']) &&
				!isset($_SESSION['respuestasComprobar']) &&
				!isset($_SESSION['preguntasFinales']) &&
				!isset($_SESSION['resultados'])
			){
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}

			$datos = (new Accesomodulos())->obtenAccesomodulos((object)array(
				"LGF0430002" => "ExamenTrimestral"
			));
			$lapso = explode(',', $datos[0]['LGF0430008']);

			$this->temp['encabezado'] = self::encabezado("Resultados de evaluación trimestral <br>$lapso[0]");
			$this->temp['respuestasExamen'] = $_SESSION['respuestasExamen'];
			#$this->temp['respuestasComprobar'] = $_SESSION['respuestasComprobar'];
			$this->temp['preguntasFinales'] = $_SESSION['preguntasFinales'];
			$this->temp['resultados'] = $_SESSION['resultados'];
			$this->temp['nombreAlumnoQueRealizaEvaluacion'] = $_SESSION['nombreAlumnoQueRealizaEvaluacion'];
			$this->temp['institucionAlumno'] = $_SESSION['institucionAlumno'];

			$this->render();
		}

		public function guardarevaluaciontrimestralalumno(){


			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}
			if(!isset($_SESSION['alumnoQueRealizaEvaluacion'])){
				$this->Redirect ('home', 'evaluacionlistarlecciones');
			}
			###############################################################################

			$resultadoProcesamiento = $this->procesarEvaluacion(
				$_SESSION['leccionesEscogidas'],
				$_POST['respuestas']
			);
			#return array(
			#	'preguntasAcertadas' 	=> $preguntasAcertadas,
			#	'totalPreguntas' 	    => $totalPreguntas,
			#	'respuestas' 	        => $respuestas,
			#	'comprobacionRespuestas'=> $comprobacionRespuestas,
			#	'preguntasFinales' 	    => $preguntasFinales,
			#	'respuestasComprobar' 	=> $respuestasComprobar,
			#);
			###############################################################################
			$_SESSION['respuestasComprobar'] = $resultadoProcesamiento['comprobacionRespuestas'];
			$_SESSION['preguntasFinales'] = $resultadoProcesamiento['preguntasFinales'];
			$_SESSION['respuestasExamen'] = $resultadoProcesamiento['respuestasComprobar'];

			$resultados = array(
				'id_usuario'    => $_SESSION['alumnoQueRealizaEvaluacion'],
				'lecciones'     => join(',', $_SESSION['leccionesEscogidas']),
				'calificacion'  => number_format( (10 * $resultadoProcesamiento['preguntasAcertadas']) / $resultadoProcesamiento['totalPreguntas']),
				'resumen'       => json_encode($resultadoProcesamiento['respuestas']),
				'acertadas'     => $resultadoProcesamiento['preguntasAcertadas'],
				'trimestre'     => $this->trimestre,
				'totalPreguntas'=> $resultadoProcesamiento['totalPreguntas'],
				'intentos'      => 1
			);

			$_SESSION['resultados'] = $resultados;

			(new Administrador())->guardarEvaluacionTrimestral($data = $resultados);

			$this->Redirect ('evaluaciontrimestral', 'guardarevaluaciontrimestralalumno2');
		}

		/**
		 * @param array $leccionesEscogidas Array de lecciones que se seleccioaron
		 * @param array $respuestas Array de respuestas en formato "31___3" Pregunta___respuesta seleccionada
		 * @return array Datos procesados
		 */
		public function procesarEvaluacion($leccionesEscogidasAlumno, $respuestasEvaluacion){

			$respuestas = [];
			#Conjunto de Ids de respuestas
			$respuestasComprobar = [];
			foreach ($respuestasEvaluacion as $respuesta){
				$respuestas[] = $respuesta;
				$item = explode('___', $respuesta);
				$respuestasComprobar[] = $item[1];
			}
			$totalPreguntas = count($respuestas);
			###############################################################
			# $totalPreguntas
			# $respuestasComprobar
			# $respuestas
			###############################################################

			$comprobacionRespuestas = (new Administrador())->obtenerRespuestas(join(',',$respuestasComprobar));
			$preguntasAcertadas = 0;

			foreach ($comprobacionRespuestas as $respuesta){
				if($respuesta['LGF0210005'] == "V"){
					$preguntasAcertadas += 1;
				}
			}
			###############################################################
			# $preguntasAcertadas
			###############################################################


			$preguntasFinales = $this->armarEvaluacionPreguntasRespuestas(
				$leccionesEscogidasAlumno
			);
			###############################################################
			# $preguntasFinales
			###############################################################

			return array(
				'preguntasAcertadas' 	=> $preguntasAcertadas,
				'totalPreguntas' 	    => $totalPreguntas,
				'respuestas' 	        => $respuestas,
				'comprobacionRespuestas'=> $comprobacionRespuestas,
				'preguntasFinales' 	    => $preguntasFinales,
				'respuestasComprobar' 	=> $respuestasComprobar,
			);
		}

		/** Seccion armado de preguntas con respuestas para mostrar
		 * @return array
		 */
		public function armarEvaluacionPreguntasRespuestas($leccionesEscogidasAlumno){

			$preguntasFinales = [];
			foreach($leccionesEscogidasAlumno as $leccion){
				$preguntas = (new Usuarios())->obtener10preguntasDeLeccion($leccion);
				$respuestas = (new Usuarios())->obtenerRespuestasPregunta(array_column($preguntas, 'id'));

				foreach ($preguntas as $pregunta) {
					$respuestasPregunta = [];
					foreach ($respuestas as $respuesta){
						if($respuesta['LGF0210002'] == $pregunta['id']){
							$respuestasPregunta[] = $respuesta;
						}
					}
					shuffle($respuestasPregunta);
					$pregunta['respuestas'] = $respuestasPregunta;
					$preguntasFinales[] = $pregunta;
				}
			}

			return $preguntasFinales;
		}

		public function evaluacionlistarlecciones(){
			if(!verificaModuloSistemaActivo('ExamenTrimestral')){
				return $this->Redirect();
			}

			$datos = (new Accesomodulos())->obtenAccesomodulos((object)array(
				"LGF0430002" => "ExamenTrimestral"
			));
			$lapso = explode(',', $datos[0]['LGF0430008']);

			$this->temp['encabezado'] = self::encabezado("Evaluación trimestral <br>$lapso[0]");

			if(isset($_SESSION['statusNoPreguntas'])){
				$this->temp['mensajeUsuario'] = $_SESSION['statusNoPreguntas'];
				unset($_SESSION['statusNoPreguntas']);
			}


			$this->render();
		}

		public function evaluacionseleccionarleccionesalumno(){
			if(!verificaModuloSistemaActivo('ExamenTrimestral')){
				return $this->Redirect();
			}

			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}
			if(!isset($_SESSION['alumnoQueRealizaEvaluacion'])){
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}

			$intentos  = (new Administrador())->verificarNumeroDeIntentos($_SESSION['alumnoQueRealizaEvaluacion'], $this->trimestre);
			if($intentos[0]['LGF0420009'] > $this->intentosPermitidos){
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}
			$this->temp['encabezado'] = self::encabezado("Good luck in your exam");

			$leccionesEscogidasAlumno = $_POST['lecciones'];



			$evaluacionArmada = $this->armarEvaluacionPreguntasRespuestas($_POST['lecciones']);
			###############################################################
			# $preguntasFinales
			###############################################################


			$this->temp['preguntasFinales'] = $evaluacionArmada;

			if(count($this->temp['preguntasFinales']) < 5){
				$_SESSION['statusNoPreguntas'] = "Preguntas insuficientes para crear tu exámen, selecciona otras lecciones por favor.";
				$this->Redirect ('evaluaciontrimestral', 'evaluacionlistarlecciones');
			}
			$_SESSION['leccionesEscogidas'] = $leccionesEscogidasAlumno;
			shuffle($this->temp['preguntasFinales']);
			$this->render();
		}

		public function encabezado($titulo) {
			$encabezado = '<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<img src="'.IMG.'logo_color.png" alt="learnglish icon" class="mx-auto my-2" id="icon_img">
				</div>
				<div class="col-lg-7 col-md-7 col-sm-7">
					<div class="relleno">
						<span>'.$titulo.'</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2">
					<div id="perfil_usuario"><img src="'.CONTEXT."portal/IMG/default.png".'" class="imagen"><span class="nombreAvatar">'.$_SESSION['nombre'].'</span></div>
				</div>
			</div>
			<br>';
			return $encabezado;
		}
	}
?>
