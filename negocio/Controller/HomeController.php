<?php

class HomeController extends Controller_Learnglish
{
    public $oda = "";
    const MAXIMO_INTENTOS_EVALUACION_LECCION = 3;

    public function __construct()
    {
        parent::__construct();
        if (isset($_SESSION["userLogged"])) {
            if ($_SESSION["tipoSesion"] != 2) {
                $img_usuario = (new Usuarios())->obtenUsuario((object) array(
                    "LGF0010001" => $this->userid
                ))[0]["LGF0010009"];

                $ruta = IMG . "perfil/" . $img_usuario;

                if (!is_file(__DIR__ . '/../../portal/IMG/perfil/' . $img_usuario)) {
                    $ruta = IMG . "default.png";
                }
                $this->temp["img_usuario"] = $ruta;
            }
        }
    }

    /**########################################################################################
     * PRIMARY*/
    public function avancetrimestral()
    {
        $this->temp['encabezado'] = self::encabezado("Avance trimestral del alumno");
        $this->temp['cantidadPlumas'] = (new Administrador())->obtenerResumenAvancesLecciones($this->userid);
        $this->render();
    }
    /**########################################################################################*/

    public function listarlistening()
    {
        $datos = (new Administrador())->navegacioncompleta();
        $i = 1;
        foreach ($datos as $dato) {
            echo $dato['LGF0180001'] . '  \\\JMORENO\folder_oda_jon\n' . $dato['LGF0180002'] . '\m' . $dato['LGF0180003'] . '\l' . $dato['LGF0180006'] . '\\' . $dato['LGF0180007'] . '<br>';
            $i++;
        }
    }


    /**########################################################################################*/
    public function moveblobtospeakingfolder()
    {
        $nombreArchivo = $_POST['archivo'];
        $leccion = $_POST['leccion'];

        $directorioBlobs = "portal/archivos/archivosCargadosPorEstudiantes/blobTemporalAudios/";
        if ($directorio = opendir($directorioBlobs)) {
            while (false !== ($archivo = readdir($directorio))) {

                if ($archivo == $nombreArchivo) {
                    $rutaActualBlob = $directorioBlobs . $nombreArchivo;

                    $rutaMoverSpeaking = "portal/archivos/archivosCargadosPorEstudiantes/speaking/" . $nombreArchivo;

                    $documento = (new EvaluacionDocumentos())->agregarDocumentosYspeakCargado((object)array(
                        "LGF0440002" => $this->userid,
                        "LGF0440003" => $leccion,
                        "LGF0440004" => $nombreArchivo,
                        "LGF0440005" => 'speaking',
                        "LGF0440009" => 1
                    ));
                    $movidaDeFicheros = rename($rutaActualBlob, $rutaMoverSpeaking);

                    if ($documento) {
                        echo 1;
                    } else {
                        unlink($rutaMoverSpeaking);

                        echo 0;
                    }
                }
            }
            closedir($directorio);
        }
    }

    public function subiraudiosblobpreload()
    {
        $archivo = $_FILES['fileAjax']['name'];
        $leccion = $_POST['leccion'];

        #TODO poner fecha al inicio
        #Leccion usuario id
        $fecha = date("m.d.Y-h_i_s");
        $nombreFinalArchivo = $fecha . ".u_" . $this->userid . ".speaking.l_" . $leccion . "." . $archivo . ".mp3";
        $target_path = "portal/archivos/archivosCargadosPorEstudiantes/blobTemporalAudios/" . $nombreFinalArchivo;

        if (move_uploaded_file($_FILES['fileAjax']['tmp_name'], $target_path)) {
            $object = array(
                'res' => "si",
                'rutaAudio' => CONTEXT . $target_path,
                'nombreArchivo' => $nombreFinalArchivo,
            );
            $this->renderJSON($object);
        } else {
            $object = array(
                'res' => "no"
            );
            $this->renderJSON($object);
        }
    }

    public function borrar_archivo_directorio($archivo)
    {
        if (!is_dir($archivo) && file_exists($archivo)) {
            unlink($archivo);
        }
    }

