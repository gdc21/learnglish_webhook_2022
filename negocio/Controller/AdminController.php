<?php
	class AdminController extends Controller_Learnglish {
		public function __construct() {
			parent::__construct ();
			$class = get_class ( $this );
			$class = strtolower ( substr ( $class, 0, strrpos ( $class, "Controller", 0 ) ) );
			$this->temp ['path_home'] = CONTEXT . $class;

			// Acceso al menu del administrador para los perfiles 1,3,4,6
			/*if (! isset ( $_SESSION ["userLogged"] ) || ($_SESSION ["perfil"] != 1 && $_SESSION ["perfil"] != 6 && $_SESSION ["perfil"] != 3 && $_SESSION ["perfil"] != 4)) {
				$this->Redirect ();
			}*/

			if (!isset($_SESSION["userLogged"]) || !in_array($_SESSION ["perfil"],array(1,3,4))) {
				$this->Redirect ();
			}
			if (isset ( $_SESSION ["userLogged"] )) {
				$img_usuario = (new Usuarios ())->obtenUsuario ( ( object ) array (
						"LGF0010001" => $this->userid 
				) ) [0] ["LGF0010009"];
				// $this->temp ["img_usuario"] = (empty ( $img_usuario ) ? IMG . 'default.png' : $img_usuario);
				$ruta = IMG."perfil/".$img_usuario;
				// echo $ruta;
				if (!is_array(@getimagesize($ruta))) {
					$ruta = IMG."default.png";
				}
				$this->temp ["img_usuario"] = $ruta;
			}
			
			/*if ($_SESSION ["perfil"] == 6) {
				if (isset ( $_GET ["action"] )) {
					if (($_GET ["action"] == "index" || $_GET ["action"] == "objetos")) {
						return;
					} else {
						$this->Redirect ();
					}
				}
				return;
			}*/
		}
		public function index() {
			$this->render ();
		}


        public function cargarpreview(){
            $this->temp['encabezado'] = self::encabezado("Seleccione una lección para agregar preview");
            $this->temp['niveles'] = (new EstadisticasSistema())->obtenerNiveles();
            $this->render();
        }

        public function cargarinstruccionessecciones(){
            $this->temp['encabezado'] = self::encabezado("Seleccione un modulo, lección y sección para cargar instrucciones a una sección");
            $this->temp['niveles'] = (new EstadisticasSistema())->obtenerNiveles();
            $this->render();
        }

        public function cargarinstruccionesejercicios(){
            $this->temp['encabezado'] = self::encabezado("Seleccione un modulo para cargar instrucciones a una lección");
            $this->temp['modulos'] = (new Administrador())->obtener_modulos();
            $this->render();
        }

        public function guardarinstrucciones($tipo){
            if($tipo == 1){
                $this->renderJSON ( array (
                    'data' => "Hola como estas 1 bsbs1"
                ) );
            }elseif($tipo == 2){
                $this->renderJSON ( array (
                    'data' => "Hola como estas 2 bsbs1"
                ) );
            }else{
                $this->renderJSON ( array (
                    'data' => "Adios bsbs1"
                ) );
            }
        }


        ####################################################
        ########    SECCION DE FUNCIONES PARA ESTADISTICAS
        ####################################################
        /** Trae la relacion de ids de los modulos de una institucion TRAE-> [1,2,3,4,5,6,7]
         * @param $idInstitucion
         * @return array|false
         */
        public function obtenerIDSmodulosDeInstitucion($tipoElemento, $idInstitucion){
            return (new Administrador())->validarAccesos($tipoElemento, $idInstitucion);
        }


        /** Funcion que devuelve url e imagenes de los niveles contratados por una institucion
         * @param int $idInstitucion Id de institucion a verificar los niveles contratados
         * @return array Retorna array de enlaces de url e imagenes contratadas por una institucion
         */
        public function obtenerUrlsDeImagenesNivelesContratadosPorInstitucion($idInstitucion){
            #echo $idInstitucion;
            if($idInstitucion == 0){
                $validarAccesos = $this->obtenerIDSmodulosDeInstitucion('todosLosModulos', 0);
            }else {
                /**
                 * Trae la relacion de ids de los modulos de una institucion TRAE-> [1,2,3,4,5,6,7]
                 */
                $validarAccesos = $this->obtenerIDSmodulosDeInstitucion('institucion', $idInstitucion);
            }
            /**
             * Obtiene los niveles (pre, prim, sec) que contrato la institucion id TRAE-> [1,2,3]
             */
            $niveles = array();
            foreach ($validarAccesos as $key => $value) {
                /**
                 * Si el id de institucion es 0 significa que se obtendran todos
                 */

                $niveles[] = (new Administrador())->obtener_nivel_modulo($value['modulo']);
            }

            $datos = $this->super_unique($niveles);


            foreach ($datos as $key => $value) {
                if ($key == 0) {
                    $levelLeccion = $value[0]['nivel'];
                } else {
                    $levelLeccion.=",".$value[0]['nivel'];
                }
            }
            $genero = ['M', 'H'];

            $imagenes = (new HomeController) -> obtenerImagen(
                $levelLeccion,
                $genero[rand(0,1)],
                0);

            $data = [];
            foreach ($imagenes as $key => $imagen){
                if($key == 0){
                    $nivelActual = 'PreescolarInstitucion';
                }elseif($key == 1){
                    $nivelActual = 'PrimariaInstitucion';
                }else{
                    $nivelActual = 'SecundariaInstitucion';
                }

                #echo $nivelActual;
                if(!strripos($imagen, 'lock')){
                    $data[$key]['imagen'] = $imagen;
                    $data[$key]['url'] = CONTEXT.'admin/estadisticasSistema/'.$idInstitucion.'/'.$nivelActual;
                }else{
                    $data[$key]['imagen'] = $imagen;
                    $data[$key]['url'] = '#';
                }
            }

            #var_dump($data);
            return $data;
        }

        /**Definicion de ruta admin/estadisticasSistema
         *
         * @param int $id Id del elemento a visualizar en la base
         * @param string $tipo Tipo de seccion a generar estadistica
         * @return void  Redireccion a la ruta admin/estadisticasSistema/?/? con los parametros solicitados
         */

        public function estadisticassistema($id = 0, $tipo = ''){
            if (is_numeric($id) != 1) {
                $this->Redirect();
                exit();
            }

            /**
             * Funcion que muestra los modulos de una institucion predeterminada
             */
            if ($tipo == "alumnosDeGrupo" ) {
                $this->temp['elementos'] = (new EstadisticasSistema())->obtenerAlumnos($id, 'alumnosDelGrupo');

                #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('grupoEspecifico', $id);
                #$this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('grupoEspecifico', $id);

                $nombreGrupo = (new EstadisticasSistema())->obtenerGrupos($id, 'consultaNombre');
                $this->temp['encabezado'] = self::encabezado("Alumnos del grupo: " . $nombreGrupo[0]['nombre']);

                $this->temp['estudiantesDeDocente'] = (new EstadisticasSistema())->obtenerEstadisticasAlumnosDesdeGrupo($id);
                $this->temp['IDSestudiantesDeDocente'] = (new EstadisticasSistema())->obtenerIDSEstadisticasAlumnosDesdeGrupo($id);
                #var_dump($this->temp['IDSestudiantesDeDocente']);
                #echo "<hr>";
                $ids = [];
                foreach ($this->temp['IDSestudiantesDeDocente'] as $key => $idElementoASumar) {
                    foreach ($this->temp['estudiantesDeDocente'] as $elementosBuscarSumar) {
                        $ids[] = $idElementoASumar['id'];
                        if ($idElementoASumar['id'] == $elementosBuscarSumar['id']) {
                            $this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] += $elementosBuscarSumar['tiempo'];
                        }
                    }
                }
                $this->temp['vistaNombre'] = $tipo;

                if(count($this->temp['IDSestudiantesDeDocente']) > 0){
                    $this->temp['estadisticasPorAlumno'] = (new EstadisticasSistema()) -> obtenerEstadisticasPorAlumno(
                        array_column($this->temp['IDSestudiantesDeDocente'], 'id')
                    );
                }else{
                    $this->temp['estadisticasPorAlumno'] = [];
                }

                $this->temp['alumnosQueNoHanUsadoElSistema'] = (new EstadisticasSistema)->obtenerAlumnosNoHanUsadoElSistema($id, $ids);
                #var_dump(join(', ',array_column($this->temp['estadisticasPorAlumno'], 'id_usuario')));

                $this->render();

                exit();
            }

            if($id == 0){
                switch ($tipo) {
                    /**
                     * Estadisticas generales, dashboard principal
                     */
                    case 'general': #0
                        $mesActual = (new EstadisticasSistema)->obtenerMesDesdeNumero(date('m'));
                        $this->temp['encabezado'] = self::encabezado("Estadisticas de uso generales en sistema al mes de: " . $mesActual);

                        #
                        $this->temp['tiempoSemanaMinutos'] = (new EstadisticasSistema)->minutosEmpleandoSistema('semanaPorDia');
                        #
                        $this->temp['tiempoMesMinutos'] = (new EstadisticasSistema)->minutosEmpleandoSistema('mesPorDia');
                        $this->temp['tiempoMesMinutosSimple'] = (new EstadisticasSistema)->minutosEmpleandoSistema('mesSoloMinutos');

                        $this->temp['tiempoSemanaMinutosSimple'] = (new EstadisticasSistema)->minutosEmpleandoSistema('semanaSoloMinutos');

                        $this->temp['tiempoTotalGeneral'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalGeneral');

                        $this->temp['tiempoTotalPorNiveles'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorNiveles');
                        $this->temp['tiempoTotalPorModulos'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorModulos');

                        $this->temp['tiempoTotalPorDocentes'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorDocentes');
                        $this->temp['tiempoTotalPorAdmins'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorAdmins');
                        #var_dump($this->temp['tiempoMesMinutos']);
                        break;
                    /**
                     * Visualizacion de clientes
                     */
                    case 'clientes': #0
                        $this->temp['encabezado'] = self::encabezado("Listado general de clientes");

                        #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        #$this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerClientes();

                        break;
                    case 'instituciones': #0
                        $this->temp['encabezado'] = self::encabezado("Listado general de instituciones");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerInstituciones();
                        /**
                         * Si id es 0, significa que no hay una institucion especificada
                         */
                        $this->temp['id'] = 0;

                        break;
                    case 'niveles': #0
                        /*Enlaces de las imagenes*/
                        $this->temp['enlaces'] = $this->obtenerUrlsDeImagenesNivelesContratadosPorInstitucion(0);

                        $this->temp['encabezado'] = self::encabezado("Listado general de niveles");

                        #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        #$this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['tiempoTotalPorNiveles'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorNiveles');

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerNiveles();

                        break;
                    case 'PreescolarInstitucion': #0
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes que imparten clase en preescolar");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('nivelEspecifico', 1);
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('nivelEspecifico', 1);


                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerDocentes(1, 'nivelEspecifico');
                        $this->temp['elementos2'] = (new EstadisticasSistema())->obtenerGrupos(1, 'nivelEspecifico');

                        $this->temp['mostrarGrafico'] = false;

                        break;
                    case 'PrimariaInstitucion': #0
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes que imparten clase en primaria");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('nivelEspecifico', 2);
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('nivelEspecifico', 2);

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerDocentes(2, 'nivelEspecifico');
                        $this->temp['elementos2'] = (new EstadisticasSistema())->obtenerGrupos(2, 'nivelEspecifico');

                        $this->temp['mostrarGrafico'] = false;
                        #var_dump($this->temp['elementos'] );

                        break;
                    case 'SecundariaInstitucion': #0
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes que imparten clase en secundaria");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('nivelEspecifico', 3);
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('nivelEspecifico', 3);

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerDocentes(3, 'nivelEspecifico');
                        $this->temp['elementos2'] = (new EstadisticasSistema())->obtenerGrupos(3, 'nivelEspecifico');

                        $this->temp['mostrarGrafico'] = false;

                        break;
                    case 'modulos': #0
                        $this->temp['encabezado'] = self::encabezado("Listado general de modulos");

                        #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        #$this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['tiempoTotalPorModulos'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorModulos');


                        break;
                    case 'alumnos': #0
                        #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        #$this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['encabezado'] = self::encabezado("Listado de grupos, seleccione el grupo para mostrar estadisticas de alumnos");

                        $this->temp['vistaGruposParaVisualizarAlumnos'] = true;
                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerGrupos();
                        #var_dump($this->temp['elementos']);
                        break;
                    case 'docentes': #0
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes del sistema");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('docentesGeneral');
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('docentesGeneral');

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerDocentes();

                        break;
                    /**
                     * Redireccion en caso de no reconocer el tipo de ruta
                     */
                    default:
                        $this->Redirect();
                        exit();

                }


            }elseif(is_numeric($id)){

                switch ($tipo){

                    /**
                     * Designamos 3 posibles casos para mostrar estadistica segun el caso
                     * recibiendo como id el id de institucion
                     */
                    case 'PrimariaInstitucion': #id
                    case 'SecundariaInstitucion': #id
                    case 'PreescolarInstitucion': #id
                        $this->temp['encabezado'] = self::encabezado("Listado de niveles contratados por la institucion");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('institucionEspecifica', $id);
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('institucionEspecifica', $id);

                        $this->temp['tiempoTotalPorModulos'] = (new EstadisticasSistema)->minutosEmpleandoSistema($tipo, $id);
                        #var_dump($this->temp['tiempoTotalPorModulos']);

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerModulos();
                        $this->temp['mostrarGrafico'] = true;
                        break;

                    case 'clientes': #id
                        #$this->temp['tiemposEnGeneral'] = (new EstadisticasSistema()) -> obtenerMesAnioTiempoDeUsoSistema('clienteEspecifico', $id);
                        #$this->temp['meses'] = (new EstadisticasSistema()) -> obtenerMesesDelAnio();
                        #$this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema()) -> obtenerHorasTotalesUsoSistema('clienteEspecifico', $id);

                        $nombreCliente = (new EstadisticasSistema()) -> obtenerClientes($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Listado de instituciones del cliente: ".$nombreCliente[0]['nombre']);

                        $this->temp['elementos'] = (new EstadisticasSistema()) -> obtenerInstituciones($id);

                        break;
                    case 'instituciones': #id
                        $this->temp['enlaces'] = $this->obtenerUrlsDeImagenesNivelesContratadosPorInstitucion($id);

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema()) -> obtenerMesAnioTiempoDeUsoSistema('institucionEspecifica', $id);
                        $this->temp['meses'] = (new EstadisticasSistema()) -> obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema()) -> obtenerHorasTotalesUsoSistema('institucionEspecifica', $id);

                        $nombreInstitucion = (new EstadisticasSistema()) -> obtenerInstituciones($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Listado de niveles contratados de la institucion: ".$nombreInstitucion[0]['nombre']);
                        $this->temp['elementos'] = (new EstadisticasSistema()) -> obtenerGrupos($id);

                        /**
                         * Si hay id, significa que se selecciono una institucion especifica
                         */
                        $this->temp['id'] = $id;
                        break;
                    case 'modulos': #id
                        $this->temp['encabezado'] = self::encabezado("Listado de modulos contratados por la institucion");

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema();
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema();

                        $this->temp['hayIdInstitucion'] = true;
                        $this->temp['id'] = $id;

                        $idsModulosDeInstitucion = $this->obtenerIDSmodulosDeInstitucion('institucion', $id);
                        $ids = [];
                        foreach ($idsModulosDeInstitucion as $id){
                            $ids[] = $id[modulo];
                        }

                        $this->temp['tiempoTotalPorModulos'] = (new EstadisticasSistema)->minutosEmpleandoSistema('tiempoTotalPorModulosDeInstitucion', $ids);
                        break;
                    case "alumsDeInstiucionEspecifica": #id

                        $this->temp['elementos'] = (new EstadisticasSistema())->obtenerAlumnos($id, 'alumnosDeInstitucion');

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema())->obtenerMesAnioTiempoDeUsoSistema('institucionEspecifica', $id);
                        $this->temp['meses'] = (new EstadisticasSistema())->obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema())->obtenerHorasTotalesUsoSistema('institucionEspecifica', $id);

                        $nombreInstitucion = (new EstadisticasSistema())->obtenerInstituciones($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Alumnos de la institucion: " . $nombreInstitucion[0]['nombre']);

                        $this->temp['estudiantesDeDocente'] = (new EstadisticasSistema())->obtenerEstadisticasAlumnosDesdeInstitucion($id);
                        $this->temp['IDSestudiantesDeDocente'] = (new EstadisticasSistema())->obtenerIDSEstadisticasAlumnosDesdeInstitucion($id);

                        $ids = [];
                        foreach ($this->temp['IDSestudiantesDeDocente'] as $key => $idElementoASumar) {
                            foreach ($this->temp['estudiantesDeDocente'] as $elementosBuscarSumar) {
                                $ids[] = $idElementoASumar['id'];
                                if ($idElementoASumar['id'] == $elementosBuscarSumar['id']) {
                                    $this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] += $elementosBuscarSumar['tiempo'];
                                }
                            }
                        }

                        if(count($this->temp['IDSestudiantesDeDocente']) > 0){
                            $this->temp['estadisticasPorAlumno'] = (new EstadisticasSistema()) -> obtenerEstadisticasPorAlumno(
                                array_column($this->temp['IDSestudiantesDeDocente'], 'id')
                            );
                        }else{
                            $this->temp['estadisticasPorAlumno'] = [];
                        }

                        $this->temp['alumnosQueNoHanUsadoElSistema'] = (new EstadisticasSistema)->obtenerAlumnosNoHanUsadoElSistema($id, $ids, 'deInstitucion');
                        #var_dump($this->temp['estadisticasPorAlumno']);



                        break;
                    case 'grupos': #id #id
                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema()) -> obtenerMesAnioTiempoDeUsoSistema('grupoEspecifico', $id);
                        $this->temp['meses'] = (new EstadisticasSistema()) -> obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema()) -> obtenerHorasTotalesUsoSistema('grupoEspecifico', $id);

                        $nombreGrupo = (new EstadisticasSistema()) -> obtenerGrupos($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes del grupo: ".$nombreGrupo[0]['nombre']);
                        $this->temp['elementos'] = (new EstadisticasSistema()) -> obtenerDocentes($id);

                        #var_dump($this->temp['elementos']);
                        break;
                    case 'docentes': #id #id

                        $this->temp['elementos'] = (new EstadisticasSistema()) -> obtenerAlumnos($id, 'alumnosDelDocente');
                        #var_dump($this->temp['elementos']);

                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema()) -> obtenerMesAnioTiempoDeUsoSistema('docenteEspecifico', $id);
                        $this->temp['meses'] = (new EstadisticasSistema()) -> obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema()) -> obtenerHorasTotalesUsoSistema('docenteEspecifico', $id);

                        #$nombreGrupo = (new EstadisticasSistema()) -> obtenerGrupos($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Alumnos del docente");

                        $this->temp['estudiantesDeDocente'] = (new EstadisticasSistema()) -> obtenerEstadisticasAlumnosDesdeDocente($id);
                        $this->temp['IDSestudiantesDeDocente'] = (new EstadisticasSistema()) -> obtenerIDSEstadisticasAlumnosDesdeDocente($id);

                        $ids = [];
                        foreach ($this->temp['IDSestudiantesDeDocente'] as $key => $idElementoASumar){
                            foreach ($this->temp['estudiantesDeDocente'] as $elementosBuscarSumar){
                                $ids[] = $idElementoASumar['id'];
                                if($idElementoASumar['id'] == $elementosBuscarSumar['id']){
                                    $this->temp['IDSestudiantesDeDocente'][$key]['sumaTiempo'] += $elementosBuscarSumar['tiempo'];
                                }
                            }
                        }

                        if(count($this->temp['IDSestudiantesDeDocente']) > 0){
                            $this->temp['estadisticasPorAlumno'] = (new EstadisticasSistema()) -> obtenerEstadisticasPorAlumno(
                                array_column($this->temp['IDSestudiantesDeDocente'], 'id')
                            );
                        }else{
                            $this->temp['estadisticasPorAlumno'] = [];
                        }
                        #var_dump($this->temp['estudiantesDeDocente']);
                        $this->temp['alumnosQueNoHanUsadoElSistema'] = (new EstadisticasSistema)->obtenerAlumnosNoHanUsadoElSistema($id, $ids, 'ninguno');

                        break;
                    case 'docentesInstitucion': #id
                        $this->temp['tiemposEnGeneral'] = (new EstadisticasSistema()) -> obtenerMesAnioTiempoDeUsoSistema('grupoEspecifico', $id);
                        $this->temp['meses'] = (new EstadisticasSistema()) -> obtenerMesesDelAnio();
                        $this->temp['totalHorasUsoSistema'] = (new EstadisticasSistema()) -> obtenerHorasTotalesUsoSistema('grupoEspecifico', $id);

                        $nombreInstitucion = (new EstadisticasSistema()) -> obtenerInstituciones($id, 'consultaNombre');
                        $this->temp['encabezado'] = self::encabezado("Listado de docentes de la institucion: ".$nombreInstitucion[0]['nombre']);
                        $this->temp['elementos'] = (new EstadisticasSistema()) -> obtenerDocentes($id, 'docentesInstitucion');
                        //TODO crear segun la pagina
                        break;
                    default:
                        $this->Redirect ();
                        exit();
                }


            }else{
                $this->Redirect ();
            }
            /**
             * Variable que ayuda a la identificacion de las vistas en el lado del frontend
             */
            $this->temp['vistaNombre'] = $tipo;

            $this->render();
        }
        #####################################################################
        #####################################################################
        #####################################################################
		/**
		 * Nueva interfaz del administrador
		 */
		public function manager() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->render ();
		}
		
		public function objetos() {
			$this->render ();
		}
		
		public function usuario() {
			$this->render ();
		}
		
		public function evaluaciones() {
			$this->temp ['lista'] = (new Administrador ())->lista_evaluaciones ();
			$this->render ();
		}
		public function addEval() {
			$this->temp ['Version'] = (new CatalogoVersiones ())->obtenCatalogoVersiones ();
			$this->render ();
		}
		public function editEval($id) {
			$Eval = (new Evaluacion ())->obtenEvaluacion ( ( object ) array (
					"LGF0190001" => $id 
			) );
			$this->temp ['Eval'] = $Eval;
			$this->temp ['Modulos'] = $this->Get_Modulos ( $Eval [0] ["LGF0190005"] );
			$this->temp ['Lecciones'] = $this->Get_Lecciones ( $Eval [0] ["LGF0190006"] );
			$this->temp ['Version'] = (new CatalogoVersiones ())->obtenCatalogoVersiones ();
			$this->render ();
		}
		public function preguntas($id) {
			$this->temp ['lista'] = (new Administrador ())->lista_preguntas ( $id );
			$this->temp ['ID_eval'] = $id;
			$this->render ();
		}
		public function addQuest($id) {
			$this->temp ['id_EV'] = $id;
			$this->temp ['Cat'] = (new CatalogoTipoPregunta ())->obtenCatalogoTipoPregunta ();
			$this->render ();
		}
		public function editQuest($id) {
			$this->temp ['Preg'] = (new CatalogoPreguntasEval ())->obtenCatalogoPreguntasEval ( ( object ) array (
					"LGF0200001" => $id 
			) );
			$this->temp ['Resp'] = (new RespuestasEvaluacion ())->obtenRespuestasEvaluacion ( ( object ) array (
					"LGF0210002" => $id 
			) );
			$this->temp ['Cat'] = (new CatalogoTipoPregunta ())->obtenCatalogoTipoPregunta ();
			$this->temp ['id_P'] = $id;
			$this->render ();
		}
		
		// *******************************************************
		// Funcionalidad
		// *******************************************************
		public function Get_Modulos($modulo) {
			return (new Modulo ())->obtenModulo ( ( object ) array (
					"LGF0150004" => $modulo 
			) );
		}
		public function Get_Lecciones($lecciones) {
			return (new Leccion ())->obtenLeccion ( ( object ) array (
					"LGF0160004" => $lecciones 
			) );
		}

		/**
		 * Listado de instituciones
		 */
		public function instituciones() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['lista'] = (new Administrador())->lista_instituciones();
			$this->temp['clientes'] = (new Administrador())->lista_clientes();
			$this->render();
		}

		/**
		 * Formulario registro de instituciones
		 */
		public function addInstitucion() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->obtener_modulos();
			$this->temp['clientes'] = (new Administrador())->lista_clientes();
			$this->render();
		}

		public function editInstitucion($id) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->obtener_modulos();
			$this->temp['info'] = (new Administrador())->informacion_institucion($id);
			$this->temp['clientes'] = (new Administrador())->lista_clientes();
			$this->render();
		}

		/**
		 * Listado de usuarios
		 */
		public function usuarios() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['instituciones'] = (new Administrador())->lista_instituciones();
			$this->temp['grados'] = (new Administrador())->obtener_modulos();
			$this->temp['grados'] = (new Administrador())->obtener_modulos();
			if ($_SESSION['perfil'] == 6) {
				$this->temp['info'] = (new Administrador())->obtener_docentes($_SESSION['idUsuario']);
			}
			$this->render();
		}

		public function addUsuario() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['instituciones'] = (new Administrador())->lista_instituciones();
			$this->temp['grados'] = (new Administrador())->obtener_modulos();
			$this->temp['perfil'] = (new Administrador())->lista_perfiles();
			$this->render();
		}

		public function editUsuario($id) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['info'] = (new Administrador())->informacion_usuario($id);
			$this->temp['instituciones'] = (new Administrador())->lista_instituciones();
			$this->temp['perfil'] = (new Administrador())->lista_perfiles();
			$this->temp['grados'] = (new Administrador())->obtener_modulos();
			$this->render();
		}

		/**
		 * Clientes
		 */
		public function clientes() {
			$clientes = (new Administrador())->obtenClientes();
			$data = array();
			foreach ($clientes as $key => $cli) {
				array_push($data, array(
					"id" => $cli['LGF0280001'],
					"nombre" => $cli['LGF0280002'],
					"contacto" => $cli['LGF0280017'],
					"totalInst" => $cli['totalInst'],
					"fecha" => $cli['LGF0280011']
				));
			}
			$this->temp['lista'] = $data;
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->render();
		}

		public function details($cliente) {
			$infoCliente = (new Clientes())->obtenClientes(array('LGF0280001' => $cliente));
			$instituciones = (new Administrador())->institucion_cliente($cliente);
			$clientename = $infoCliente[0]['LGF0280002'];
			
			$data = array();
			foreach ($instituciones as $key => $value) {
				$alumnos = (new Administrador())->obtenerTotalAlumnos($value['LGF0270001']);
				array_push($data, array(
					'cliente' => $clientename,
					'CCT' => $value['LGF0270028'],
					'institucion' => $value['LGF0270002'],
					'totalAlumnos' => $alumnos[0]['total']
				));
			}
			$this->temp['lista'] = $data;
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->render();
		}

		public function addCliente() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->render();
		}

		public function editCliente($id) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['info'] = (new Administrador())->informacion_cliente($id);
			$this->render();
		}

		/**
		 * Grupos
		 */
		public function grupos($id) {
			$cicloEscolar = (new Administrador())->cliclo_escolar();
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['institucion_id'] = $id;
			$nombre = (new Administrador())->informacion_institucion($id);
			$this->temp['nombre_institucion'] = $nombre[0]['LGF0270002'];
			$this->temp['lista'] = (new Administrador())->obtener_grupos($id);
			$niveles = (new Administrador())->modulos();
			$this->temp['modulos'] = $niveles;
			$docentes = (new Administrador())->obtener_docentes("");
			foreach ($docentes as $docente) {
				// print_r($docente);
				$data[] = array(
					"clave" => $docente['clave'],
					"nombre" => $docente['LGF0010002']." ".$docente['LGF0010003']." ".$docente['LGF0010004']
				);
			}
			// print_r($data);
			$this->temp['cicloEscolar'] = $cicloEscolar;
			$this->temp['docentes'] = $data;
			$this->render();
		}

		/**
		 * Reportes
		 */
		public function reportes() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['instituciones'] = (new Administrador())->lista_instituciones();
			$this->temp['clientes'] = (new Administrador())->lista_clientes();
			$this->temp['leccion'] = (new Administrador())->obtenerMaxLecciones();
			if ($_SESSION['perfil'] == 6) {
				$this->temp['info'] = (new Administrador())->obtener_docentes($_SESSION['idUsuario']);
			}
			$this->render();
		}

		/**
		 * Objetos
		 */
		public function evaluacion() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->render();
		}

		public function addevaluacion() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->render();
		}

		public function editEvaluacion($evaluacion) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$informacion = (new Evaluacion())->obtenEvaluacion((object) array("LGF0190001" => $evaluacion));
			foreach ($informacion as $info) {
				$data = array(
					'evaluacion' => $info['LGF0190001'],
					'nombre' => $info['LGF0190002'],
					'modulo' => $info['LGF0190006'],
					'leccion' => $info['LGF0190007'],
					'preguntas' => $info['LGF0190011'],
					'estatus' => $info['LGF0190010'],
					'tipo' => $info['LGF0190004']
				);
			}
			$this->temp['info'] = $data;
			$this->render();
		}

		public function mostrarPreguntas($pregunta) {
			$info = (new Administrador())->preguntas_evaluacion($pregunta);
			$informacion = (new Administrador())->informacion_evaluacion($pregunta);
			$data = array(
				"nombre_evaluacion" => $info[0]['evaluacion'],
				"id_evaluacion" => $info[0]['evaluacion_id'],
				"total" => $info[0]['total'],
				"evaluados" => $informacion[0]['evaluados'],
				"aprobados" => empty($informacion[0]['aprobados']) ? 0 : $informacion[0]['aprobados'],
				"reprobados" => $informacion[0]['evaluados'] - $informacion[0]['aprobados']
			);

			foreach ($info as $preg) {
				if (!empty($preg['pregunta']) && !empty($preg['categoria']) && !empty($preg['tipo'])) {
					$data['preguntas'][] = array(
						'pregunta' => $preg['pregunta'],
						'categoria' => $preg['categoria'],
						'tipo' => $preg['tipo'],
						'pregunta_id' => $preg['pregunta_id'],
						'aciertos' => $preg['aciertos'],
						'errores' => $preg['errores']
					);
				}
			}
			/*echo "<pre>";
			print_r($data);
			echo "</pre>";*/
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['informacion'] = $data;
			$this->render();
		}

		public function editQuestion($pregunta_id) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['pregunta_id'] = $pregunta_id;
			$pregunta = (new Administrador())->obtener_pregunta($pregunta_id);
			$this->temp['pregunta'] = $pregunta[0];
			$this->temp['categorias'] = (new Administrador())->lista_categorias();
			$this->temp['respuestas'] = (new Administrador())->obtener_respuestas($pregunta_id);
			$this->render();
		}

		public function addQuestion($pregunta_id) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['pregunta_id'] = $pregunta_id;
			$info = (new Administrador())->preguntas_evaluacion($pregunta_id);
			
			$this->temp['nombre_evaluacion'] = $info[0]['evaluacion'];
			$this->temp['categorias'] = (new Administrador())->lista_categorias();
			$this->render();
		}

		public function objeto() {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->render();
		}

		public function addObjeto($modulo, $leccion) {
			if ($modulo == "a" && $leccion == "b") {
				$this->temp['modulo'] = "";
				$this->temp['leccion'] = "";
			} else if ($modulo != "a" && $leccion == "b") {
				$this->temp['modulo'] = $modulo;
				$this->temp['leccion'] = "";
			} else {
				$this->temp['modulo'] = $modulo;
				$this->temp['leccion'] = $leccion;
			}
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->temp['secciones'] = (new Administrador())->secciones();
			$this->render();
		}

		public function editObjeto($idobjeto) {
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->temp['secciones'] = (new Administrador())->secciones();

			$objeto = (new EstructuraNavegacion())->obtenEstructuraNavegacion((object) array("LGF0180001" => $idobjeto));
			foreach ($objeto as $obj) {
				$leccion = (new Administrador())->informacionLeccion($obj['LGF0180004']);
				$aux = explode(" ", $obj['LGF0180009']);
				$aux1 = explode("-", $aux[0]);
				$fecha = $aux1[2]."-".$aux1[1]."-".$aux1[0];

				if ($obj['LGF0180012'] != "") {
					$ruta_es = __DIR__."/../../portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/audio/".$obj['LGF0180012'];
					if (file_exists($ruta_es)) {
						$audio_es = CONTEXT."portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/audio/".$obj['LGF0180012'];
					} else {
						$audio_es = "";
					}
				} else {
					$audio_es = "";
				}

				if ($obj['LGF0180013'] != "") {
					$ruta_en = __DIR__."/../../portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/audio/".$obj['LGF0180013'];
					if (file_exists($ruta_en)) {
						$audio_en = CONTEXT."portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/audio/".$obj['LGF0180013'];
					} else {
						$audio_en = "";
					}
				} else {
					$audio_en = "";
				}

				if ($obj['LGF0180014'] != "") {
					$ruta_img = __DIR__."/../../portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/img/".$obj['LGF0180014'];
					if (file_exists($ruta_img)) {
						$img_instruccion = CONTEXT."portal/archivos/recursosLecciones/n".$obj['LGF0180002']."/m".$obj['LGF0180003']."/l".$leccion[0]['LGF0160007']."/img/".$obj['LGF0180014'];
					} else {
						$img_instruccion = "";
					}
				} else {
					$img_instruccion = "";
				}

				$leccion = (new Leccion())->obtenLeccion((object) array("LGF0160001" => $obj['LGF0180004']));
				$leccion = $leccion[0];
				$modulo = (new Modulo())->obtenModulo((object) array("LGF0150001" => $obj['LGF0180003']));
				$modulo = $modulo[0];
				$data[] = array(
					"objeto" => $obj['LGF0180001'],
					"modulo" => $modulo['LGF0150002'],
					"leccion" => $leccion['LGF0160002'],
					"seccion" => $obj['LGF0180005'],
					"estatus" => $obj['LGF0180008'],
					"texto_es" => $obj['LGF0180010'],
					"texto_en" => $obj['LGF0180011'],
					"audio_es" => $audio_es,
					"audio_en" => $audio_en,
					"img_instruccion" => $img_instruccion,
					"fecha" => $fecha
				);
			}

			$this->temp['objeto'] = $data[0];
			$this->render();
		}

		/**
		 * Nueva funcion de reportes
		 */

		public function reports($id) {
			$this->temp['leccion'] = (new Administrador())->obtenerMaxLecciones();
			$this->render();
		}

		public function groups() {
			/*$colores = (new Administrador())->informacion_nivel();
			$this->temp['preescolar'] = $colores[0]['color'];
			$this->temp['primaria'] = $colores[1]['color'];
			$this->temp['secundaria'] = $colores[2]['color'];*/
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			/*$this->temp['seccion_nombre'] = "Grupos Registrados";*/
			/*$this->temp['docente'] = $_SESSION['idUsuario'];*/

            $this->temp['instituciones'] = (new Administrador())->lista_instituciones();

			$this->render();
		}

		public function addGroup() {
			$cicloEscolar = (new Administrador())->cliclo_escolar();
			$niveles = (new Administrador())->modulos();
			$docentes = (new Administrador())->obtener_docentes("");
			$instituciones = (new Administrador())->lista_instituciones();
			$institucion = array();
			foreach ($instituciones as $key => $value) {
				if ($value['LGF0270012'] == 1) {
					array_push($institucion, $value);
				}
			}
			foreach ($docentes as $docente) {
				// print_r($docente);
				$data[] = array(
					"clave" => $docente['clave'],
					"nombre" => $docente['LGF0010002']." ".$docente['LGF0010003']." ".$docente['LGF0010004']
				);
			}
			$this->temp['cicloEscolar'] = $cicloEscolar;
			$this->temp['niveles'] = $niveles;
			$this->temp['instituciones'] = $institucion;
			$this->temp['docentes'] = $data;
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['seccion_nombre'] = "Registrar Grupo";
			// echo $this->encabezado("Módulo del Administrador Learnglish");
			$this->render();
		}

		public function editGroup($id) {
			$cicloEscolar = (new Administrador())->cliclo_escolar();
			$niveles = (new Administrador())->modulos();
			$docentes = (new Administrador())->obtener_docentes("");
			$instituciones = (new Administrador())->lista_instituciones();
			$institucion = array();
			foreach ($instituciones as $key => $value) {
				if ($value['LGF0270012'] == 1) {
					array_push($institucion, $value);
				}
			}
			$grupo = (new Administrador())->grupos($id);
			foreach ($docentes as $docente) {
				// print_r($docente);
				$data[] = array(
					"clave" => $docente['clave'],
					"nombre" => $docente['LGF0010002']." ".$docente['LGF0010003']." ".$docente['LGF0010004']
				);
			}
			$this->temp['cicloEscolar'] = $cicloEscolar;
			$this->temp['grupo'] = $grupo;
			$this->temp['niveles'] = $niveles;
			$this->temp['instituciones'] = $institucion;
			$this->temp['docentes'] = $data;
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['seccion_nombre'] = "Editar Grupo";
			$this->render();
		}

		/**
		 * Interfaz de docentes
		 */

		public function teachers() {
			$docentes = (new Administrador())->docentes();
			/*echo "<pre>";
			print_r($docentes);
			echo "</pre>";*/
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
						} else {
							$gruposid.= ",".$docent['grupoid'];
							$grupos.= ",".$docent['gruponame'];
							$alumnos.= ",".$docent['alumnos'];
							$nivel.= ",".$docent['nivel'];
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
				);
			}
			
			$this->temp['docentes'] = (new Administrador())->lista_instituciones();
			$this->temp['modulos'] = (new Administrador())->modulos();
			$colores = (new Administrador())->informacion_nivel();
			$this->temp['preescolar'] = $colores[0]['color'];
			$this->temp['primaria'] = $colores[1]['color'];
			$this->temp['secundaria'] = $colores[2]['color'];
			$this->temp['data'] = $newData;
			$this->temp['encabezado'] = self::encabezado("Módulo de Administrador Learnglish");
			$this->temp['seccion_nombre'] = "Docentes Registrados";
			$this->render();
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
				<!-- <div class="nameUser col-lg-4 hide"> -->
				<div class="col-lg-2 col-md-2 col-sm-2">
					<div id="perfil_usuario"><img src="'.$this->temp['img_usuario'].'" class="imagen"><span class="nombreAvatar">'.$_SESSION['nombre'].'</span></div>
				</div>
			</div>
			<br>';
			return $encabezado;
		}

		public function lessons() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->modulos();
			$this->render();
		}

		public function timereport() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['instituciones'] = (new Administrador())->lista_instituciones();
			$this->render();
		}

		public function subir() {
			$this->render();
		}

		/**
		 * Vista administrable de guías de estudio
		 */
		public function guides() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->obtener_modulos();
			$this->render();
		}

		/**	
		* Vista administrable de los recursos digitales
		*/
		public function means() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['modulos'] = (new Administrador())->obtener_modulos();
			$this->render();
		}

		public function importar() {
			$this->temp['encabezado'] = self::encabezado("Módulo del Administrador Learnglish");
			$this->temp['seccion_nombre'] = "Importar datos";
			$this->render();
		}
	}
?>