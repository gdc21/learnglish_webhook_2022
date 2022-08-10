<?php
require_once __DIR__ . '/../../persistencia/dao/DaoLG00001.php';
class Usuarios  extends UniversalDatabase {
	private $crud;
	/**
	 * Inicializacion del objeto
	 */
	public function __construct() {
		$this->crud = new DaoLG00001 ();
	}

    public function verificaSiHayEvaluacionDeAlumno($id_alumno){
        $this->query = "SELECT 
            LGF0420001 
            FROM lg00042 where  
            LGF0420002 = ".$id_alumno;

        return $this->doSelect();
    }


    public function obtenerDatosEvaluacion($id_evaluacion){
        $this->query = "SELECT 
            LGF0420003, LGF0420005, 
            CONCAT(LGF0010002,' ', LGF0010003, ' ', LGF0010004) AS nombre,
            LGF0270002 as institucion 
            FROM lg00042,lg00001, lg00027 where 
            LGF0010038 = LGF0270001 and 
            LGF0010001 = LGF0420002 and 
            LGF0420001 = ".$id_evaluacion;

        return $this->doSelect();
    }

    public function obtenerEstadisticasAlumnosInstitucion($trimestre){

        $trimestreMostrar = !empty($trimestre) ? ' AND LGF0420008 = '.$trimestre.' ':'';

        $this->query = "SELECT  LGF0270001 as id_institucion, 
                                LGF0270002 as nombre, 
                                count(LGF0420001) as alumnos 
                        FROM lg00042,lg00027,lg00001 
                        where 	LGF0270001=LGF0010038 and 
                                LGF0420002 = LGF0010001
                        ".$trimestreMostrar."
                        GROUP BY LGF0270002";

        return $this->doSelect();
    }

    public function obtenerNombreLeccion($id_leccion){
        $this->query = "SELECT LGF0160002  
            FROM lg00016 WHERE LGF0160001 = ".$id_leccion;

        return $this->doSelect();
    }

    public function obtenerEstadisticasEvaluacionesTrimestrales($trimestre){
        $trimestreMostrar = !empty($trimestre) ? ' AND LGF0420008 = '.$trimestre.' ':'';

        $this->query = "SELECT CONCAT(u.LGF0010002,' ', u.LGF0010003, ' ', u.LGF0010004) AS nombre,
            LGF0010021 as genero,
            LGF0270001 as id_institucion, 
            LGF0270002 as institucion, 
            LGF0420001, LGF0420003, LGF0420004, LGF0420005, LGF0420006, LGF0420007, LGF0420008, LGF0420009   
            FROM lg00001 as u, lg00042,lg00027 WHERE LGF0270001=LGF0010038 and u.LGF0010001 = LGF0420002
            ".$trimestreMostrar."
            ORDER BY LGF0270002";

        return $this->doSelect();
    }

    public function obtenerUsuariosDesdeInstitucion($nombre){
        $this->query = "SELECT LGF0010001 as id, 
            LOWER(LGF0010002) as nombre, 
            LOWER(LGF0010003) as ap1, 
            LOWER(LGF0010004) as ap2,
            LGF0010040 as curp,
            lg00014.LGF0140002 as nivel, 
            lg00015.LGF0150002 as modulo,
            LGF0270002 as escuela
            from lg00001, lg00027, lg00014, lg00015
            where   lg00014.LGF0140001=lg00001.LGF0010023 and 
                    lg00015.LGF0150001=lg00001.LGF0010024 and 
                    lg00027.LGF0270001=lg00001.LGF0010038 and 
                    concat(LGF0010002, ' ',  LGF0010003, ' ',LGF0010004) LIKE '%".$nombre."%' ORDER BY LGF0010002 LIMIT 10";
        return $this->doSelect();
    }

    public function obtenerLeccionesParaAlumnos($id_usuario){
        $this->query = "SELECT 
            LGF0010001,
            CONCAT(LGF0010002,' ', LGF0010003, ' ', LGF0010004) AS nombre,
            LGF0270002,  
            LGF0010024 
            from lg00001, lg00027 
            where LGF0270001=LGF0010038 and LGF0010001 = ".$id_usuario;
        return $this->doSelect();
    }
    public function obtener10preguntasDeLeccion($leccion){
        $this->query = "SELECT 
            LGF0200001 as id, LGF0200002, LGF0200003, LGF0200004, LGF0200010 as tipoPregunta
            from lg00020,lg00019 where lg00020.LGF0200009=lg00019.LGF0190001 
                                and lg00019.LGF0190007 = ".$leccion." LIMIT 10";
        return $this->doSelect();
    }
    public function obtenerRespuestasPregunta($pregunta){
        $this->query ="SELECT * from lg00021 WHERE LGF0210002 in (".join(',', $pregunta).")";
        return $this->doSelect();
    }
	
	/**
	 * Metodo para actualizar usuario
	 * 
	 * @param entity_lg00001 $lg00001a:
	 *        	informacion a actualizar
	 *        	entity_lg00001 $lg00001b: condion para afectar a determinados registros
	 * @return true: agregado|false: error
	 *        
	 */
	public function actualizarUsuario($lg00001a, $lg00001b) {
		return $this->crud->update ( $lg00001a, $lg00001b );
	}
	
	/**
	 * Metodo para agregar un nuevo usuario
	 * 
	 * @param entity_lg00001 $lg00001:
	 *        	informacion a almacenar
	 * @return true: agregado|false: error
	 *        
	 */
	public function agregarUsuario($lg00001) {
		return $this->crud->create ( $lg00001 );
	}
	
	/**
	 * Metodo para obtener usuarios
	 * 
	 * @param entity_lg00001 $lg00001:
	 *        	condion para afectar a determinado registro
	 * @return true: agregado|false: error
	 *        
	 */
	public function obtenUsuario($lg00001 = "", $total = false) {
		return $this->crud->read ( $lg00001, $total );
	}
	
	/**
	 * Metodo para obtener usuarios para paginacion
	 * 
	 * @param entity_lg00001 $lg00001:
	 *        	condion para afectar a determinado registro
	 *        	limit: array con llaves start y finish, indican inicio y fin del limite respectivamente
	 * @return arreglo con registros|false: error
	 *        
	 */
	public function obtenContenidoPaginacion($lg00001 = "", $limit) {
		return $this->crud->getToPagination ( $lg00001, $limit );
	}
	
	/**
	 * Metodo para eliminar usuario
	 * entity_lg00001 $lg00001: condion para afectar a determinado registro
	 * 
	 * @return true: agregado|false: error
	 *        
	 */
	public function eliminaUsuario($lg00001) {
		return $this->crud->delete ( $lg00001 );
	}
	
	/**
	 * Metodo para realizar login
	 * 
	 * @return 0: Usuario no encontrado
	 *         1: Password incorrecto
	 *         2: Usuarios inactivo
	 */
	public function validarUsuario($lg00001) {
		$user = ( object ) ["LGF0010005" => $lg00001->LGF0010005];

		if ($this->crud->read ( $user )) {
			$active = ( object ) [
				"LGF0010005" => $lg00001->LGF0010005,
				"LGF0010008" => $lg00001->LGF0010008 
			];

			if ($this->crud->read ( $active )) {
				if ($res = $this->crud->read ( $lg00001 )) {
					return $res;
				} else {
					return 1;
				}
			} else {
				return 2;
			}
		} else {
			return 0;
		}
	}
}