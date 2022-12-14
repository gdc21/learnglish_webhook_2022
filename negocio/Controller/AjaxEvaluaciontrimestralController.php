<?php
class AjaxEvaluaciontrimestralController extends Controller_Learnglish {

    private $intentosPermitidos = 2;
    private $trimestre;

	public function __construct() {
		parent::__construct ();
        $datos = (new Accesomodulos())->obtenAccesomodulos((object)array(
            "LGF0430002" => "ExamenTrimestral"
        ));
        $trimestre_db = explode(',', $datos[0]['LGF0430008']);
        $this->trimestre = $trimestre_db[1];
	}

    public function obtenerleccionesalumnodesdeid(){
        $id = $_POST['id'];
        $modulo = (new Usuarios())->obtenerLeccionesParaAlumnos($id);
        $_SESSION['alumnoQueRealizaEvaluacion'] = $modulo[0]['LGF0010001'];
        $_SESSION['nombreAlumnoQueRealizaEvaluacion'] = $modulo[0]['nombre'];
        $_SESSION['institucionAlumno'] = $modulo[0]['LGF0270002'];

        $lecciones = (new Administrador())->mostrarLecciones($leccion = $modulo[0]['LGF0010024']);
        $intentos  = (new Administrador())->verificarNumeroDeIntentos($id, $this->trimestre);

        $object = array (
            'data'                => $lecciones,
            'puedeRealizarExamen' => $intentos[0]['LGF0420009'] > $this->intentosPermitidos ? 0:1
        );

        $this->renderJSON ( $object );

    }

    public function obtenerusuariosbusquedaevaluaciontrimestral(){
        $nombre = $_POST['nombre'];
        $alumnos = (new Usuarios())->obtenerUsuariosDesdeInstitucion($nombre);

        $object = array (
            'data' => $alumnos
        );

        $this->renderJSON ( $object );
    }



}
?>