    public function subirinstruccionesseccionesdelecciones()
    {

        $target_path = $_POST['ruta_elemento'];
        $id_estruc_navegacion = $_POST['id_estruc_navegacion'];
        $nombre_seccion = $_POST['nombre_seccion'];

        $target_path = explode('_', $target_path);
        $formatos_permitidos = array();
        $campoBDinsertar = '';

        $tipoArchivoPermitido = $_POST['tipo_elemento'];

        /*********************************************/
        $orden = (isset($target_path[3]) ? $target_path[3] : 1);
        // $target_path[0] -> Nivel
        // $target_path[1] -> Modulo
        // $target_path[2] -> Leccion
        $nav = (new Administrador())->navegacion($target_path[0], $target_path[1], $target_path[2]);
        $current = $this->buscar($nav, $orden);
        /**
         * ID_nivel 0
         * ID_modulo 1
         * numero_leccion 2
         * directorio 3
         */
        $target_path = "portal/archivos/recursosLecciones/n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/";
        if ($tipoArchivoPermitido == "imagen_instrucciones") {
            $formatos_permitidos = array('png', 'jpg', 'jpeg');
            $campoBDinsertar = "LGF0180014";
            $target_path .= "img/";
        } elseif ($tipoArchivoPermitido == "audio_instrucciones_es" || $tipoArchivoPermitido == "audio_instrucciones_en") {
            $formatos_permitidos = array('mp3', 'wav', 'ogg', 'aac', 'wma');
            $target_path .= "mp3/";
            if ($tipoArchivoPermitido == "audio_instrucciones_es") {
                $campoBDinsertar = "LGF0180012";
            } elseif ($tipoArchivoPermitido == "audio_instrucciones_en") {
                $campoBDinsertar = "LGF0180013";
            }
        }

        $archivo = $_FILES['fileAjax']['name'];
        $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        if (!in_array($extension, $formatos_permitidos)) {
            /*No es la extension correcta y se descarta todo*/
            return 2;
        } else {
            $fecha = date("m.d.y-h_i_s");

            /*#################*/
            $carpeta_buscar_olds_borrar = $target_path;
            /*#################*/

            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }

            $nombreFinalArchivo = $nombre_seccion . "_id_" . $id_estruc_navegacion . "_" . $fecha . "_" . $tipoArchivoPermitido . "_" . substr(basename($_FILES['fileAjax']['name']), 0, 500);

            $target_path = $target_path . $nombreFinalArchivo;

            /*Si los archivos se mueven correctamente al directorio indicado*/
            if (move_uploaded_file($_FILES['fileAjax']['tmp_name'], $target_path)) {
                /*##########################################*/
                /* Procesar archivo */
                /*##########################################*/
                $buscarRegistro = array(
                    #nivel
                    "LGF0180002" => $current["ID_nivel"],
                    #modulo
                    "LGF0180003" => $current["ID_modulo"],
                    #leccion
                    "LGF0180004" => $current["ID_leccion"],
                    #seccion
                    "LGF0180005" => $current["ID_seccion"],
                    #orden
                    "LGF0180006" => $orden
                );
                $registro_anterior = (new EstructuraNavegacion())->obtenEstructuraNavegacion(
                    (object)
                    $buscarRegistro
                );

                if ($registro_anterior) {
                    $this->borrar_archivo_directorio(
                        __DIR__ . "/../../" .
                            $carpeta_buscar_olds_borrar .
                            $registro_anterior[0][$campoBDinsertar]
                    );
                }
                /*$this->renderJSON($registro_anterior);
					exit;*/

                $actualizar_registro = (new EstructuraNavegacion())->actualizarEstructuraNavegacion(
                    #Nuevo valor
                    (object)array(
                        $campoBDinsertar => $nombreFinalArchivo
                    ),
                    #Condicion where
                    (object)$buscarRegistro
                );

                if ($actualizar_registro) {
                    /*Se subio correctamente el archivo*/
                    echo 1;
                } else {
                    /*NO se subio correctamente el documento y se borra el archivo cargado a la carpeta*/
                    #unlink($target_path);
                    echo 0;
                }
            } /*Si los archivos NOOO se mueven correctamente al directorio indicado*/ else {
                /*NO se movio correctamente el documento a la carpeta destino CHECAR PERMISOS EN SERVIDOR*/
                echo 0;
            }
        }
    }

    /**
     * @return integer
     */
    public function subiraudios()
    {
        echo $this->guardarDocumentos("speaking", "audio");
    }

    /**
     * @return integer
     */
    public function subiradocumentos()
    {
        echo $this->guardarDocumentos("documento", "documentoWord");
    }

    /** Procesa un archivo segun el tipo de elemento a guardar y lo almacena
     * @param string $tipoElemento
     * @param string $tipoArchivoPermitido
     * @return void
     */
    public function guardarDocumentos($tipoElemento, $tipoArchivoPermitido, $target_path = '')
    {

        if ($tipoArchivoPermitido == "audio") {
            $formatos_permitidos = array('mp3', 'wav', 'ogg', 'aac', 'wma');
            $target_path = "portal/archivos/archivosCargadosPorEstudiantes/speaking/";
        } elseif ($tipoArchivoPermitido == "documentoWord") {
            $formatos_permitidos = array('docx', 'doc', 'dot');
            $target_path = "portal/archivos/archivosCargadosPorEstudiantes/documentos/";
        }

        $archivo = $_FILES['fileAjax']['name'];
        $extension = pathinfo($archivo, PATHINFO_EXTENSION);
        if (!in_array($extension, $formatos_permitidos)) {
            /*No es la extension correcta y se descarta todo*/
            return 2;
        } else {
            #$aleatorio = $this->generarTextoAleatorio(5);
            $fecha = date("m.d.Y-h_i_s");

            ############ Formato
            #usuario(u_1) . tipoElemento(speaking, documento) . leccion(l_1) . textoRandom(5) . nombreArchivo
            $nombreFinalArchivo = $fecha . ".u_" . $this->userid . "." . $tipoElemento . ".l_" . $_POST['leccion'] . "." . basename($_FILES['fileAjax']['name']);
            $target_path = $target_path . $nombreFinalArchivo;

            /*Si los archivos se mueven correctamente al directorio indicado*/
            if (move_uploaded_file($_FILES['fileAjax']['tmp_name'], $target_path)) {
                $documento = (new EvaluacionDocumentos())->agregarDocumentosYspeakCargado((object)array(
                    "LGF0440002" => $this->userid,
                    "LGF0440003" => $_POST['leccion'],
                    "LGF0440004" => $nombreFinalArchivo,
                    "LGF0440005" => $tipoElemento,
                    "LGF0440009" => 1
                ));
                if ($documento) {
                    /*Se subio correctamente el documento*/
                    return 1;
                } else {
                    /*NO se subio correctamente el documento y se borra el archivo cargado a la carpeta*/
                    unlink($target_path);
                    return 0;
                }
            } /*Si los archivos NOOO se mueven correctamente al directorio indicado*/ else {
                /*NO se movio correctamente el documento a la carpeta destino CHECAR PERMISOS EN SERVIDOR*/
                return 0;
            }
        }
    }

    /**########################################################################################
     */


    public function borrarCache($claveModulo)
    {
        if (verificarClaveSistemaCache($claveModulo)) {
            SistemaDeCache::getInstance()->limpiarTodaLaCache();
            echo "Cache borrada";
            header("Refresh:3;url=home/index");
            exit();
        }
        return $this->Redirect('home', 'index');
    }


    public function audio()
    {
        $this->temp['encabezado'] = self::encabezado("Módulo speaking");
        $this->render();
    }


    public function index()
    {
        $this->render();
    }

    public function generarTextoAleatorio($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function menu()
    {


        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));

        $this->temp['perfil'] = $user[0]['LGF0010007'];
        $this->temp['usuario'] = $user[0]['LGF0010002'] . " " . $user[0]['LGF0010003'] . " " . $user[0]['LGF0010004'];

        if (empty($user[0]['LGF0010026'])) {
            $this->temp['continuar'] = false;
        } else {
            $this->temp['continuar'] = true;
        }

        $this->temp['avance'] = $user[0]['LGF0010023'] . "_" . $user[0]['LGF0010024'] . "_" . $user[0]['LGF0010025'] . "_" . $user[0]['LGF0010026'];

        $ultimoAvance = (new Administrador())->ultimoAvance($user[0]['LGF0010024'], $user[0]['LGF0010025']);
        $this->temp['avance_texto'] = $ultimoAvance[0]['LGF0150002'] . " / " . $ultimoAvance[0]['leccion'];

        $ultimoAcceso = (new Administrador())->ultimoAcceso($this->userid);
        // print_r($ultimoAcceso);
        if (empty($ultimoAcceso)) {
            $uAcceso = date("Y-m-d H:i:s");
        } else {
            $uAcceso = $ultimoAcceso[0]['LGF0360005'];
        }

        $aux = explode(" ", $uAcceso);
        $aux1 = explode("-", $aux[0]);
        $timestamp = strtotime($uAcceso);
        $day = date('w', $timestamp);
        $hora = date("A", strtotime($aux[1]));

        $this->temp['ultimoAcceso'] = $this->obtendia($day) . " " . $aux1[2] . " de " . $this->obtenmes($aux1[1]) . " del " . $aux1[0] . " " . $aux[1] . " " . $hora;

        $niveles = (new Nivel())->obtenNivel();
        $n = array();
        foreach ($niveles as $nivel) {
            $modulos = (new Modulo())->obtenModulo((object)array(
                "LGF0150004" => $nivel["LGF0140001"]
            ));
            $m = array();
            foreach ($modulos as $modulo) {
                array_push($m, array(
                    "id" => $modulo["LGF0150001"],
                    "nombre" => $modulo["LGF0150002"],
                    "img" => $modulo["LGF0150003"]
                ));
            }

            array_push($n, array(
                'id' => $nivel["LGF0140001"],
                'nombre' => $nivel['LGF0140002'],
                'img' => $nivel['LGF0140003'],
                'descripcion' => $nivel['LGF0140004'],
                'color' => $nivel['LGF0140005'],
                'modulos' => $m,
            ));
        }

        $this->temp['nivel_actual'] = $user[0]['LGF0010023'];
        $this->temp["niveles"] = $n;

        ////////// Validaciones de perfiles
        $validarAccesos = (new Administrador())->validarAccesos();
        /*echo "<pre>";
			print_r($validarAccesos);
			echo "</pre>";*/
        $niveles = array();
        foreach ($validarAccesos as $key => $value) {
            $niveles[] = (new Administrador())->obtener_nivel_modulo($value['modulo']);
        }
        /*echo "<pre>";
			print_r($niveles);
			echo "</pre>";*/
        $datos = $this->super_unique($niveles);

        $levelLeccion = "";
        foreach ($datos as $key => $value) {
            if ($key == 0) {
                $levelLeccion = $value[0]['nivel'];
            } else {
                $levelLeccion .= "," . $value[0]['nivel'];
            }
        }
        $this->temp['validarAccesos'] = $levelLeccion;

        if ($user[0]['LGF0010021'] == "") {
            $genero = "H";
        } else {
            $genero = $user[0]['LGF0010021'];
        }
        $aux = explode(",", $levelLeccion);
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 3) {
            $urls = $this->obtenerURL("A", 0);
            $imagen = $this->obtenerImagen("A", $genero, 0);
        } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6) {
            $urls = $this->obtenerURL($levelLeccion, 0);
            $imagen = $this->obtenerImagen($levelLeccion, $genero, 0);
        } else if ($_SESSION['perfil'] == 2) {
            // Habilitar todos los niveles para alumno demo == 55
            if ($user[0]['LGF0010023'] != 55) {
                $urls = $this->obtenerURL($user[0]['LGF0010023'], 0);
                $imagen = $this->obtenerImagen($user[0]['LGF0010023'], $genero, 0);
            } else {
                $urls = $this->obtenerURL("A", 0);
                $imagen = $this->obtenerImagen("A", $genero, 0);
            }
        }
        $this->temp['urls'] = $urls;
        $this->temp['imagen'] = $imagen;
        $this->render();
    }

    public function obtendia($dia)
    {
        switch ($dia) {
            case '1':
                $texto = "Lunes";
                break;
            case '2':
                $texto = "Martes";
                break;
            case '3':
                $texto = "Miércoles";
                break;
            case '4':
                $texto = "Jueves";
                break;
            case '5':
                $texto = "Viernes";
                break;
            case '6':
                $texto = "Sábado";
                break;
            case '0':
                $texto = "Domingo";
                break;
        }
        return $texto;
    }

    public function obtenmes($mes)
    {
        switch ($mes) {
            case '01':
                $texto = "Enero";
                break;
            case '02':
                $texto = "Febrero";
                break;
            case '03':
                $texto = "Marzo";
                break;
            case '04':
                $texto = "Abril";
                break;
            case '05':
                $texto = "Mayo";
                break;
            case '06':
                $texto = "Junio";
                break;
            case '07':
                $texto = "Julio";
                break;
            case '08':
                $texto = "Agosto";
                break;
            case '09':
                $texto = "Septiembre";
                break;
            case '10':
                $texto = "Octubre";
                break;
            case '11':
                $texto = "Noviembre";
                break;
            case '12':
                $texto = "Diciembre";
                break;
        }
        return $texto;
    }

    public function super_unique($array)
    {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                $result[$key] = self::super_unique($value);
            }
        }
        return $result;
    }

    public function lessons($modulo)
    {
        $modulos = (new Modulo())->obtenModulo((object)array(
            "LGF0150001" => $modulo
        ));
        if (empty($modulos)) {
            $this->Redirect();
        }

        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));
        $this->temp['haveGroup'] = empty($user[0]['LGF0010039']) ? 0 : 1;
        $this->temp['group'] = $user[0]['LGF0010039'];

        $niveles = (new Nivel())->obtenNivel((object)array(
            "LGF0140001" => $modulos[0]["LGF0150004"]
        ));
        $this->temp["color"] = $niveles[0]["LGF0140005"];

        $this->temp["modulo"] = array(
            "id" => $modulos[0]["LGF0150001"],
            "nombre" => $modulos[0]["LGF0150002"],
            "img" => $modulos[0]["LGF0150003"]
        );

        $lecciones = (new Administrador())->mostrarLecciones($modulo);


        $h = ($this->check_lesson_active());
        if ($_SESSION["perfil"] == 5 && ($h[2] + 1 != 3)) {
            $this->is_final_modulo($h);
        } else if ($_SESSION["perfil"] != 5) {
            $this->is_final_modulo($h);
        }
        $l = array();
        foreach ($lecciones as $leccion) {
            if ($leccion['LGF0160005'] == 1) { // Lecciones activas
                $estatus = 0;
                if ($modulos[0]["LGF0150004"] <= $h[0]) { // Si el nivel es meno o igual al actual
                    if ($modulos[0]["LGF0150004"] < $h[0]) { // Si el nivel es menor al actual desbloquemoa todo
                        $estatus = 1;
                    } else {
                        if ($modulos[0]["LGF0150001"] <= $h[1]) { // Se compara si el modulo el menos o igual al actual
                            if ($modulos[0]["LGF0150001"] < $h[1]) { // Si el modulo es menor al actual lo desbloquemos
                                $estatus = 1;
                            } else {
                                if ($leccion["LGF0160007"] <= $h[2]) { // Revisamos si el nivel actual es menor o igual al actual
                                    $estatus = 1; // Si es asi, lo desbloqueamos
                                }
                            }
                        } else {
                            $estatus = 0;
                        }
                    }
                } else {
                    $estatus = 0; // Si es mayor el modulo al del usuario lo bloqueamos todo
                }
                if ($leccion["LGF0160007"] < 9) {
                    $num_leccion = "0" . $leccion["LGF0160007"];
                }

                $ruta = __DIR__ . "/../../portal/archivos/iconosLecciones/";

                if ($leccion["LGF0160003"] != "" || $leccion["LGF0160003"] != null) {
                    $ruta .= "n" . $modulos[0]["LGF0150004"] . "/m" . $leccion["LGF0160004"] . "/l" . $leccion["LGF0160007"] . "/" . $leccion["LGF0160003"];
                } else {
                    $ruta .= "n" . $modulos[0]["LGF0150004"] . "/m" . $leccion["LGF0160004"] . "/l" . $leccion["LGF0160007"] . "/vacio";
                }
                // echo $ruta."<br>";

                /*if (!file_exists($ruta)) {
						$rutaImg = CONTEXT."portal/archivos/iconosLecciones/icono_temporal.png";
					} else {
						$rutaImg = CONTEXT."portal/archivos/iconosLecciones/n".$modulos[0]["LGF0150004"]."/m".$leccion["LGF0160004"]."/l".$leccion["LGF0160007"]."/".$leccion["LGF0160003"];
					}*/
                $rutaImg = ARCHIVO_FISICO . "iconosLecciones/n" . $modulos[0]["LGF0150004"] . "/m" . $leccion["LGF0160004"] . "/l" . $leccion["LGF0160007"] . "/" . $leccion["LGF0160003"];

                #Obtener imagen y video de preview para mostrar en modal
                if ($leccion["LGF0160008"] != null) {
                    $imagen = ARCHIVO_FISICO . 'previewsLecciones/l' . $leccion["LGF0160001"] . "_" . $leccion["LGF0160008"];
                } else {
                    $imagen = "no_image";
                }

                array_push($l, array(
                    'id' => $leccion["LGF0160001"],
                    'nombre' => $leccion["LGF0160002"],
                    'img' => $rutaImg,
                    'estatus' => 0,
                    'access' => 0,
                    'url' => CONTEXT . "home/navegar/" . $modulos[0]["LGF0150004"] . "_" . $modulos[0]["LGF0150001"] . "_" . $leccion["LGF0160001"],
                    'video_preview' => $leccion["LGF0160009"],
                    'imagen_preview' => $imagen #Ruta o "no_image"
                ));
            }
        }
        #var_dump($l);
        $this->temp['nivel_actual'] = $user[0]['LGF0010023'];
        $this->temp['modulo_actual'] = $user[0]['LGF0010024'];
        $this->temp['leccion_actual'] = $user[0]['LGF0010025'];
        $this->temp['grado'] = $modulos[0]['LGF0150002'];
        // Linea original
        // $this->temp ["lecciones"] = $l;
        ////////// Validaciones de perfiles
        $validarAccesos = (new Administrador())->validarAccesos();
        $levelLeccion = "";
        foreach ($validarAccesos as $key => $value) {
            if ($key == 0) {
                $levelLeccion = $value['modulo'];
            } else {
                $levelLeccion .= "," . $value['modulo'];
            }
        }
        $this->temp['validarAccesos'] = $levelLeccion;
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3) {
            $lock = $this->validarBloqueo("A", "");
        } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6) {
            $lock = $this->validarBloqueo($levelLeccion, $modulos[0]["LGF0150001"]);
        } else if ($_SESSION['perfil'] == 2) {
            if ($user[0]['LGF0010039'] == "") {
                for ($j = 0; $j < count($l); $j++) {
                    $l[$j]['estatus'] = 1;
                    $l[$j]['access'] = 1;
                }
                $lock = $this->validarBloqueo($user[0]['LGF0010024'], $modulos[0]["LGF0150001"]);
            } else {
                $accesDataL = array(
                    'LGF0370003' => $user[0]['LGF0010039'],
                    'LGF0370004' => $user[0]['LGF0010024']
                );
                #$this->temp['haveGroup'] = empty($user[0]['LGF0010039']) ? 0: 1;
                /*if( $this->temp['haveGroup'] == 1 )  {
						$validGroup = (new AccesoLecciones())->validateAssignedTeacher($this->temp['group']);
						$valid = false;
						foreach( $validGroup as $row ) {
							if( $row['num'] > 0 ) {
								$valid = true;
								break;
							}
						}

						if($valid) {
							$this->temp['haveGroup'] = 1;
						} else {
							$this->temp['haveGroup'] = 0;
						}
						#var_dump($validGroup);
					}*/
                $checkAccesoL = (new AccesoLecciones())->obtenerAccesoLeccion((object)$accesDataL);
                if (empty($checkAccesoL)) {
                    for ($j = 0; $j < count($l); $j++) {
                        $l[$j]['estatus'] = 1;
                        $l[$j]['access'] = 1;
                    }
                } else {
                    for ($j = 0; $j < count($l); $j++) {
                        for ($i = 0; $i < count($checkAccesoL); $i++) {
                            if ($l[$j]['id'] == $checkAccesoL[$i]['LGF0370005']) {
                                $l[$j]['estatus'] = 1;
                                $l[$j]['access'] = 1;
                            }
                        }
                    }
                }
            }
        }
        $this->temp["lecciones"] = $l;
        $this->temp['bloqueo'] = $lock;
        $this->temp['encabezado'] = self::encabezado($modulos[0]['LGF0150002'] . " - Lecciones");
        $this->render();
    }

    /*private function obtener_ruta_objeto($leccion = '', $modulo = '', $nivel = ''){

			if($nivel == ''){
				$nivel = $this->convertir_modulo_grado($modulo, 1);
				$nivel = $nivel[0]['nivel'];
			}
			// $url[0] -> Nivel
			// $url[1] -> Modulo*
			// $url[2] -> Leccion*
			$nav = (new Administrador())->navegacion($nivel, $modulo, $leccion);
			$current = $this->buscar ($nav, 1);

			return ODA_REL."n".$current["ID_nivel"]."/m".$current["ID_modulo"]."/l".$current["numero_leccion"]."/".$current["directorio"];
		}*/

    private function convertir_modulo_grado($modulo, $retornoTodo = 0)
    {
        $data = (new Administrador())->modulos($modulo);
        if ($retornoTodo == 1) {
            return $data;
        }
        return $data[0]['nombre'];
    }

    public function teacher_students($id_grupo)
    {
        $is_my_group = (new Grupos())->obtenGrupo((object)array(
            'LGF0290001' => $id_grupo,
            'LGF0290006' => $_SESSION['idUsuario']
        ));

        if (count($is_my_group) == 0) {
            $this->Redirect();
        }
        $this->temp['lista'] = (new Administrador())->listar_alumnos_grupo($id_grupo, 'LGF0010002');

        $this->temp['nombre_grupo'] = $is_my_group[0]['LGF0290002'];
        $this->temp['modulo'] = $this->convertir_modulo_grado($is_my_group[0]['LGF0290005']);
        $this->temp['id_modulo'] = $is_my_group[0]['LGF0290005'];
        $this->temp['id_grupo'] = $id_grupo;
        $this->temp['id_institucion'] = $is_my_group[0]['LGF0290004'];

        $this->render();
    }

    public function preschool()
    {
        $modulo = 1;
        $modulos = (new Modulo())->obtenModulo((object)array(
            "LGF0150004" => $modulo
        ));

        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));

        if (empty($modulos)) {
            $this->Redirect();
        }

        $niveles = (new Nivel())->obtenNivel((object)array(
            "LGF0140001" => $modulos[0]["LGF0150004"]
        ));
        $this->temp["color"] = $niveles[0]["LGF0140005"];

        $this->temp["modulo"] = array(
            "id" => $modulos[0]["LGF0150001"],
            "nombre" => $modulos[0]["LGF0150002"],
            "img" => $modulos[0]["LGF0150003"]
        );
        $lecciones = (new Leccion())->obtenLeccion((object)array(
            "LGF0160004" => $modulo
        ));
        $h = ($this->check_lesson_active());
        if ($_SESSION["perfil"] == 5 && ($h[2] + 1 != 3)) {
            $this->is_final_modulo($h);
        } else if ($_SESSION["perfil"] != 5) {
            $this->is_final_modulo($h);
        }

        $this->temp['nivel_actual'] = $user[0]['LGF0010023'];
        $this->temp['modulo_actual'] = $user[0]['LGF0010024'];
        $this->temp['leccion_actual'] = $user[0]['LGF0010025'];
        $this->temp['encabezado'] = self::encabezado("Nivel Preescolar");

        ////////// Validaciones de perfiles
        $validarAccesos = (new Administrador())->validarAccesos();
        /*echo "<pre>";
			print_r($validarAccesos);
			echo "</pre>";*/
        $levelLeccion = "";
        foreach ($validarAccesos as $key => $value) {
            if ($key == 0) {
                $levelLeccion = $value['modulo'];
            } else {
                $levelLeccion .= "," . $value['modulo'];
            }
        }
        $this->temp['validarAccesos'] = $levelLeccion;
        if ($user[0]['LGF0010021'] == "") {
            $genero = "H";
        } else {
            $genero = $user[0]['LGF0010021'];
        }
        $aux = explode(",", $levelLeccion);
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5) {
            $urls = $this->obtenerURL("A", 3, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen("A", $genero, 1);
        } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 6) {
            $urls = $this->obtenerURL($levelLeccion, 3, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen($levelLeccion, $genero, 0);
        } else if ($_SESSION['perfil'] == 2) {
            // Habilitar todos los niveles para alumno demo == 55
            if ($user[0]['LGF0010023'] != 55) {
                $urls = $this->obtenerURL($user[0]['LGF0010024'], 3, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen($user[0]['LGF0010024'], $genero, 0);
            } else {
                $urls = $this->obtenerURL("A", 3, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen("A", $genero, 1);
            }
        }

        /**
         * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
         */
        $this->temp['verificaEvaluacionTrimestral'] = "Home/primary#";

        if (verificaModuloSistemaActivo('ExamenTrimestral')) {
            $verificaEvaluacionTrimestral = (new Usuarios())->verificaSiHayEvaluacionDeAlumno($this->userid);
            if ($verificaEvaluacionTrimestral) {
                $this->temp['verificaEvaluacionTrimestral'] = "evaluaciontrimestral/mostrarevaluacionresumenalumno/" . $verificaEvaluacionTrimestral[0]['LGF0420001'];
            } else {
                $this->temp['verificaEvaluacionTrimestral'] = 'evaluaciontrimestral/mostrarevaluacionresumenalumno/aunNo';
            }
        } else {
            $this->temp['verificaEvaluacionTrimestral'] = "home/avancetrimestral";
        }

        $this->temp['urls'] = $urls;
        $this->temp['imagen'] = $imagen;
        $this->render();
    }

    public function primary()
    {
        $modulo = 2;
        $modulos = (new Modulo())->obtenModulo((object)array(
            "LGF0150004" => $modulo
        ));

        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));

        if (empty($modulos)) {
            $this->Redirect();
        }

        $niveles = (new Nivel())->obtenNivel((object)array(
            "LGF0140001" => $modulos[0]["LGF0150004"]
        ));
        $this->temp["color"] = $niveles[0]["LGF0140005"];

        $this->temp["modulo"] = array(
            "id" => $modulos[0]["LGF0150001"],
            "nombre" => $modulos[0]["LGF0150002"],
            "img" => $modulos[0]["LGF0150003"]
        );
        $lecciones = (new Leccion())->obtenLeccion((object)array(
            "LGF0160004" => $modulo
        ));
        $h = ($this->check_lesson_active());
        if ($_SESSION["perfil"] == 5 && ($h[2] + 1 != 3)) {
            $this->is_final_modulo($h);
        } else if ($_SESSION["perfil"] != 5) {
            $this->is_final_modulo($h);
        }

        $this->temp['nivel_actual'] = $user[0]['LGF0010023'];
        $this->temp['modulo_actual'] = $user[0]['LGF0010024'];
        $this->temp['leccion_actual'] = $user[0]['LGF0010025'];
        $this->temp['encabezado'] = self::encabezado("Nivel Primaria");

        ////////// Validaciones de perfiles
        $validarAccesos = (new Administrador())->validarAccesos();
        /*echo "<pre>";
			print_r($validarAccesos);
			echo "</pre>";*/
        $levelLeccion = "";
        foreach ($validarAccesos as $key => $value) {
            if ($key == 0) {
                $levelLeccion = $value['modulo'];
            } else {
                $levelLeccion .= "," . $value['modulo'];
            }
        }
        $this->temp['validarAccesos'] = $levelLeccion;
        if ($user[0]['LGF0010021'] == "") {
            $genero = "H";
        } else {
            $genero = $user[0]['LGF0010021'];
        }
        $aux = explode(",", $levelLeccion);
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5) {
            $urls = $this->obtenerURL("A", 1, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen("A", $genero, 1);
        } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3 || $_SESSION['perfil'] == 6) {
            $urls = $this->obtenerURL($levelLeccion, 1, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen($levelLeccion, $genero, 1);
        } else if ($_SESSION['perfil'] == 2) {
            // Habilitar todos los niveles para alumno demo == 55
            if ($user[0]['LGF0010023'] != 55) {
                $urls = $this->obtenerURL($user[0]['LGF0010024'], 1, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen($user[0]['LGF0010024'], $genero, 1);
            } else {
                $urls = $this->obtenerURL("A", 1, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen("A", $genero, 1);
            }
        }

        /**
         * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
         */
        $this->temp['verificaEvaluacionTrimestral'] = "Home/primary#";

        if (verificaModuloSistemaActivo('ExamenTrimestral')) {
            $verificaEvaluacionTrimestral = (new Usuarios())->verificaSiHayEvaluacionDeAlumno($this->userid);
            if ($verificaEvaluacionTrimestral) {
                $this->temp['verificaEvaluacionTrimestral'] = "evaluaciontrimestral/mostrarevaluacionresumenalumno/" . $verificaEvaluacionTrimestral[0]['LGF0420001'];
            } else {
                $this->temp['verificaEvaluacionTrimestral'] = 'evaluaciontrimestral/mostrarevaluacionresumenalumno/aunNo';
            }
        } else {
            $this->temp['verificaEvaluacionTrimestral'] = "home/avancetrimestral";
        }

        $this->temp['urls'] = $urls;
        $this->temp['imagen'] = $imagen;
        $this->render();
    }

    public function secundary()
    {
        $modulo = 3;
        $modulos = (new Modulo())->obtenModulo((object)array(
            "LGF0150004" => $modulo
        ));

        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));

        if (empty($modulos)) {
            $this->Redirect();
        }

        $niveles = (new Nivel())->obtenNivel((object)array(
            "LGF0140001" => $modulos[0]["LGF0150004"]
        ));

        $this->temp["color"] = $niveles[0]["LGF0140005"];

        $this->temp["modulo"] = array(
            "id" => $modulos[0]["LGF0150001"],
            "nombre" => $modulos[0]["LGF0150002"],
            "img" => $modulos[0]["LGF0150003"]
        );
        $lecciones = (new Leccion())->obtenLeccion((object)array(
            "LGF0160004" => $modulo
        ));
        $h = ($this->check_lesson_active());
        if ($_SESSION["perfil"] == 5 && ($h[2] + 1 != 3)) {
            $this->is_final_modulo($h);
        } else if ($_SESSION["perfil"] != 5) {
            $this->is_final_modulo($h);
        }
        $l = array();

        $this->temp['nivel_actual'] = $user[0]['LGF0010023'];
        $this->temp['modulo_actual'] = $user[0]['LGF0010024'];
        $this->temp['leccion_actual'] = $user[0]['LGF0010025'];
        $this->temp['encabezado'] = self::encabezado("Nivel Secundaria");

        ////////// Validaciones de perfiles
        $validarAccesos = (new Administrador())->validarAccesos();
        /*echo "<pre>";
			print_r($validarAccesos);
			echo "</pre>";*/
        $levelLeccion = "";
        foreach ($validarAccesos as $key => $value) {
            if ($key == 0) {
                $levelLeccion = $value['modulo'];
            } else {
                $levelLeccion .= "," . $value['modulo'];
            }
        }
        $this->temp['validarAccesos'] = $levelLeccion;
        if ($user[0]['LGF0010021'] == "") {
            $genero = "H";
        } else {
            $genero = $user[0]['LGF0010021'];
        }
        $aux = explode(",", $levelLeccion);
        if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 3) {
            $urls = $this->obtenerURL("A", 2, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen("A", $genero, 2);
        } else if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 6) {
            $urls = $this->obtenerURL($levelLeccion, 2, $niveles[0]["LGF0140005"]);
            $imagen = $this->obtenerImagen($levelLeccion, $genero, 2);
        } else if ($_SESSION['perfil'] == 2) {
            // Habilitar todos los niveles para alumno demo == 55
            if ($user[0]['LGF0010023'] != 55) {
                $urls = $this->obtenerURL($user[0]['LGF0010024'], 2, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen($user[0]['LGF0010024'], $genero, 2);
            } else {
                $urls = $this->obtenerURL("A", 2, $niveles[0]["LGF0140005"]);
                $imagen = $this->obtenerImagen("A", $genero, 2);
            }
        }

        /**
         * Verifica en la seccion de modulos si esta habilitada esta opcion, tbl:lg00043
         */
        $this->temp['verificaEvaluacionTrimestral'] = "Home/primary#";

        if (verificaModuloSistemaActivo('ExamenTrimestral')) {
            $verificaEvaluacionTrimestral = (new Usuarios())->verificaSiHayEvaluacionDeAlumno($this->userid);
            if ($verificaEvaluacionTrimestral) {
                $this->temp['verificaEvaluacionTrimestral'] = "evaluaciontrimestral/mostrarevaluacionresumenalumno/" . $verificaEvaluacionTrimestral[0]['LGF0420001'];
            } else {
                $this->temp['verificaEvaluacionTrimestral'] = 'evaluaciontrimestral/mostrarevaluacionresumenalumno/aunNo';
            }
        } else {
            $this->temp['verificaEvaluacionTrimestral'] = "home/avancetrimestral";
        }

        $this->temp['urls'] = $urls;
        $this->temp['imagen'] = $imagen;
        $this->render();
    }

    /** Verifica un campo y arma una ruta de portal/archivos/recursosLecciones/ODA/$CARPETA_portal_archivos_oda(img-mp3)/$campo_base_datos
     * @return string $rutaImgInst
     */
    public function crea_ruta_elemento($campo_current_data, $CARPETA_portal_archivos_oda, $current_ruta_seccion)
    {
        #$url_path_local_img_instrucciones = __DIR__."/../../portal/archivos/recursosLecciones/";
        $url_path_remote_img_instrucciones = ARCHIVO_FISICO . "recursosLecciones/";

        if ($current_ruta_seccion[$campo_current_data] != "" || $current_ruta_seccion[$campo_current_data] != null) {
            $ruta_elemento = "n" . $current_ruta_seccion["ID_nivel"] . "/m" . $current_ruta_seccion["ID_modulo"] . "/l" . $current_ruta_seccion["numero_leccion"] . "/" . $CARPETA_portal_archivos_oda . "/" . $current_ruta_seccion[$campo_current_data];

            /*##########################################*/
            /*if (!file_exists($url_path_local_img_instrucciones.$ruta_elemento)) {
					$ruta_elemento = '';
				}else{
					$ruta_elemento = $url_path_remote_img_instrucciones.$ruta_elemento;
				}*/
            $ruta_elemento = $url_path_remote_img_instrucciones . $ruta_elemento;
            /*##########################################*/
        } else {
            $ruta_elemento = '';
        }
        return $ruta_elemento;
    }

    public function navegar($param)
    {
        $url = explode("_", $param);
        if (count($url) <= 2) {
            $this->Redirect("home", "menu");
        }

        $mostrar_ocultas = (isset($url[4]) ? 0 : 1);
        $orden = (isset($url[3]) ? $url[3] : 1);
        $nav = (new Administrador())->navegacion($url[0], $url[1], $url[2], 0, $mostrar_ocultas);
        $current = $this->buscar($nav, $orden);
        #var_dump($current);
        // $url[0] -> Nivel
        // $url[1] -> Modulo*
        // $url[2] -> Leccion*

        $valorAux = $url;
        $menuNavegacion = (new Administrador())->obtenerMenuNavegacion($url[0], $url[1], $url[2]);
        #var_dump($menuNavegacion); #15 nivel, 16 *leccion-modulo
        $enlaces = array();
        foreach ($menuNavegacion as $key => $value) {
            #if ($value['LGF0180005'] != 11) {
            $url = CONTEXT . "home/navegar/" . $value['LGF0180002'] . "_" . $value['LGF0180003'] . "_" . $value['LGF0180004'] . "_" . $value['LGF0180006'];

            array_push($enlaces, array(
                'nombre' => $value['nombre'],
                'img' => $value['imagen'],
                'link' => $url,
                'seccion' => $value['LGF0180005'],
                'indentificadorSeccion' => $value['LGF0180002'] . "_" . $value['LGF0180003'] . "_" . $value['LGF0180004'] . "_" . $value['LGF0180005']
            ));
            #}
        }
        $cantidadExcercise = 0;
        foreach ($enlaces as $enlace) {
            if (strripos($enlace['nombre'], 'exercise')) {
                $cantidadExcercise++;
            }
        }
        #$this->temp['cantidadExcercise'] = $cantidadExcercise;
        $ejerciciosHechosAlumno = (new AvancesAlumno())->obtenerAvancesAlumno((object)array(
            /*"LGF0410002" => $current ["ID_nivel"],
				"LGF0410003" => $current ["ID_modulo"],
				"LGF0410005" => $current ["ID_seccion"],*/
            "LGF0410004" => $current["ID_leccion"],
            "LGF0410006" => $this->userid
        ));

        $ejerciciosHechosAlumnoTot = array();
        foreach ($ejerciciosHechosAlumno as $ejercicio) {
            $ejerciciosHechosAlumnoTot[] = $ejercicio['LGF0410002'] . "_" . $ejercicio['LGF0410003'] . "_" . $ejercicio['LGF0410004'] . "_" . $ejercicio['LGF0410005'];
        }
        $this->temp['ejerciciosHechosAlumnoTot'] = $ejerciciosHechosAlumnoTot;
        #echo "Cantidad de excercises: ".$cantidadExcercise;
        #echo "Cantidad de excercises hechos: ".count($ejerciciosHechosAlumnoTot);

        $this->temp['enlaces'] = $enlaces;

        $user = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));

        $_logReg = array(
            'LGF0360002' => $_SESSION["idUsuario"],
            'LGF0360003' => 2,
            'LGF0360006' => $url[0],
            'LGF0360007' => $url[1],
            'LGF0360008' => $url[2]
        );

        if (!isset($_SESSION['regLeccion'])) {
            if (isset($_SESSION['regLeccion'])) {
                unset($_SESSION['regLeccion']);
            }
            $_logReg = array(
                'LGF0360002' => $_SESSION["idUsuario"],
                'LGF0360003' => 2,
                'LGF0360004' => date("Y-m-d H:i:s"),
                'LGF0360006' => $url[0],
                'LGF0360007' => $url[1],
                'LGF0360008' => $url[2]
            );
            $respuesta = (new LogRegistros())->agregarLogRegistros((object)$_logReg);
            $_SESSION['regLeccion'] = $respuesta;
        }

        $evaluacion = (new Evaluacion())->obtenEvaluacion((object)array(
            "LGF0190005" => $current["ID_nivel"],
            "LGF0190006" => $current["ID_modulo"],
            "LGF0190007" => $current["ID_leccion"],
            "LGF0190010" => 1
        ));

        $ordenEval = (new Administrador())->orden_evaluacion($current["ID_modulo"], $current["ID_leccion"]);

        $actual_abs = ODA . "n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/" . $current["directorio"] . "/";
        $actual_rel = ODA_REL . "n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/" . $current["directorio"] . "/";
        $this->temp["dir_oda"] = $actual_rel;

        /**
         * Si el ID_seccion es 11) Review [Evaluacion], se iguala el campo $ordenEval[0]['orden'] para forzar la evaluación.
         */
        if ($current["ID_seccion"] == 11 && ($current["orden"] != $ordenEval[0]['orden'])) {
            $ordenEval[0]['orden'] = $current["orden"];
        }

        # Si llego a la seccion de evaluacion procedemos a verificar que haya terminado los exercises y
        # que haya cargado tanto speaking como documento solicitado por docente
        if ((!empty($evaluacion) && $current["orden"] == $ordenEval[0]['orden'])) {

            #echo "Cantidad de excercises: ".$cantidadExcercise;
            #echo "Cantidad de excercises hechos: ".count($ejerciciosHechosAlumnoTot);

            #Verificamos si el alumno ha completado la cantidad de exersices de su leccion
            if ($cantidadExcercise > count($ejerciciosHechosAlumnoTot)) {

                $this->temp['anotaciones'] = 'not_exercises_yet';
                $this->temp['cantidadEjercicios'] = $cantidadExcercise;
                $this->temp['cantidadEjerciciosHechos'] = count($ejerciciosHechosAlumnoTot);
                $this->temp['js_evaluacion_abs'] = 'no_acabo_ejercicios';
                $this->temp['js_evaluacion_rel'] = 'no_acabo_ejercicios';
            } #Si ya acabo los exercises que tiene la leccion
            else {
                #Verificamos si ya se cargaron los archivos para poder hacer su evaluacion
                $haSubidoArchivosSpeakDoc = (new EvaluacionDocumentos())->verificarDocumentosYspeakCargado((object)array(
                    "LGF0440002" => $this->userid,
                    "LGF0440003" => $current["ID_leccion"],
                ));
                #var_dump($current ["ID_leccion"]);

                #Si no ha cargado documentos tendra que hacerlo antes de pasar a la evaluacion
                if ($haSubidoArchivosSpeakDoc == null) {
                    $this->temp['anotaciones'] = 'no_files';
                } #Si ya cargo documentos empezamos a validar cuales le hacen falta cargar
                else {
                    #Comprobamos que archivos se han subido
                    $speaking = false;
                    $documentoSolicitado = false;
                    foreach ($haSubidoArchivosSpeakDoc as $archivo) {
                        #Verificacion tipo de documento cargado
                        if ($archivo['LGF0440005'] == 'speaking') {
                            $speaking = true;
                        }
                        if ($archivo['LGF0440005'] == 'documento') {
                            $documentoSolicitado = true;
                        }
                    }

                    #En caso de que se haya cargado los documentos ya podra ver la evaluacion
                    if ($speaking && $documentoSolicitado) {
                        $this->temp['anotaciones'] = 'files_loaded';

                        #Verificamos si el alumno ya realizo su evaluacion
                        $evaluacionHechaLeccion = (new Administrador())->existe_evaluacion_hecha($this->userid, $current["ID_leccion"]);
                        #var_dump($evaluacionHechaLeccion);
                        if ($evaluacionHechaLeccion) {
                            $this->temp['examen'] = 'already_applied';
                            $this->temp['resultadosEval'] = $evaluacionHechaLeccion[0];
                        } else {
                            $this->temp['examen'] = 'not_applied';
                        }
                        $this->temp["js_evaluacion_abs"] = ODA . "../frontend/js/evaluacion.js";
                        $this->temp["js_evaluacion_rel"] = ODA_REL . "../frontend/js/evaluacion.js";
                    } elseif ($speaking) {
                        $this->temp['anotaciones'] = 'document_missing';
                    } elseif ($documentoSolicitado) {
                        $this->temp['anotaciones'] = 'speaking_missing';
                    } else {
                        $this->temp['anotaciones'] = 'no_files';
                    }
                }
            }
        } else {
            $this->temp["css_oda_abs"] = $actual_abs . "lo.css";
            $this->temp["css_oda_rel"] = $actual_rel . "lo.css";
            $this->temp["js_oda_abs"] = $actual_abs . "lo.js";
            $this->temp["js_oda_rel"] = $actual_rel . "lo.js";
        }

        $prev = $this->buscar($nav, ($orden - 1), false);
        $next = $this->buscar($nav, ($orden + 1), true);

        $ruta = ARCHIVO_FISICO . "iconosLecciones/";

        if ($current["img_leccion"] != "" || $current["img_leccion"] != null) {
            $ruta .= "n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/" . $current["img_leccion"];
        } else {
            $ruta .= "n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/vacio";
        }
        // echo $ruta."<br>";

        /*if (!file_exists($ruta)) {
				$rutaImg = CONTEXT."portal/archivos/iconosLecciones/icono_temporal.png";
			} else {
				$rutaImg = CONTEXT."portal/archivos/iconosLecciones/n".$current["ID_nivel"]."/m".$current["ID_modulo"]."/l".$current["numero_leccion"]."/".$current["img_leccion"];
			}*/
        $rutaImg = ARCHIVO_FISICO . "iconosLecciones/n" . $current["ID_nivel"] . "/m" . $current["ID_modulo"] . "/l" . $current["numero_leccion"] . "/" . $current["img_leccion"];

        ########################################################################
        /*########## Implementacion de instrucciones, imagen y audios*/
        $rutaImgInst = $this->crea_ruta_elemento('img_instrucciones', 'img', $current);
        $audio_en = $this->crea_ruta_elemento('audio_en', 'mp3', $current);
        $audio_es = $this->crea_ruta_elemento('audio_es', 'mp3', $current);

        #instrucciones imagen y audios
        $this->temp['instrucciones_img'] = $rutaImgInst;
        $this->temp['audio_es'] = $audio_es;
        $this->temp['audio_en'] = $audio_en;
        ########################################################################


        #Instrucciones en texto plano
        $this->temp['instrucciones_es'] = ($current["texto_es"] == "" ? "" : $current["texto_es"]);
        $this->temp['instrucciones_en'] = ($current["texto_en"] == "" ? "" : $current["texto_en"]);

        $this->temp["anterior"] = ($prev != null ? CONTEXT . "home/navegar/" . $prev["ID_nivel"] . "_" . $prev["ID_modulo"] . "_" . $prev["ID_leccion"] . "_" . $prev["orden"] : CONTEXT . "home/lessons/" . $current["ID_modulo"]);
        $this->temp["siguiente"] = ($next != null ? CONTEXT . "home/navegar/" . $next["ID_nivel"] . "_" . $next["ID_modulo"] . "_" . $next["ID_leccion"] . "_" . $next["orden"] : CONTEXT . "home/lessons/" . $current["ID_modulo"]);

        $this->temp["id_modulo"] = $current["ID_modulo"];
        $this->temp["id_nivel"] = $current["ID_nivel"];

        $this->temp["id_leccion"] = $current["ID_leccion"];
        $this->temp["numero_leccion"] = $current["numero_leccion"];
        // $this->temp["numero_leccion"] = $current["ID_leccion"];
        $this->temp["leccion"] = $current["leccion"];
        // $this->temp["img_leccion"] = $current["img_leccion"];
        $this->temp["img_leccion"] = $rutaImg;

        $this->temp["id_seccion"] = $current["ID_seccion"];
        $this->temp["nombre_seccion"] = $current["seccion"];
        $this->temp["img_seccion"] = $current["img_seccion"];

        $this->temp["orden"] = $current["orden"];
        $this->temp["color"] = $current["color"];
        $this->temp["retroseso"] = 1;
        /* Ponemos el template que queremos utilizar y renderizamos la pagina a la que sera guiado. */
        $this->body_custom = dirname(__FILE__) . "/../../portal/frontend/views/home/oda.php";

        // $this->save_lesson_active($current["ID_nivel"], $current["ID_modulo"], $current["numero_leccion"], $current["orden"]);
        // echo "ID Leccion: ".$current ["ID_leccion"]." - ID Modulo: ".$current ["ID_modulo"]."<br>";
        $obtener_seccion = $current['ID_leccion'];
        $modulo_paso = (new Administrador())->ultima_seccion($current['ID_modulo'], $obtener_seccion, 1);
        // print_r($modulo_paso);

        $seccion_actual = $valorAux[3];
        $ultima_seccion = $modulo_paso[0]['seccion'];
        // echo $seccion_actual." == ".$ultima_seccion."<br>";
        // print_r($evaluacion);
        $accesDataL = array(
            'LGF0370003' => ($user[0]['LGF0010039'] == "" ? 0 : $user[0]['LGF0010039']),
            'LGF0370004' => $user[0]['LGF0010024']
        );

        $checkAccesoL = (new AccesoLecciones())->obtenerAccesoLeccion((object)$accesDataL);

        if ($seccion_actual == $ultima_seccion) {
            if ($user[0]['LGF0010039'] == "" || empty($checkAccesoL)) {
                // echo "Original";
                $obtener_siguiente = (new Administrador())->ultima_seccion($current['ID_modulo'], $obtener_seccion, 3);
                // print_r($obtener_siguiente);
                $new_seccion = $obtener_siguiente[0]['LGF0160007'] + 1;
                $new_paso = (new Administrador())->ultima_seccion($current['ID_modulo'], $new_seccion, 2);
                $this->paso_siguiente_leccion($new_paso[0]['nivel'], $new_paso[0]['modulo'], $new_paso[0]['leccion'], $new_paso[0]['seccion'], 1);
            } else {
                foreach ($checkAccesoL as $key => $value) {
                    if ($value['LGF0370005'] == $valorAux[2]) {
                        $posicion = $key;
                    }
                }
                // echo $checkAccesoL[$posicion+1]['LGF0370005'];
                if ($checkAccesoL[$posicion + 1]['LGF0370004'] != "") {
                    $obtener_siguiente = (new Administrador())->ultima_seccion($checkAccesoL[$posicion + 1]['LGF0370004'], $checkAccesoL[$posicion + 1]['LGF0370005'], 3);

                    $new_seccion = $obtener_siguiente[0]['LGF0160007'];
                    $new_paso = (new Administrador())->ultima_seccion($checkAccesoL[$posicion + 1]['LGF0370004'], $new_seccion, 2);
                    $this->paso_siguiente_leccion($new_paso[0]['nivel'], $new_paso[0]['modulo'], $new_paso[0]['leccion'], $new_paso[0]['seccion'], 1);
                }
            }
        }
        #var_dump($this->temp);
        #ACTIVADOS MOMENTANEAMIENTE
        if ($_SESSION['perfil'] == 1 && (!empty($evaluacion) && $current["orden"] == $ordenEval[0]['orden'])) {
            $this->temp["js_evaluacion_abs"] = ODA . "../frontend/js/evaluacion.js";
            $this->temp["js_evaluacion_rel"] = ODA_REL . "../frontend/js/evaluacion.js";
        }
        $this->render();
    }

    private function buscar(&$array, $orden, $next = true)
    {
        if ($orden > $array[count($array) - 1]["orden"]) {
            return null;
        }
        if ($orden <= 0) {
            return null;
        }
        foreach ($array as $k => $v) {
            if ($v['orden'] == $orden) {
                return $array[$k];
                break;
            }
        }
        $orden = $next ? $orden + 1 : $orden - 1;
        //var_dump($array);
        return $this->buscar($array, $orden, $next);
    }

    private function check_lesson_active()
    {
        $usuario = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));
        $usuario = $usuario[0];
        $nivel = empty($usuario["LGF0010023"]) ? 1 : $usuario["LGF0010023"];
        $modulo = empty($usuario["LGF0010024"]) ? 1 : $usuario["LGF0010024"];
        $leccion = empty($usuario["LGF0010025"]) ? 1 : $usuario["LGF0010025"];
        $orden = empty($usuario["LGF0010026"]) ? 1 : $usuario["LGF0010026"];
        return array(
            $nivel,
            $modulo,
            $leccion,
            $orden
        );
    }

    // Funcion creada para dar paso al siguiente modulo
    private function paso_siguiente_leccion($nivel, $modulo, $leccion, $seccion, $update)
    {
        // echo "Nivel: ".$nivel." Modulo: ".$modulo." Leccion: ".$leccion." Orden: ".$seccion." Update: ".$update."<br>";
        $datos = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));
        $datos = $datos[0];
        $nivelOld = $datos["LGF0010023"];
        $moduloOld = $datos["LGF0010024"];
        $leccionOld = $datos["LGF0010025"];
        $seccionOld = $datos["LGF0010026"];
        if ($_SESSION['perfil'] == 2) {
            if ($nivel == $nivelOld) {
                if ($modulo >= $moduloOld) {
                    if ($leccion >= $leccionOld) {
                        // echo "SeccionOld: ".$seccionOld."<br>";
                        if ($update == 2) {
                            // echo "1";
                            if ($seccion >= $seccionOld) {
                                $usuario = array(
                                    "LGF0010023" => $nivel,
                                    "LGF0010024" => $modulo,
                                    "LGF0010025" => $leccion,
                                    "LGF0010026" => $seccion
                                );

                                // print_r($usuario);
                                (new Usuarios())->actualizarUsuario((object)$usuario, (object)array(
                                    "LGF0010001" => $this->userid
                                ));
                            }
                        } else {
                            // echo "2";
                            $usuario = array(
                                "LGF0010023" => $nivel,
                                "LGF0010024" => $modulo,
                                "LGF0010025" => $leccion,
                                "LGF0010026" => $seccion
                            );
                            // print_r($usuario);
                            (new Usuarios())->actualizarUsuario((object)$usuario, (object)array(
                                "LGF0010001" => $this->userid
                            ));
                        }
                    }
                }
            }
        }
    }

    private function save_lesson_active($nivel, $modulo, $leccion, $orden)
    {
        // echo "Nivel: ".$nivel." Modulo: ".$modulo." Leccion: ".$leccion." Orden: ".$orden."<br>";
        $usuario = (new Usuarios())->obtenUsuario((object)array(
            "LGF0010001" => $this->userid
        ));
        $usuario = $usuario[0];
        if ($usuario["LGF0010023"] <= $nivel) {
            $usuario["LGF0010023"] = ($usuario["LGF0010023"] < $nivel) ? $nivel : $usuario["LGF0010023"];
            if ($usuario["LGF0010024"] <= $modulo) {
                $usuario["LGF0010024"] = ($usuario["LGF0010024"] < $modulo) ? $modulo : $usuario["LGF0010024"];
                if ($usuario["LGF0010025"] <= $leccion) {
                    $usuario["LGF0010025"] = ($usuario["LGF0010025"] < $leccion) ? $leccion : $usuario["LGF0010025"];
                    if ($usuario["LGF0010026"] <= $orden) {
                        $usuario["LGF0010026"] = ($usuario["LGF0010026"] < $orden) ? $orden : $usuario["LGF0010026"];
                    }
                }
            }
        }

        (new Usuarios())->actualizarUsuario((object)$usuario, (object)array(
            "LGF0010001" => $this->userid
        ));
    }

    private function is_final_modulo(&$historia)
    {
        // Recuperamos los modulos del nivel
        $modulos = (new Modulo())->obtenModulo((object)array(
            "LGF0150004" => $historia[0]
        ));
        // Recuperamos las lecciones del modulo
        $lecciones = (new Leccion())->obtenLeccion((object)array(
            "LGF0160004" => $historia[1]
        ));
        // Recuperamos la leccion actual
        $leccion_actual = (new Leccion())->obtenLeccion((object)array(
            "LGF0160004" => $historia[1],
            "LGF0160007" => $historia[2]
        ));
        // Recuperamos la navegacion de orden
        $nav = (new Administrador())->navegacion($historia[0], $historia[1], $leccion_actual[0]["LGF0160001"]);
        // Revisamos si llego al top de objetos de la leccion

        if ($historia[3] == $nav[count($nav) - 1]["orden"]) {
            // if ($historia [3] == count ( $nav )) {
            // Recuperamos el usuario
            $usuario = (new Usuarios())->obtenUsuario((object)array(
                "LGF0010001" => $this->userid
            ));
            $usuario = $usuario[0];
            $historia[3] = 1; // Si llegamos al limite reseteamos
            $usuario["LGF0010026"] = $historia[3]; // Guardamos el reseteo del modulo con el usuario
            if ($historia[2] + 1 > count($lecciones)) { // Revisamos si hemos llegado al limite de lecciones del modulo
                $historia[2] = 1; // Reseteamos la leccion
                $usuario["LGF0010025"] = $historia[2]; // Guardamos el reseteo del modulo con el usuario
                if ($historia[1] + 1 > count($modulos)) {
                    // Aumentamos el nivel si este ya supero los modulos
                    if ($historia[0] != 2) {
                        $historia[0] += 1;
                    }
                    $usuario["LGF0010023"] = $historia[0];
                    // aumentamos el modulo
                    $historia[1] += 1;
                    $usuario["LGF0010024"] = $historia[1];
                } else {
                    // volvemos a aumentar el modulo
                    $historia[1] += 1;
                    $usuario["LGF0010024"] = $historia[1];
                }
            } else {
                $historia[2] += 1; // Si no es asi, aumentamos uno para desbloquear el siguiente
                $usuario["LGF0010025"] = $historia[2]; // Guardamos el reseteo del modulo con el usuario
            }
            (new Usuarios())->actualizarUsuario((object)$usuario, (object)array(
                "LGF0010001" => $this->userid
            ));
        }
    }

    /**
     * Modulos de perdil, reportes, guias y recursos
     */
    public function profile()
    {
        $obtenerInstitucion = '';
        $datos = (new Administrador())->informacion();
        if ($_SESSION['perfil'] == 3) {
            $email = $datos[0]['LGF0280018'];
            $name = $datos[0]['LGF0280002'];
            $user = $datos[0]['LGF0280019'];
        } else if ($_SESSION['perfil'] == 4) {
            $email = $datos[0]['LGF0270027'];
            $user = $datos[0]['LGF0270024'];
            $name = $datos[0]['LGF0270002'];
            $obtenerInstitucion = $datos[0]['LGF0270028'];
        } else {
            $email = $datos[0]['LGF0010012'];
            $name = $datos[0]['LGF0010002'] . " " . $datos[0]['LGF0010003'] . " " . $datos[0]['LGF0010004'];
            $user = $datos[0]['LGF0010005'];
            $obtenerInstitucion = (new Instituciones())->obtenInstitucion((object)array('LGF0270001' => $datos[0]['LGF0010038']));
            $obtenerInstitucion = $obtenerInstitucion[0]['LGF0270028'];
        }

        $this->temp['usuario'] = $user;
        $this->temp['nombre'] = $name;
        $this->temp['email'] = $email;
        $this->temp['institucion'] = $obtenerInstitucion;
        $this->temp['encabezado'] = self::encabezado("Perfil del usuario");
        $this->render();
    }

    public function reports($nivel, $id)
    {
        $niveles = (new Nivel())->obtenNivel((object)array("LGF0140001" => $nivel));
        $this->temp['color'] = $niveles[0]['LGF0140005'];
        $this->temp['nivel'] = $nivel;
        $this->temp['leccion'] = (new Administrador())->obtenerMaxLecciones();
        $this->temp['encabezado'] = self::encabezado("Evaluaciones del alumno");
        $this->render();
    }

    public function guides($id, $grupo = "")
    {
        $tutor = false;
        $alumno = 0;
        if (!is_numeric($grupo)) {
            for ($i = 0; $i < strlen($grupo); $i++) {
                if (!is_numeric($grupo[$i])) {
                    $tutor = true;
                    $aux = explode($grupo[$i], $grupo);
                    $alumno = $aux[0];
                }
            }
        }

        $this->temp['modulo'] = $id;
        $modulo = (new Administrador())->modulos($id);
        $niveles = (new Nivel())->obtenNivel((object)array("LGF0140001" => $modulo[0]['nivel']));
        if ($grupo == "") {
            $this->temp['color'] = $niveles[0]['LGF0140005'];
            $this->temp['color1'] = "fff";
            $this->temp['nivel'] = $id;
            $titulo = $this->convertir_modulo_grado($id) . " - Guías de Estudio";
        } else {
            if (!$tutor) {
                $namegrupo = (new Administrador())->grupos($grupo);
                $this->temp['color'] = "0a71b7";
                $this->temp['color1'] = "fff";
                $this->temp['nivel'] = $id; // modulo
                $titulo = "Módulo de Administración del Docente";
                $this->temp['seccion_nombre'] = $namegrupo[0]['LGF0290002'] . " - " . $this->convertir_modulo_grado($id) . " - Guías de Estudio";
                $this->temp['origen'] = "docente";
            } else {
                $user = (new Usuarios())->obtenUsuario((object)array(
                    "LGF0010001" => $alumno
                ));
                $nombre = $user[0]['LGF0010002'] . " " . $user[0]['LGF0010003'] . " " . $user[0]['LGF0010004'];
                $this->temp['color'] = "0a71b7";
                $this->temp['color1'] = "fff";
                $this->temp['nivel'] = $id; // modulo
                $titulo = "Módulo de Administración del Tutor";
                $this->temp['seccion_nombre'] = $nombre . " - " . $this->convertir_modulo_grado($id) . " - Guías de Estudio";
                $this->temp['origen'] = "tutor";
            }
        }
        $this->temp['encabezado'] = self::encabezado($titulo);
        $this->render();
    }

    public function means($id, $grupo = "")
    {
        $tutor = false;
        $alumno = 0;
        if (!is_numeric($grupo)) {
            for ($i = 0; $i < strlen($grupo); $i++) {
                if (!is_numeric($grupo[$i])) {
                    $tutor = true;
                    $aux = explode($grupo[$i], $grupo);
                    $alumno = $aux[0];
                }
            }
        }

        $modulo = (new Administrador())->modulos($id);
        $titulo = $modulo[0]['nombre'];

        $niveles = (new Nivel())->obtenNivel((object)array("LGF0140001" => $modulo[0]['nivel']));
        if ($grupo == "") {
            $this->temp['color'] = $niveles[0]['LGF0140005'];
            $this->temp['nivel'] = $id;
            $this->temp['color1'] = "fff";
            $titulo = $this->convertir_modulo_grado($id) . " - Recursos Descargables";
        } else {
            if (!$tutor) {
                $namegrupo = (new Administrador())->grupos($grupo);
                $this->temp['color'] = "0a71b7";
                $this->temp['color1'] = "fff";
                $this->temp['nivel'] = $id; // modulo
                $titulo = "Módulo de Administración del Docente";
                $this->temp['seccion_nombre'] = $namegrupo[0]['LGF0290002'] . " - " . $this->convertir_modulo_grado($id) . " - Recursos Descargables";
                $this->temp['origen'] = "docente";
            } else {
                $user = (new Usuarios())->obtenUsuario((object)array(
                    "LGF0010001" => $alumno
                ));
                $nombre = $user[0]['LGF0010002'] . " " . $user[0]['LGF0010003'] . " " . $user[0]['LGF0010004'];
                $this->temp['color'] = "0a71b7";
                $this->temp['color1'] = "fff";
                $this->temp['nivel'] = $id; // modulo
                $titulo = "Módulo de Administración del Tutor";
                $this->temp['seccion_nombre'] = $nombre . " - " . $this->convertir_modulo_grado($id) . " - Recursos Descargables";
                $this->temp['origen'] = "tutor";
            }
        }
        $this->temp['encabezado'] = self::encabezado($titulo);
        #var_dump($this->temp);
        $this->render();
    }

    /**
     * Docente
     */

    public function teacher()
    {
        $institucion = (new Usuarios())->obtenUsuario((object)array(
            'LGF0010001' => $_SESSION['idUsuario']
        ))[0]['LGF0010038'];

        $this->temp['modulos_disponibles'] = (new Modulo())->obtenerModulosDeInstitucion($institucion);



        if ($_POST) {
            if ($_POST['numero'] != '' && $_POST['letra'] != '' && $_POST['version'] != '' && $_POST['modulo'] != '') {

                $nombreGrupo = "Grupo " . $_POST['numero'] . "" . $_POST['letra'] . "." . $_POST['version'];
                $modulo = $_POST['modulo'];

                $creargrupo = (new Grupos())->addGrupo((object)array(
                    'LGF0290002' => $nombreGrupo,
                    'LGF0290003' => 1,
                    'LGF0290004' => $institucion,
                    'LGF0290005' => $modulo,
                    'LGF0290006' => $_SESSION['idUsuario']
                ));

                if ($creargrupo) {
                    $_SESSION['status'] = "<b style='color: green'>Grupo creado correctamente</b>";
                }
            } else {
                $_SESSION['status'] = "<b style='color: red;'>Datos faltantes para la creacion del grupo</b>";
            }
            $this->Redirect('home', 'teacher');
        }

        $this->render();
    }

    public function results($grupo, $nivel)
    {
        // $niveles = (new Nivel())->obtenNivel((object) array("LGF0140001" => $nivel));

        $tutor = false;
        $alumno = 0;
        $origen = "";
        if (!is_numeric($nivel)) {
            for ($i = 0; $i < strlen($nivel); $i++) {
                if (!is_numeric($nivel[$i])) {
                    $origen = $nivel[$i];
                    $tutor = true;
                    $aux = explode($nivel[$i], $nivel);
                    $alumno = $aux[0];
                }
            }
        }
        // echo $origen;

        $namegrupo = (new Administrador())->grupos($grupo);
        $grado = $this->convertir_modulo_grado($namegrupo[0]['LGF0290005']);
        if ($origen == "A" || $origen == "" || $origen == "C") {
            $this->temp['grupoid'] = $grupo;
            $this->temp['grupo'] = $namegrupo[0]['LGF0290002'] . " - " . $grado;
            $this->temp['titulo'] = "Módulo del Administrador Learnglish";
        } else if ($origen == "D") {
            // $this->temp['nivel'] = $niveles[0]['LGF0140002'];
            $this->temp['grupoid'] = $grupo;
            $this->temp['grupo'] = $namegrupo[0]['LGF0290002'] . " - " . $grado;
            $this->temp['titulo'] = "Módulo de Administración del Docente";
        } else if ($origen == "T") {
            $users = (new Usuarios())->obtenUsuario((object)array("LGF0010001" => $alumno));
            $nombre = $users[0]['LGF0010002'] . " " . $users[0]['LGF0010003'] . " " . $users[0]['LGF0010004'];
            $this->temp['grupoid'] = $grupo . "t" . $alumno;
            $this->temp['grupo'] = $namegrupo[0]['LGF0290002'] . " - " . $grado;
            $this->temp['titulo'] = "Módulo de Administración del Tutor";
        }
        // $this->temp['origen'] = (($tutor) ? 1 : 0);
        $this->temp['origen'] = $origen;
        $this->temp['leccion'] = (new Administrador())->obtenerMaxLecciones();
        $this->temp['encabezado'] = $this->encabezado("Módulo de Administrador Learnglish");
        /*echo "<pre>";
			print_r($this->temp);
			echo "</pre>";*/
        $this->render();
    }

    /**
     * Tutor
     */

    public function tutor()
    {
        if ($_SESSION['perfil'] == 7) {
            $relacion = (new Administrador())->relacion_tutor_alumno($_SESSION['idUsuario']);
            foreach ($relacion as $value) {
                $imagen = CONTEXT . "portal/IMG/perfil/" . $value['img'];
                if (file_exists($imagen)) {
                    $img = $imagen;
                } else {
                    if ($value['genero'] == "M") {
                        $genero = "N";
                    } else if ($value['genero'] == "H") {
                        $genero = "H";
                    } else {
                        $genero = "";
                    }

                    if (!empty($genero)) {
                        if ($value['nivel'] == 1) {
                            $imagen = CONTEXT . "portal/IMG/preescolar" . $value['genero'] . ".png";
                        } else if ($value['nivel'] == 2) {
                            $grado = $genero . ($value['grado'] - 1);
                            $imagen = CONTEXT . "portal/IMG/PRIMA_" . $grado . ".png";
                        } else if ($value['nivel'] == 3) {
                            if ($value['grado'] == 8) {
                                $grado = $genero . "1";
                            } else if ($value['grado'] == 9) {
                                $grado = $genero . "2";
                            } else if ($value['grado'] == 10) {
                                $grado = $genero . "3";
                            }
                            $imagen = CONTEXT . "portal/IMG/SECU_" . $grado . ".png";
                        }
                    } else {
                        $imagen = CONTEXT . "portal/IMG/SECU_H1.png";
                    }
                }
                $contenido[] = array(
                    "id" => $value['id'],
                    "alumno" => $value['alumno'],
                    "grado" => $this->convertir_modulo_grado($value['grado']),
                    "leccion" => $value['grado'],
                    "color" => $value['color'],
                    "nivel" => $value['grado'],
                    "nivelid" => $value['nivel'],
                    "grupo" => $value['grupo'],
                    "imagen" => $imagen
                );
            }
            $this->temp['relacion'] = $contenido;
            $this->temp['titulo'] = "Módulo de Administración del Tutor";
            $this->temp['seccion_nombre'] = "Estudiantes vinculados a la cuenta del tutor";
            $this->render();
        } else {
            $this->index();
        }
    }

    public function encabezado($titulo)
    {
        $encabezado = '<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<img src="' . IMG . 'logo_color.png" alt="learnglish icon" class="mx-auto my-2" id="icon_img">
				</div>
				<div class="col-lg-7 col-md-7 col-sm-7">
					<div class="relleno">
						<span>' . $titulo . '</span>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2">
					<div id="perfil_usuario"><img src="' . $this->temp['img_usuario'] . '" class="imagen"><span class="nombreAvatar">' . $_SESSION['nombre'] . '</span></div>
				</div>
			</div>
			<br>';
        return $encabezado;
    }

    public function obtenerURL($niveles, $seccion, $color = "")
    {
        $niveles = trim($niveles, ",");
        if ($seccion == 0) { // Menu principal
            $aux = explode(",", $niveles);
            $url1 = "";
            $url2 = "";
            $url3 = "";
            // echo "Hola";
            foreach ($aux as $value) {
                switch ($value) {
                    case '1':
                        $url1 = CONTEXT . "Home/preschool/";
                        break;
                    case '2':
                        $url2 = CONTEXT . "Home/primary/";
                        break;
                    case '3':
                        $url3 = CONTEXT . "Home/secundary/";
                        break;
                    case 'A':
                        $url1 = CONTEXT . "Home/preschool/";
                        $url2 = CONTEXT . "Home/primary/";
                        $url3 = CONTEXT . "Home/secundary/";
                        break;
                    default:
                        $url1 = "#";
                        $url2 = "#";
                        $url3 = "#";
                        break;
                }
            }

            return array(
                $url1, $url2, $url3
            );
        } else if ($seccion == 1) { // Menu de primaria
            $usuario = $_SESSION['idUsuario'];
            $aux = explode(",", $niveles);
            $color = $color;
            $array = array();
            foreach ($aux as $value) {
                switch ($value) {
                    case '2':
                        $fondo2 = "#" . $color;
                        $url_2 = CONTEXT . "Home/lessons/2/";
                        $urlg_2 = CONTEXT . "Home/guides/2/";
                        $urlr_2 = CONTEXT . "Home/means/2/";
                        $urlRe_2 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case '3':
                        $fondo3 = "#" . $color;
                        $url_3 = CONTEXT . "Home/lessons/3/";
                        $urlg_3 = CONTEXT . "Home/guides/3/";
                        $urlr_3 = CONTEXT . "Home/means/3/";
                        $urlRe_3 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case '4':
                        $fondo4 = "#" . $color;
                        $url_4 = CONTEXT . "Home/lessons/4/";
                        $urlg_4 = CONTEXT . "Home/guides/4/";
                        $urlr_4 = CONTEXT . "Home/means/4/";
                        $urlRe_4 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case '5':
                        $fondo5 = "#" . $color;
                        $url_5 = CONTEXT . "Home/lessons/5/";
                        $urlg_5 = CONTEXT . "Home/guides/5/";
                        $urlr_5 = CONTEXT . "Home/means/5/";
                        $urlRe_5 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case '6':
                        $fondo6 = "#" . $color;
                        $url_6 = CONTEXT . "Home/lessons/6/";
                        $urlg_6 = CONTEXT . "Home/guides/6/";
                        $urlr_6 = CONTEXT . "Home/means/6/";
                        $urlRe_6 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case '7':
                        $fondo7 = "#" . $color;
                        $url_7 = CONTEXT . "Home/lessons/7/";
                        $urlg_7 = CONTEXT . "Home/guides/7/";
                        $urlr_7 = CONTEXT . "Home/means/7/";
                        $urlRe_7 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                    case 'A':
                        $fondo2 = "#" . $color;
                        $url_2 = CONTEXT . "Home/lessons/2/";
                        $urlg_2 = CONTEXT . "Home/guides/2/";
                        $urlr_2 = CONTEXT . "Home/means/2/";
                        $urlRe_2 = CONTEXT . "Home/reports/2/$usuario";

                        $fondo3 = "#" . $color;
                        $url_3 = CONTEXT . "Home/lessons/3/";
                        $urlg_3 = CONTEXT . "Home/guides/3/";
                        $urlr_3 = CONTEXT . "Home/means/3/";
                        $urlRe_3 = CONTEXT . "Home/reports/2/$usuario";

                        $fondo4 = "#" . $color;
                        $url_4 = CONTEXT . "Home/lessons/4/";
                        $urlg_4 = CONTEXT . "Home/guides/4/";
                        $urlr_4 = CONTEXT . "Home/means/4/";
                        $urlRe_4 = CONTEXT . "Home/reports/2/$usuario";

                        $fondo5 = "#" . $color;
                        $url_5 = CONTEXT . "Home/lessons/5/";
                        $urlg_5 = CONTEXT . "Home/guides/5/";
                        $urlr_5 = CONTEXT . "Home/means/5/";
                        $urlRe_5 = CONTEXT . "Home/reports/2/$usuario";

                        $fondo6 = "#" . $color;
                        $url_6 = CONTEXT . "Home/lessons/6/";
                        $urlg_6 = CONTEXT . "Home/guides/6/";
                        $urlr_6 = CONTEXT . "Home/means/6/";
                        $urlRe_6 = CONTEXT . "Home/reports/2/$usuario";

                        $fondo7 = "#" . $color;
                        $url_7 = CONTEXT . "Home/lessons/7/";
                        $urlg_7 = CONTEXT . "Home/guides/7/";
                        $urlr_7 = CONTEXT . "Home/means/7/";
                        $urlRe_7 = CONTEXT . "Home/reports/2/$usuario";
                        break;
                }
            }

            $array = array(
                "fondo2" => $fondo2,
                "fondo3" => $fondo3,
                "fondo4" => $fondo4,
                "fondo5" => $fondo5,
                "fondo6" => $fondo6,
                "fondo7" => $fondo7,
                "url_2" => $url_2,
                "url_3" => $url_3,
                "url_4" => $url_4,
                "url_5" => $url_5,
                "url_6" => $url_6,
                "url_7" => $url_7,
                "urlg_2" => $urlg_2,
                "urlg_3" => $urlg_3,
                "urlg_4" => $urlg_4,
                "urlg_5" => $urlg_5,
                "urlg_6" => $urlg_6,
                "urlg_7" => $urlg_7,
                "urlr_2" => $urlr_2,
                "urlr_3" => $urlr_3,
                "urlr_4" => $urlr_4,
                "urlr_5" => $urlr_5,
                "urlr_6" => $urlr_6,
                "urlr_7" => $urlr_7,
                "urlRe_2" => $urlRe_2,
                "urlRe_3" => $urlRe_3,
                "urlRe_4" => $urlRe_4,
                "urlRe_5" => $urlRe_5,
                "urlRe_6" => $urlRe_6,
                "urlRe_7" => $urlRe_7
            );
            return $array;
        } else if ($seccion == 2) { // Menu de secundaria
            $aux = explode(",", $niveles);
            $usuario = $_SESSION['idUsuario'];
            $color = $color;
            $array = array();
            foreach ($aux as $value) {
                switch ($value) {
                    case '8':
                        $fondo8 = "#" . $color;
                        $url_8 = CONTEXT . "Home/lessons/8/";
                        $urlg_8 = CONTEXT . "Home/guides/8/";
                        $urlr_8 = CONTEXT . "Home/means/8/";
                        $urlRe_8 = CONTEXT . "Home/reports/3/$usuario";
                        break;
                    case '9':
                        $fondo9 = "#" . $color;
                        $url_9 = CONTEXT . "Home/lessons/9/";
                        $urlg_9 = CONTEXT . "Home/guides/9/";
                        $urlr_9 = CONTEXT . "Home/means/9/";
                        $urlRe_9 = CONTEXT . "Home/reports/3/$usuario";
                        break;
                    case '10':
                        $fondo10 = "#" . $color;
                        $url_10 = CONTEXT . "Home/lessons/10/";
                        $urlg_10 = CONTEXT . "Home/guides/10/";
                        $urlr_10 = CONTEXT . "Home/means/10/";
                        $urlRe_10 = CONTEXT . "Home/reports/3/$usuario";
                        break;
                    case 'A':
                        $fondo8 = "#" . $color;
                        $fondo9 = "#" . $color;
                        $fondo10 = "#" . $color;
                        $url_8 = CONTEXT . "Home/lessons/8/";
                        $url_9 = CONTEXT . "Home/lessons/9/";
                        $url_10 = CONTEXT . "Home/lessons/10/";

                        $urlg_8 = CONTEXT . "Home/guides/8/";
                        $urlg_9 = CONTEXT . "Home/guides/9/";
                        $urlg_10 = CONTEXT . "Home/guides/10/";

                        $urlr_8 = CONTEXT . "Home/means/8/";
                        $urlr_9 = CONTEXT . "Home/means/9/";
                        $urlr_10 = CONTEXT . "Home/means/10/";

                        $urlRe_8 = CONTEXT . "Home/reports/3/$usuario";
                        $urlRe_9 = CONTEXT . "Home/reports/3/$usuario";
                        $urlRe_10 = CONTEXT . "Home/reports/3/$usuario";
                        break;
                }
            }

            $array = array(
                "fondo8" => $fondo8,
                "fondo9" => $fondo9,
                "fondo10" => $fondo10,
                "url_8" => $url_8,
                "url_9" => $url_9,
                "url_10" => $url_10,
                "urlg_8" => $urlg_8,
                "urlg_9" => $urlg_9,
                "urlg_10" => $urlg_10,
                "urlr_8" => $urlr_8,
                "urlr_9" => $urlr_9,
                "urlr_10" => $urlr_10,
                "urlRe_8" => $urlRe_8,
                "urlRe_9" => $urlRe_9,
                "urlRe_10" => $urlRe_10
            );
            return $array;
        } else if ($seccion == 3) { // Menu de preescolar
            $aux = explode(",", $niveles);
            $usuario = $_SESSION['idUsuario'];
            $color = $color;
            $array = array();
            foreach ($aux as $value) {
                switch ($value) { //Modulo
                    case '1':
                        $fondo1 = "#" . $color;
                        $url_1 = CONTEXT . "Home/lessons/1/";
                        $urlg_1 = CONTEXT . "Home/guides/1/";
                        $urlr_1 = CONTEXT . "Home/means/1/";
                        $urlRe_1 = CONTEXT . "Home/reports/1/$usuario";
                        break;
                    case 'A':
                        $fondo1 = "#" . $color;
                        $url_1 = CONTEXT . "Home/lessons/1/";

                        $urlg_1 = CONTEXT . "Home/guides/1/";

                        $urlr_1 = CONTEXT . "Home/means/1/";

                        $urlRe_1 = CONTEXT . "Home/reports/1/$usuario";
                        break;
                }
            }

            $array = array(
                "fondo1" => $fondo1,
                "url_1" => $url_1,
                "urlg_1" => $urlg_1,
                "urlr_1" => $urlr_1,
                "urlr_9" => $urlr_1,
                "urlRe_1" => $urlRe_1
            );
            return $array;
        }
    }

    public function obtenerImagen($niveles, $genero, $seccion)
    {
        $niveles = trim($niveles, ",");
        if ($seccion == 0) { // Menu prescolar
            $aux = explode(",", $niveles);
            $img1 = "";
            $img2 = "";
            $img3 = "";
            $img1_block = "";
            $img2_block = "";
            $img3_block = "";
            foreach ($aux as $value) {
                switch ($value) {
                    case '1':
                        if ($genero == "H") {
                            $img1 = "preescolarH.png";
                        } else if ($genero == "M") {
                            $img1 = "preescolarN.png";
                        }
                        break;
                    case '2':
                        if ($genero == "H") {
                            $img2 = "primariaH.png";
                        } else if ($genero == "M") {
                            $img2 = "primariaN.png";
                        }
                        break;
                    case '3':
                        if ($genero == "H") {
                            $img3 = "secundariaH.png";
                        } else if ($genero == "M") {
                            $img3 = "secundariaN.png";
                        }
                        break;
                    case 'A':
                        if ($genero == "H") {
                            $img1 = "preescolarH.png";
                            $img2 = "primariaH.png";
                            $img3 = "secundariaH.png";
                        } else if ($genero == "M") {
                            $img1 = "preescolarN.png";
                            $img2 = "primariaN.png";
                            $img3 = "secundariaN.png";
                        }
                        break;
                }
            }
            if ($img1 == "") {
                $img1 = $this->obtenerImagenLock(1, $genero, 0);
            }
            if ($img2 == "") {
                $img2 = $this->obtenerImagenLock(2, $genero, 0);
            }
            if ($img3 == "") {
                $img3 = $this->obtenerImagenLock(3, $genero, 0);
            }
            return array($img1, $img2, $img3);
        } else if ($seccion == 1) { // Menu de primaria
            $aux = explode(",", $niveles);
            foreach ($aux as $value) {
                switch ($value) {
                    case '2':
                        if ($genero == "H") {
                            $img1 = "PRIMA_H1.png";
                        } else if ($genero == "M") {
                            $img1 = "PRIMA_N1.png";
                        }
                        break;
                    case '3':
                        if ($genero == "H") {
                            $img2 = "PRIMA_H2.png";
                        } else if ($genero == "M") {
                            $img2 = "PRIMA_N2.png";
                        }
                        break;
                    case '4':
                        if ($genero == "H") {
                            $img3 = "PRIMA_H3.png";
                        } else if ($genero == "M") {
                            $img3 = "PRIMA_N3.png";
                        }
                        break;
                    case '5':
                        if ($genero == "H") {
                            $img4 = "PRIMA_H4.png";
                        } else if ($genero == "M") {
                            $img4 = "PRIMA_N4.png";
                        }
                        break;
                    case '6':
                        if ($genero == "H") {
                            $img5 = "PRIMA_H5.png";
                        } else if ($genero == "M") {
                            $img5 = "PRIMA_N5.png";
                        }
                        break;
                    case '7':
                        if ($genero == "H") {
                            $img6 = "PRIMA_H6.png";
                        } else if ($genero == "M") {
                            $img6 = "PRIMA_N6.png";
                        }
                        break;
                    case 'A':
                        if ($genero == "H") {
                            $img1 = "PRIMA_H1.png";
                        } else {
                            $img1 = "PRIMA_N1.png";
                        }
                        if ($genero == "H") {
                            $img2 = "PRIMA_H2.png";
                        } else {
                            $img2 = "PRIMA_N2.png";
                        }
                        if ($genero == "H") {
                            $img3 = "PRIMA_H3.png";
                        } else {
                            $img3 = "PRIMA_N3.png";
                        }
                        if ($genero == "H") {
                            $img4 = "PRIMA_H4.png";
                        } else {
                            $img4 = "PRIMA_N4.png";
                        }
                        if ($genero == "H") {
                            $img5 = "PRIMA_H5.png";
                        } else {
                            $img5 = "PRIMA_N5.png";
                        }
                        if ($genero == "H") {
                            $img6 = "PRIMA_H6.png";
                        } else {
                            $img6 = "PRIMA_N6.png";
                        }
                        break;
                }
            }
            if ($img1 == "") {
                $img1 = $this->obtenerImagenLock(2, $genero, $seccion);
            }
            if ($img2 == "") {
                $img2 = $this->obtenerImagenLock(3, $genero, $seccion);
            }
            if ($img3 == "") {
                $img3 = $this->obtenerImagenLock(4, $genero, $seccion);
            }
            if ($img4 == "") {
                $img4 = $this->obtenerImagenLock(5, $genero, $seccion);
            }
            if ($img5 == "") {
                $img5 = $this->obtenerImagenLock(6, $genero, $seccion);
            }
            if ($img6 == "") {
                $img6 = $this->obtenerImagenLock(7, $genero, $seccion);
            }
            return array($img1, $img2, $img3, $img4, $img5, $img6);
        } else if ($seccion == 2) { // Menu de secundaria
            $aux = explode(",", $niveles);
            foreach ($aux as $value) {
                switch ($value) {
                    case '8':
                        if ($genero == "H") {
                            $img1 = "SECU_H1.png";
                        } else if ($genero == "M") {
                            $img1 = "SECU_N1.png";
                        }
                        break;
                    case '9':
                        if ($genero == "H") {
                            $img2 = "SECU_H2.png";
                        } else if ($genero == "M") {
                            $img2 = "SECU_N2.png";
                        }
                        break;
                    case '10':
                        if ($genero == "H") {
                            $img3 = "SECU_H3.png";
                        } else if ($genero == "M") {
                            $img3 = "SECU_N3.png";
                        }
                        break;
                    case 'A':
                        if ($genero == "H") {
                            $img1 = "SECU_H1.png";
                            $img2 = "SECU_H2.png";
                            $img3 = "SECU_H3.png";
                        } else if ($genero == "M") {
                            $img1 = "SECU_N1.png";
                            $img2 = "SECU_N2.png";
                            $img3 = "SECU_N3.png";
                        }
                        break;
                }
            }
            if ($img1 == "") {
                $img1 = $this->obtenerImagenLock(8, $genero, $seccion);
            }
            if ($img2 == "") {
                $img2 = $this->obtenerImagenLock(9, $genero, $seccion);
            }
            if ($img3 == "") {
                $img3 = $this->obtenerImagenLock(10, $genero, $seccion);
            }
            return array($img1, $img2, $img3);
        }
    }

    public function obtenerImagenLock($nivel, $genero, $seccion)
    {
        $img = "";
        if ($seccion == 0) { // Menu principal
            switch ($nivel) {
                case '1':
                    if ($genero == "H") {
                        $img = "preescolarH_lock.png";
                    } else if ($genero == "M") {
                        $img = "preescolarN_lock.png";
                    }
                    break;
                case '2':
                    if ($genero == "H") {
                        $img = "primariaH_lock.png";
                    } else if ($genero == "M") {
                        $img = "primariaN_lock.png";
                    }
                    break;
                case '3':
                    if ($genero == "H") {
                        $img = "secundariaH_lock.png";
                    } else if ($genero == "M") {
                        $img = "secundariaN_lock.png";
                    }
                    break;
            }
        } else if ($seccion == 1) { // Menu de primaria
            switch ($nivel) {
                case '2':
                    if ($genero == "H") {
                        $img = "PRIMA_H1_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N1_lock.png";
                    }
                    break;
                case '3':
                    if ($genero == "H") {
                        $img = "PRIMA_H2_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N2_lock.png";
                    }
                    break;
                case '4':
                    if ($genero == "H") {
                        $img = "PRIMA_H3_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N3_lock.png";
                    }
                    break;
                case '5':
                    if ($genero == "H") {
                        $img = "PRIMA_H4_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N4_lock.png";
                    }
                    break;
                case '6':
                    if ($genero == "H") {
                        $img = "PRIMA_H5_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N5_lock.png";
                    }
                    break;
                case '7':
                    if ($genero == "H") {
                        $img = "PRIMA_H6_lock.png";
                    } else if ($genero == "M") {
                        $img = "PRIMA_N6_lock.png";
                    }
                    break;
            }
            // return $img;
        } else if ($seccion == 2) { // Menu de secundaria
            switch ($nivel) {
                case '8':
                    if ($genero == "H") {
                        $img = "SECU_H1_lock.png";
                    } else if ($genero == "M") {
                        $img = "SECU_N1_lock.png";
                    }
                    break;
                case '9':
                    if ($genero == "H") {
                        $img = "SECU_H2_lock.png";
                    } else if ($genero == "M") {
                        $img = "SECU_N2_lock.png";
                    }
                    break;
                case '10':
                    if ($genero == "H") {
                        $img = "SECU_H3_lock.png";
                    } else if ($genero == "M") {
                        $img = "SECU_N3_lock.png";
                    }
                    break;
            }
        }
        return $img;
    }

    public function validarBloqueo($modulos, $mActual)
    {
        $aux = explode(",", $modulos);
        $bloqueo = "loock";
        foreach ($aux as $value) {
            switch ($value) {
                case '1':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '2':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '3':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '4':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '5':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '6':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '7':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '8':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '9':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case '10':
                    if ($value == $mActual) {
                        $bloqueo = "";
                    }
                    break;
                case 'A':
                    $bloqueo = "";
                    break;
            }
        }
        return $bloqueo;
    }
}
