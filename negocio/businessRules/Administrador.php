<?php
	class Administrador extends UniversalDatabase {


        public function actualizarAlumnosGrupoDocente($curps, $grupo, $docente, $institucion){

            /*Si el docente viene vacio significa que no se actualizara el docente actual*/
            /*LGF0010038 campo de institucion, se actualizara el alumno a la fuerza 173 don jon de escandon*/
            if($docente != ''){
                $this->query = "UPDATE lg00029 SET LGF0290006 = ".$docente." WHERE LGF0290001 = ".$grupo;
                $accion1 = $this->doSingleQuery();
            }else{
                $accion1 = 1;
            }

            if($accion1){
                $complemento = '';
                if($institucion != ''){
                    $complemento = " LGF0010038 = ".$institucion.", ";
                }

                $this->query = 'UPDATE lg00001 SET '.$complemento.' LGF0010039 = '.$grupo.' WHERE LGF0010040 IN ("'.implode('", "', $curps).'")';
                $accion2 = $this->doSingleQuery();
                if($accion2){
                    return true;
                }else{
                    $this->query = "UPDATE lg00029 SET LGF0290006 = NULL WHERE LGF0290001 = ".$grupo;
                    $this->doSingleQuery();

                    return false;
                }
            }else{
                return false;
            }
        }



        public function verificarCurpsAlumnosCargados($curps){
            $this->query = 'SELECT 
                CONCAT(LGF0010002," ",LGF0010003," ",LGF0010004) as nombre,
                LGF0010040 as curp
                FROM lg00001 
                WHERE LGF0010040 IN ("'.implode('", "', $curps).'")';
                #return $this->query;

            return $this->doSelect();
        }

        function existe_evaluacion_hecha($usuario, $leccion) {
            $this->query = "SELECT 
                LGF0220003 as calificacion,
                LGF0190002,
                LGF0190007 as id_leccion
                FROM lg00022, lg00019 
                WHERE LGF0220002 = $usuario AND 
                LGF0190007 = $leccion AND LGF0220006 = LGF0190001";
                #echo $this->query;

            return $this->doSelect();
        }


        public function obtenerResumenAvancesLecciones($user){
            $this->query = "SELECT 
                LGF0410002 AS NIVEL,
                LGF0410003 AS MODULO,    
                LGF0410004 AS LECCION, 
                LGF0160007 AS LECCION_ORDEN, 
                LGF0160002 AS NOMBRE_LECCION, 
                LGF0160003 AS IMAGEN,
                (
                    SELECT count(LGF0180004) 
                    FROM lg00018 
                    WHERE LGF0180005 
                    IN (3,5,7,9) 
                    AND LGF0180004 = LECCION 
                    AND LGF0180008 = 1 
                ) AS CANTIDAD_EXCERCISES,
                COUNT(LGF0410001) AS HECHOS,
                (
                    SELECT LGF0440004 FROM lg00044 WHERE LGF0440003 = LECCION AND LGF0440005 = 'speaking' AND LGF0440002 = $user LIMIT 1
                ) AS SPEAKING, 
                    (
                    SELECT LGF0440004 FROM lg00044 WHERE LGF0440003 = LECCION AND LGF0440005 = 'documento' AND LGF0440002 = $user LIMIT 1
                ) AS DOCUMENTO,
                (
                    SELECT LGF0220003 AS RESULT_EVALUACION 
                    FROM lg00022,lg00019
                    WHERE LGF0220006 = LGF0190001 AND LGF0190007 = LECCION AND LGF0220002 = $user
                ) AS RESULT_EVAL
                FROM lg00041,lg00016 
                WHERE LGF0410006 = $user 
                AND LGF0160001 = LGF0410004                
                GROUP BY LGF0410004
                ORDER BY LECCION";

            return $this->doSelect();
        }

        public function verificarNumeroDeIntentos($id, $trimestre){

            $trimestreMostrar = !empty($trimestre) ? ' AND LGF0420008 = '.$trimestre.' ':'';

            $this->query ="SELECT LGF0420009 FROM lg00042 WHERE 
                    LGF0420002 = '".$id."' ".$trimestreMostrar;
            return $this->doSelect ();
        }

        public function guardarEvaluacionTrimestral($data){

            $registro = $this->verificarUobtenerEvaluacionGuardada($data);
            if($registro){
                $this->query = "UPDATE lg00042 SET 
                        LGF0420003 = '". $data['lecciones']."',
                        LGF0420004 = '". $data['calificacion']."',
                        LGF0420005 = '". $data['resumen']."',
                        LGF0420006 = '". $data['acertadas']."',
                        LGF0420009 = '". ($registro[0]['LGF0420009'] + 1)."',
                        LGF0420008 = '". $data['trimestre']."' WHERE LGF0420002 = '".$data['id_usuario']."';
                    ";
                return $this->doSingleQuery();
            }else{

                $this->query = "INSERT INTO 
                    lg00042(
                            LGF0420002, LGF0420003, LGF0420004, LGF0420005, LGF0420006, LGF0420008, LGF0420009
                    )
                    VALUES (
                            '".$data['id_usuario']."', '".$data['lecciones']."', '".$data['calificacion']."', '".$data['resumen']."', '".$data['acertadas']."', '".$data['trimestre']."', '".$data['intentos']."'
                    )";
                return $this->doSingleQuery();
            }

        }

        public function verificarUobtenerEvaluacionGuardada($data){
            $this->query ="SELECT * FROM lg00042 WHERE 
                    LGF0420002 = '".$data['id_usuario']."' and LGF0420008 = '".$data['trimestre']."';";
            return $this->doSelect ();

        }


        public function obtenerRespuestas($idsRespuestas){
            $this->query = "SELECT * FROM lg00021 where LGF0210001 in (".$idsRespuestas.")";
            return $this->doSelect ();
        }


		public function lista_evaluaciones() {
			$this->query = "SELECT 	LGF0190001 AS Id,
				LGF0190002 AS Nombre,
				LGF0240002 As Version,
				(IF( LGF0190004 =1, 'Lección','Módulo' )) AS Tipo,
				LGF0190011 AS Preg_mostrar,
				(SELECT COUNT(LGF0200001) FROM lg00020 WHERE LGF0200009 = LGF0190001) AS Preguntas,
				LGF0140002 AS Nivel,
				LGF0150001 AS ID_modulo,
				LGF0150002 AS Modulo,
				(IF( LGF0190004 =1, LGF0160002,'' )) AS Leccion,
				LGF0190010 AS ID_estado,
				(IF( LGF0190010 =1, 'Activo','Inactivo' )) AS Estado
				FROM lg00019
				INNER JOIN lg00014 ON LGF0140001 = LGF0190005
				INNER JOIN lg00015 ON LGF0150001 = LGF0190006
				LEFT JOIN lg00016 ON LGF0160001 = LGF0190007
				INNER JOIN lg00024 ON LGF0240001 = LGF0190003;";
			return $this->doSelect ();
		}

		public function lista_preguntas($id) {
			$this->query = "SELECT LGF0200001 AS Id,
			LGF0200002 AS Pregunta,
			LGF0200003 AS Imagen,
			IF(LGF0200004=1,'Opción multiple','Verdadero/Falso') AS Tipo,
			LGF0200011 AS Correctas,
			LGF0200012 AS Incorrectas
			FROM lg00020 WHERE LGF0200009 = $id;";
			return $this->doSelect();
		}

		public function get_secciones($conditions, $soloActivas = 0) {
            $adicional = '';
            if($soloActivas){
                $adicional = " LGF0180008 = 1 AND ";
            }
			$this->query = "SELECT 
            LGF0180001 as id, 
            LGF0180006 AS orden,
			LGF0180002 AS ID_nivel,
			LGF0140002 AS nivel,
			LGF0180003 AS ID_modulo,
			LGF0150002 AS modulo,
			LGF0180004 AS ID_leccion,
			LGF0160002 AS leccion,
			LGF0180005 AS ID_seccion,
			LGF0170002 AS seccion,
			LGF0180008 AS estatus
			FROM lg00018
			INNER JOIN lg00014 ON LGF0140001 = LGF0180002
			INNER JOIN lg00015 ON LGF0150001 = LGF0180003
			INNER JOIN lg00016 ON LGF0160001 = LGF0180004
			INNER JOIN lg00017 ON LGF0170001 = LGF0180005
			WHERE ".$adicional." LGF0180002=" . $conditions ["nivel"] . " AND LGF0180003=" . $conditions ["modulo"] . " AND LGF0180004=" . $conditions ["leccion"] . " ORDER BY LGF0180006";
			return $this->doSelect ();
		}

        function navegacioncompleta(){
            $this->query = "SELECT * FROM lg00018 where LGF0180005 = 8 and LGF0180008 = 1";
            return $this->doSelect();
        }
		/**
		 * 
		 * @param unknown $nivel
		 * @param unknown $modulo
		 * @param unknown $leccion
		 * @param number $seccion
		 */
		function navegacion($nivel, $modulo, $leccion, $orden = 0, $solo_activas = 1) {
			$complement = '';
			$complement2 = '';
			if ($orden != 0) {
				$complement = ' AND LGF0180006 = ' . $orden;
			}
            if ($solo_activas) {
                $complement2 = ' LGF0180008 = 1 AND ';
            }
			$this->query = "SELECT LGF0180001 as id, LGF0180006 AS orden,
			LGF0180002 AS ID_nivel,
			LGF0140002 AS nivel,
			LGF0140005 AS color,
			LGF0180003 AS ID_modulo,
			LGF0150002 AS modulo,
			LGF0180004 AS ID_leccion,
			LGF0160002 AS leccion,
			LGF0160007 AS numero_leccion,
			LGF0160006 AS img_leccion,
			LGF0180005 AS ID_seccion,
			LGF0170003 AS img_seccion,
			LGF0170002 AS seccion,
			LGF0180006 AS orden,
			LGF0180007 AS directorio,
			LGF0180010 AS texto_es,
			LGF0180011 AS texto_en,
			LGF0180012 AS audio_es,
			LGF0180013 AS audio_en,
			LGF0180014 AS img_instrucciones
			FROM lg00018
			INNER JOIN lg00014 ON LGF0140001 = LGF0180002
			INNER JOIN lg00015 ON LGF0150001 = LGF0180003
			INNER JOIN lg00016 ON LGF0160001 = LGF0180004
			INNER JOIN lg00017 ON LGF0170001 = LGF0180005
			WHERE $complement2 LGF0180002 = $nivel AND LGF0180003 = $modulo AND LGF0180004 = $leccion $complement ORDER BY LGF0180006 ASC";
			// echo $this->query."<br>";
			return $this->doSelect ();
		}

		function navbar($lesson) {
			$this->query = "SELECT *,@rownum := @rownum + 1 AS indice FROM (
			SELECT LGF0180006 AS orden, LGF0180001 as ID_nav, LGF0180002 AS ID_nivel, LGF0140002 AS nivel, LGF0180003 AS ID_modulo,
			LGF0150002 AS modulo, LGF0180004 AS ID_leccion, LGF0160002 AS leccion, LGF0180005 AS ID_seccion, LGF0170002 AS seccion
			FROM lg00018 INNER JOIN lg00014 ON LGF0140001 = LGF0180002 INNER JOIN lg00015 ON LGF0150001 = LGF0180003
			INNER JOIN lg00016 ON LGF0160001 = LGF0180004 INNER JOIN lg00017 ON LGF0170001 = LGF0180005 WHERE LGF0180004=$lesson ORDER BY LGF0180004,LGF0180006) tmp,  (SELECT @rownum := 0) r";
			return $this->doSelect ();
		}

		function navegacionS($params) {
			echo $this->query = "SELECT LGF0180006 AS orden,
			LGF0180001 as ID_nav,
			LGF0180002 AS ID_nivel,
			LGF0140002 AS nivel,
			LGF0180003 AS ID_modulo,
			LGF0150002 AS modulo,
			LGF0180004 AS ID_leccion,
			LGF0160002 AS leccion,
			LGF0180005 AS ID_seccion,
			LGF0170002 AS seccion
			FROM lg00018
			INNER JOIN lg00014 ON LGF0140001 = LGF0180002
			INNER JOIN lg00015 ON LGF0150001 = LGF0180003
			INNER JOIN lg00016 ON LGF0160001 = LGF0180004
			INNER JOIN lg00017 ON LGF0170001 = LGF0180005
			WHERE $params";
			return $this->doSelect ();
		}
		
		function evaluacion($modulo,$leccion){
			//$this->hookup = UniversalConnect::doConnect ();
			$this->query = "SELECT LGF0190001 idprueba,LGF0190011 preguntas_mostrar,LGF0190002 prueba,LGF0200001 idpreg,LGF0200002 pregunta,LGF0200003 pregunta_img,
			LGF0200004=1 AS tipo,
			(SELECT LGF0210001  from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 0, 1) AS rid1,
			(SELECT LGF0210003 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 0, 1) AS resp1,
			(SELECT LGF0210004 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 0, 1) AS resp1_img,
			(SELECT LGF0210001  from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 1, 1) AS rid2,
			(SELECT LGF0210003 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 1, 1) AS resp2,
			(SELECT LGF0210004 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 1, 1) AS resp2_img,
			(SELECT LGF0210001  from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 2, 1) AS rid3,
			(SELECT LGF0210003 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 2, 1) AS resp3,
			(SELECT LGF0210004 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 2, 1) AS resp3_img,
			(SELECT LGF0210001  from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 3, 1) AS rid4,
			(SELECT LGF0210003 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 3, 1) AS resp4,
			(SELECT LGF0210004 from lg00021 WHERE LGF0210002=LGF0200001 LIMIT 3, 1) AS resp4_img,
			LGF0190006 modulo,LGF0190007 leccion
			FROM lg00019
			INNER JOIN lg00020 ON LGF0200009=LGF0190001
			WHERE LGF0190006=$modulo AND LGF0190007=$leccion AND LGF0190010 = 1
			ORDER BY rand()";
			//ORDER BY LIF0290001 ASC";
			return  $this->doSelect();
		}

		function existe_evaluacion($usuario, $evaluacion) {
			$this->query = "SELECT LGF0220001 as id, LGF0220002 as usuario, LGF0220003 as porcentaje, LGF0220005 as fecha, LGF0220006 as idEvaluacion, (SELECT LGF0190007 FROM lg00019 WHERE LGF0190001 = $evaluacion) as leccion
			FROM lg00022 WHERE LGF0220002 = $usuario AND LGF0220006 = $evaluacion ORDER BY LGF0220003 DESC LIMIT 1";
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function obtenerDetalleResultadoEvaluacion($id) {
			$this->query = "SELECT LGF0230001 as id FROM lg00023 WHERE LGF0230002 = ".$id;
			return $this->doSelect();
		}

		/**
		 * Devuelve los ultimos accesos al sistema del usuario
		 */
		public function ultimoAcceso($usuario) {
			// $this->query = "SELECT LGF0260003 FROM lg00026 WHERE LGF0260002 = $usuario ORDER BY LGF0260003 DESC LIMIT 2";
			$this->query = "SELECT *FROM lg00036 WHERE LGF0360003 = 1 AND LGF0360005 IS NOT NULL AND LGF0360002 = $usuario ORDER BY LGF0360001 DESC";
			return $this->doSelect();
		}

		/**
		 * Obtienen el registro de todas las instituciones registradas en el sistema
		 */
		public function lista_instituciones() {
			if ($_SESSION['perfil'] == 1) {
				$condicion = "";
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
				$result = $this->doSelect();
				for ($i=0; $i < count($result); $i++) { 
					if ($i == 0) {
						$condicion = "  AND t1.LGF0270001 = ".$result[$i]['LGF0270001'];
					} else {
						$condicion.= "  OR t1.LGF0270001 = ".$result[$i]['LGF0270001'];
					}
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = "  AND t1.LGF0270001 = ".$_SESSION['idUsuario'];
			}

			if( $condicion != "" || $_SESSION['perfil'] != 3 ) {
			$this->query = "SELECT t1.*, t2.LGF0280002 as cliente, t2.LGF0280017 as contacto,
				(
					SELECT COUNT(t3.LGF0010038) FROM lg00001 t3 WHERE t3.LGF0010038 = t1.LGF0270001 AND t3.LGF0010007 = 2
				) as total, (SELECT COUNT(t3.LGF0290001) FROM lg00029 t3 WHERE t3.LGF0290004 = t1.LGF0270001 AND t3.LGF0290003 = 1) as totalGrupos
			FROM lg00027 t1 LEFT JOIN lg00028 t2 ON t2.LGF0280001 = t1.LGF0270021
			WHERE t1.LGF0270012 = 1 " . $condicion . " ORDER BY LGF0270002 ASC";
			}
			
			// echo $this->query;
			return $this->doSelect();
		}

		public function licencias_permitidas($id) {
			$this->query = "SELECT (SELECT COUNT(t3.LGF0010038) FROM lg00001 t3 WHERE t3.LGF0010038 = t1.LGF0270001 AND t3.LGF0010007 = 2) as total
			FROM lg00027 t1 LEFT JOIN lg00028 t2 ON t2.LGF0280001 = t1.LGF0270021
			WHERE t1.LGF0270012 = 1 AND t1.LGF0270001 = ".$id." ORDER BY LGF0270002 ASC";
			return $this->doSelect();
		}

		public function informacion_institucion($id = "") {
			if ($id != "") {
				$condicion = "WHERE t1.LGF0270001 = ".$id;
			}
			$this->query = "SELECT t1.*,
				(
					SELECT
						GROUP_CONCAT(
							DISTINCT t2.LGF0300003
							ORDER BY
								t2.LGF0300001 ASC SEPARATOR ','
						)
					FROM
						lg00030 t2
					WHERE
						t2.LGF0300002 = t1.LGF0270001
				) AS modulos,
				(
					SELECT
						GROUP_CONCAT(
							DISTINCT t2.LGF0300001
							ORDER BY
								t2.LGF0300001 ASC SEPARATOR ','
						)
					FROM
						lg00030 t2
					WHERE
						t2.LGF0300002 = t1.LGF0270001
				) AS idmodulo
			FROM lg00027 t1 ".$condicion;
			return $this->doSelect();
		}

		/*public function lista_usuarios($id) {
			if ($_SESSION['perfil'] == 1) {
				if (empty($id)) {
					$condicion = "";
				} else {
					$condicion = "  AND t2.LGF0270001 = ".$id;
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = "  AND t2.LGF0270001 = ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				if (empty($id)) {
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = "  AND t2.LGF0270001 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t2.LGF0270001 = ".$result[$i]['LGF0270001'];
						}
					}
				} else {
					$condicion = "  AND t2.LGF0270001 = ".$id;
				}
			} else if ($_SESSION['perfil'] == 6) {
				$result = $this->obtener_docentes($_SESSION['idUsuario']);
				$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
			}
			$this->query = "SELECT CONCAT(t1.LGF0010002,' ',t1.LGF0010003,' ',t1.LGF0010004) as nombre, t1.LGF0010005, (SELECT LGF0330002 FROM lg00033 WHERE LGF0330003 = 2 AND LGF0330001 = LGF0010001) as pass, t1.LGF0010001, t1.LGF0010038, DATE_FORMAT(t1.LGF0010030, '%d %m %Y') as fecha, t2.LGF0270002 as institucion, (SELECT t3.LGF0290002 FROM lg00029 t3 WHERE t3.LGF0290001 = t1.LGF0010039) as grupo FROM lg00001 t1 LEFT JOIN lg00027 t2 ON t1.LGF0010038 = t2.LGF0270001 WHERE t1.LGF0010008 = 1".$condicion." ORDER BY t1.LGF0010030 DESC";
			// echo $this->query."\n";
			return $this->doSelect();
		}*/
		public function lista_usuarios($id) {
			$condicion = "";
			if ($_SESSION['perfil'] == 1) {
				if (empty($id)) {
					$condicion = "";
				} else {
					$condicion = "  AND t2.LGF0270001 = ".$id;
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = "  AND t2.LGF0270001 = ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				if (empty($id)) {
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = "  AND t2.LGF0270001 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t2.LGF0270001 = ".$result[$i]['LGF0270001'];
						}
					}
				} else {
					$condicion = "  AND t2.LGF0270001 = ".$id;
				}
			} else if ($_SESSION['perfil'] == 6) {
				$result = $this->obtener_docentes($_SESSION['idUsuario']);
				$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
			}

			if( $condicion != "" || $_SESSION['perfil'] != 3 ) {
			$this->query = "SELECT CONCAT(t1.LGF0010002,' ',t1.LGF0010003,' ',t1.LGF0010004) as nombre, t1.LGF0010005, t1.LGF0010001, 
				t1.LGF0010038, DATE_FORMAT(t1.LGF0010030, '%d %m %Y') as fecha, t2.LGF0270002 as institucion, (SELECT t3.LGF0290002 FROM lg00029 t3 WHERE t3.LGF0290001 = t1.LGF0010039) as grupo
				FROM lg00001 t1 LEFT JOIN lg00027 t2 ON t1.LGF0010038 = t2.LGF0270001 WHERE t1.LGF0010008 = 1 AND t1.LGF0010007 not in(1,5,7)" . $condicion . " ORDER BY t1.LGF0010030 DESC";
			}
			
			// echo $this->query;
			return $this->doSelect();
		}

		public function informacion_usuario($id) {
			if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
				if (is_numeric($id)) {
					$condicion = "LGF0010001 = ".$id;
				} else {
					$condicion = "LGF0010005 = '".$id."'";
				}
				$this->query = "SELECT *FROM lg00001 WHERE ".$condicion;
			} else if ($_SESSION['perfil'] == 4) {
				$this->query = "SELECT *FROM lg00027 WHERE LGF0270001 = $id";
			} else if ($_SESSION['perfil'] == 3) {
				$this->query = "SELECT *FROM lg00028 WHERE LGF0280001 = $id";
			}
			// echo $this->query;
			return $this->doSelect();
		}

		public function lista_perfiles() {
			if ($_SESSION['perfil'] != 1) {
				$complemento = "AND LGF0020001 in (2,6,7)";
			}
			$this->query = "SELECT *FROM lg00002 WHERE LGF0020003 = 1 ".$complemento;
			return $this->doSelect();
		}

		/**
		 * Clientes
		 */

		public function lista_clientes1() {
			$this->query = "SELECT t1.*, 
				(
					SELECT GROUP_CONCAT(
						DISTINCT t2.LGF0270002
							ORDER BY t2.LGF0270001 ASC
							SEPARATOR ','
						) FROM lg00027 t2 WHERE t2.LGF0270021 = t1.LGF0280001
				) as institucion,
				(
					SELECT GROUP_CONCAT(
						DISTINCT t2.LGF0270001
							ORDER BY t2.LGF0270001 ASC
							SEPARATOR ','
						) FROM lg00027 t2 WHERE t2.LGF0270021 = t1.LGF0280001
				) as ids
			FROM lg00028 t1 
			WHERE t1.LGF0280010 = 1 
			ORDER BY t1.LGF0280002 ASC";
			// echo $this->query."<br>";
			return $this->doSelect();
		}

		public function lista_clientes2($inicia, $termina) {
			$this->query = "SELECT t1.*, (SELECT GROUP_CONCAT(DISTINCT t2.LGF0270002 ORDER BY t2.LGF0270001 ASC SEPARATOR ',') FROM lg00027 t2 WHERE t2.LGF0270021 = t1.LGF0280001) as institucion, (SELECT GROUP_CONCAT(DISTINCT t2.LGF0270001 ORDER BY t2.LGF0270001 ASC SEPARATOR ',') FROM lg00027 t2 WHERE t2.LGF0270021 = t1.LGF0280001) as ids FROM lg00028 t1 WHERE t1.LGF0280010 = 1";
			// echo $this->query."<br>";
			return $this->doSelect();
		}

		public function lista_clientes() {
			if ($_SESSION['perfil'] == 1) {
				$condicion = "";
			} else if ($_SESSION['perfil'] == 3) {
				$condicion = " AND LGF0280001 = ".$_SESSION['idUsuario'];
			}
			$this->query = "SELECT *FROM lg00028 WHERE LGF0280010 = 1 ".$condicion." ORDER BY LGF0280002 ASC";
			return $this->doSelect();
		}

		public function obtener_modulos() {
			$this->query = "SELECT LGF0150001, LGF0150002, LGF0150004 FROM lg00015 ORDER BY LGF0150001 ASC";
			return $this->doSelect();
		}

		public function informacion_cliente($id) {
			$this->query = "SELECT *FROM lg00028 WHERE LGF0280001 = ".$id;
			return $this->doSelect();
		}

		public function obtenerTotalAlumnos($ids) {
			$this->query = "SELECT ( SELECT COUNT(t1.LGF0010038) FROM lg00001 t1 WHERE t1.LGF0010038 = t2.LGF0270001 AND t1.LGF0010007 = 2 ) as total 
			FROM lg00027 t2 WHERE t2.LGF0270001 = ".$ids;
			// echo $this->query.";<br>";
			return $this->doSelect();
		}

		public function obtener_grupos($id, $modulo = "") {
			if ($id != "") {
				$grupo = " AND t1.LGF0290004 = ".$id;
			}
			if ($modulo != "") {
				$complemento = " AND t1.LGF0290005 = ".$modulo;
			}
			$this->query = "SELECT 
                t1.LGF0290001, 
                t1.LGF0290002, 
                t2.LGF0270002, 
                t1.LGF0290005, 
                (SELECT COUNT(t3.LGF0010039) FROM lg00001 t3 WHERE t3.LGF0010039 = t1.LGF0290001) as totalAlumnos, 
                t3.LGF0150002 as nombre_modulo
                    FROM lg00029 t1 
                        JOIN lg00027 t2 
                        ON t2.LGF0270001 = t1.LGF0290004
                        JOIN lg00015 t3 
                        ON t3.LGF0150001 = LGF0290005 
			WHERE t1.LGF0290003 = 1 ".$grupo." ".$complemento." ORDER BY t1.LGF0290002 ASC";
			// echo $this->query."\n";
			return $this->doSelect(); 
		}

		public function informacionGrupo($id) {
			$this->query = "SELECT 
                LGF0290001 as numero, 
                LGF0290002 as nombre, 
                LGF0290006 as docente, 
                LGF0290005 AS modulo, 
                LGF0290007 AS ciclo,
                CONCAT(LGF0010002,' ', LGF0010003, ' ', LGF0010004) AS nombre_docente,
                (SELECT COUNT(LGF0010039) FROM lg00001 WHERE LGF0010039 = LGF0290001) as totalAlumnos 
                    FROM lg00029 left JOIN lg00001 ON LGF0290006 = LGF0010001
                    WHERE LGF0290003 = 1 AND LGF0290001 = ".$id;
			return $this->doSelect(); 
		}

		public function resultados_evaluaciones($opcion, $institucion) {
			if ($opcion == 3) { // Por usuarios
				// echo "usuario\n";
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion)) {
						$condicion = "";
					} else {
						$condicion = "AND  t1.LGF0010038 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = "AND  t1.LGF0010038 = ".$institucion;
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if (empty($institucion)) {
						$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
						$result = $this->doSelect();
						for ($i=0; $i < count($result); $i++) { 
							if ($i == 0) {
								$condicion = "AND  t1.LGF0010038 = ".$result[$i]['LGF0270001'];
							} else {
								$condicion.= "  OR t1.LGF0010038 = ".$result[$i]['LGF0270001'];
							}
						}
					} else {
						$condicion = "AND  t1.LGF0010038 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
				}
				for ($i=1; $i <= $lecciones; $i++) { 
					if ($i == 1) {
						$sub = "(SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t1.LGF0010001 AND LGF0220006 = (SELECT t2.LGF0190001 FROM lg00019 t2 WHERE t2.LGF0190006 = $modulo AND t2.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = $modulo))) AS promL$i";
					} else {
						$sub.= ",(SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t1.LGF0010001 AND LGF0220006 = (SELECT t2.LGF0190001 FROM lg00019 t2 WHERE t2.LGF0190006 = $modulo AND t2.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = $modulo))) AS promL$i";
					}
				}
				$this->query = "SELECT t1.LGF0010001 AS ID, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004,
					(SELECT t2.LGF0290002 FROM lg00029 t2 WHERE t2.LGF0290001 = t1.LGF0010039 ) AS grupo,
					(SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
					WHERE t3.LGF0220002 = t1.LGF0010001 AND t2.LGF0190006 = 1) AS gramatica1,
					(SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
					WHERE t3.LGF0220002 = t1.LGF0010001 AND t2.LGF0190006 = 2) AS gramatica2,
					(SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
					WHERE t3.LGF0220002 = t1.LGF0010001 AND t2.LGF0190006 = 3) AS servicios,
					(SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
					WHERE t3.LGF0220002 = t1.LGF0010001 AND t2.LGF0190006 = 4) AS profesional,
					(SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
					WHERE t3.LGF0220002 = t1.LGF0010001 AND t2.LGF0190006 = 5) AS turistica
					FROM lg00001 t1 WHERE t1.LGF0010007 = 2 $condicion ORDER BY t1.LGF0010002 ASC";
			} else if ($opcion == 2) { // Por grupo
				// echo "grupo\n";
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion)) {
						$condicion = "";
					} else {
						$condicion = " AND t2.LGF0010038 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t2.LGF0010038 = ".$institucion;
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if (empty($institucion)) {
						$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
						$result = $this->doSelect();
						for ($i=0; $i < count($result); $i++) { 
							if ($i == 0) {
								$condicion = " AND t2.LGF0010038 = ".$result[$i]['LGF0270001'];
							} else {
								$condicion.= "  OR t2.LGF0010038 = ".$result[$i]['LGF0270001'];
							}
						}
					} else {
						$condicion = " AND t2.LGF0010038 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND t1.LGF0290001 = ".$result[0]['idgrupo'];
				}

				$this->query = "SELECT t1.LGF0290002 AS nombre, COUNT(t2.LGF0010039) AS totalAlumnos, 
					(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 1))) / COUNT(t2.LGF0010038) AS gramatica1,
					(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 2))) / COUNT(t2.LGF0010038) AS gramatica2,
					(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 3))) / COUNT(t2.LGF0010038) AS servicios,
					(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 4))) / COUNT(t2.LGF0010038) AS profesional,
					(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 5))) / COUNT(t2.LGF0010038) AS turistica
					FROM lg00029 t1 INNER JOIN lg00001 t2 ON t2.LGF0010039 = t1.LGF0290001 WHERE t2.LGF0010007 = 2 $condicion GROUP BY t2.LGF0010039 ORDER BY t2.LGF0010002 ASC";
				// echo $this->query."\n";
			} else { // Por Institucion
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion)) {
						$condicion = "";
					} else {
						$condicion = " AND t1.LGF0270001 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t1.LGF0270001 = ".$institucion;
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if (empty($institucion)) {
						$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
						$result = $this->doSelect();
						for ($i=0; $i < count($result); $i++) { 
							if ($i == 0) {
								$condicion = " AND t1.LGF0270001 = ".$result[$i]['LGF0270001'];
							} else {
								$condicion.= "  OR t1.LGF0270001 = ".$result[$i]['LGF0270001'];
							}
						}
					} else {
						$condicion = " AND t1.LGF0270001 = ".$institucion;
					}
				}

				$this->query = "SELECT t1.LGF0270002 AS nombre, COUNT(t2.LGF0010038) AS totalAlumnos,
				(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 1))) / COUNT(t2.LGF0010038) AS gramatica1,
				(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 2))) / COUNT(t2.LGF0010038) AS gramatica2,
				(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 3))) / COUNT(t2.LGF0010038) AS servicios,
				(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 4))) / COUNT(t2.LGF0010038) AS profesional,
				(SUM((SELECT (SUM(t3.LGF0220003) / COUNT(t3.LGF0220006)) FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t3.LGF0220002 = t2.LGF0010001 AND t2.LGF0190006 = 5))) / COUNT(t2.LGF0010038) AS turistica FROM lg00027 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010038 = t1.LGF0270001 WHERE t2.LGF0010007 = 2 $condicion GROUP BY t1.LGF0270001 ORDER BY nombre ASC";
			}
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function resultados_evaluaciones_admin($lecciones, $opcion, $institucion, $cliente) {
			if ($opcion == 3) { // Por usuarios
				// echo "usuario\n";
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = "AND  t1.LGF0010038 = ".$institucion;
					} else {
						$condicion = "AND LGF0010038 IN (SELECT LGF0270001 FROM lg00028 LEFT JOIN lg00027 ON LGF0280001 = LGF0270021 WHERE LGF0280001 = $cliente)";
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = "AND  t1.LGF0010038 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if (!empty($institucion) && empty($cliente)) {
						$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
						$result = $this->doSelect();
						for ($i=0; $i < count($result); $i++) { 
							if ($i == 0) {
								$condicion = "AND  t1.LGF0010038 = ".$result[$i]['LGF0270001'];
							} else {
								$condicion.= "  OR t1.LGF0010038 = ".$result[$i]['LGF0270001'];
							}
						}
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = "AND LGF0010038 IN (SELECT LGF0270001 FROM lg00028 LEFT JOIN lg00027 ON LGF0280001 = LGF0270021 WHERE LGF0280001 = $cliente)";
					} else {
						$condicion = "AND  t1.LGF0010038 = ".$institucion;
					}
					if ($cliente == "" && $institucion == "") {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$ids = $result[$i]['LGF0270001'];
						} else {
							$ids.= ",".$result[$i]['LGF0270001'];
						}
						$condicion = "AND  t1.LGF0010038 in(".$ids.")";
					}
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
				}
				$this->query = "SELECT t1.LGF0010001 as id, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004, (SELECT LGF0290002 FROM lg00029 WHERE LGF0290001 = t1.LGF0010039) as grupo, (SELECT MAX(LGF0160007) FROM lg00016 WHERE LGF0160004 = t1.LGF0010024) AS numL, (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = t1.LGF0010024) AS modulo, (SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 = t1.LGF0010024) AS nivel FROM lg00001 t1 WHERE t1.LGF0010007 = 2 AND t1.LGF0010008 = 1 $condicion GROUP BY t1.LGF0010001";
			} else if ($opcion == 2) { // Por grupo
				// echo "grupo\n";
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = " AND t2.LGF0010038 = ".$institucion;
					} else {
						$condicion = " AND t1.LGF0290004 IN (SELECT LGF0270001 FROM lg00028 LEFT JOIN lg00027 ON LGF0280001 = LGF0270021 WHERE LGF0280001 = $cliente)";
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t2.LGF0010038 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($institucion == "") {
						$condicion = " AND LGF0290004 in (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'].")";
					} else if ($institucion != "") {
						$condicion = " AND LGF0290004 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND t1.LGF0290001 = ".$result[0]['idgrupo'];
				}

				$this->query = "SELECT t1.LGF0290001 as id, t1.LGF0290002 AS nombre, (SELECT MAX(LGF0160007) FROM lg00016 WHERE LGF0160004 = t2.LGF0010024) AS numL, (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = t2.LGF0010024) AS modulo, (SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 = t2.LGF0010024) AS nivel, (SELECT COUNT(*) FROM lg00001 al WHERE al.LGF0010039 = t1.LGF0290001 AND al.LGF0010007 = 2) AS totalAlumnos FROM lg00029 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010039 = t1.LGF0290001 WHERE t1.LGF0290003 = 1 $condicion GROUP BY t1.LGF0290001";
				// echo $this->query."\n";
			} else { // Por Institucion
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = " AND t1.LGF0270001 = ".$institucion;
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = " AND t1.LGF0270021 = ".$cliente;
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t1.LGF0270001 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($cliente == "" && $institucion == "") {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else if ($cliente == "" && $institucion != "") {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = " AND t1.LGF0270001 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t1.LGF0270001 = ".$result[$i]['LGF0270001'];
						}
					}
				}

				$this->query = "SELECT t1.LGF0270001 as id, t1.LGF0270002 AS nombre, (SELECT MAX(LGF0160007) FROM lg00016 WHERE LGF0160004 = t2.LGF0010024) AS numL, (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = t2.LGF0010024) AS modulo, (SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 = t2.LGF0010024) AS nivel, (SELECT COUNT(*) FROM lg00001 al WHERE al.LGF0010038 = t1.LGF0270001 AND al.LGF0010007 = 2) AS totalAlumnos FROM lg00027 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010038 = t1.LGF0270001 WHERE t1.LGF0270012 = 1 $condicion GROUP BY t1.LGF0270001;";
			}
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function obtener_promedios($i, $opcion, $buscar, $fecha) {
			if ($fecha != "" || $fecha != null) {
				$fecha_actual = date("Y-m-d");
				if (is_numeric($fecha)) {
					if ($fecha == 1) { // bimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 2 month"));
					} else if ($fecha == 2) { // trimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 3 month"));
					} else if ($fecha == 3) { // semestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 6 month"));
					}
				} else {
					$aux = explode("*", $fecha);
					$inicia = explode("/", $aux[0]);
					$termina = explode("/", $aux[1]);

					$fecha_mod = $inicia[2]."-".$inicia[1]."-".$inicia[0];
					$fecha_actual = $termina[2]."-".$termina[1]."-".$termina[0];
				}

				$periodo = "AND LGF0220005 >= '".$fecha_mod." 00:00:00' AND LGF0220005 <= '".$fecha_actual." 23:59:59'";
			}
			/*echo $periodo;
			die();*/
			$campo = ""; $tablas = "";
			switch ($opcion) {
				case '1': // Institucion
					$campo = "t1.LGF0270001 as id, ";
					$tablas = " FROM lg00027 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010038 = t1.LGF0270001 WHERE t1.LGF0270001 = ".$buscar." AND t2.LGF0010007 = 2;";
				break;
				case '2': // grupos
					$campo = "t1.LGF0290001 as id, ";
					$tablas = " FROM lg00029 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010039 = t1.LGF0290001 WHERE t1.LGF0290001 = ".$buscar." AND t2.LGF0010007 = 2;";
				break;
				case '3': // alumnos
					$campo = "t2.LGF0010001 as id, ";
					$tablas = " FROM lg00001 t2 WHERE t2.LGF0010001 = ".$buscar." AND t2.LGF0010007 = 2;";
				break;
			}
			$this->query = "SELECT $campo ";
				$this->query.= "SUM((SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t2.LGF0010001 AND LGF0220006 = (SELECT t4.LGF0190001 FROM lg00019 t4 WHERE t4.LGF0190006 = LGF0010024 AND t4.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = LGF0010024)) $periodo )) AS promL$i, count((SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t2.LGF0010001 AND LGF0220006 = (SELECT t4.LGF0190001 FROM lg00019 t4 WHERE t4.LGF0190006 = LGF0010024 AND t4.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = LGF0010024)) $periodo )) AS total";
			$this->query.=$tablas;
			// echo $this->query."\n\n";
			return $this->doSelect();
		}

		public function resultados_habilidades($opcion, $institucion, $cliente, $fecha) {
			if ($fecha != "" || $fecha != null) {
				$fecha_actual = date("Y-m-d");
				if (is_numeric($fecha)) {
					if ($fecha == 1) { // bimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 2 month"));
					} else if ($fecha == 2) { // trimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 3 month"));
					} else if ($fecha == 3) { // semestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 6 month"));
					}
				} else {
					$aux = explode("*", $fecha);
					$inicia = explode("/", $aux[0]);
					$termina = explode("/", $aux[1]);

					$fecha_mod = $inicia[2]."-".$inicia[1]."-".$inicia[0];
					$fecha_actual = $termina[2]."-".$termina[1]."-".$termina[0];
				}

				// $periodo = "AND LGF0220005 BETWEEN '".$fecha_mod." 00:00:00' AND '".$fecha_actual." 23:59:59'";
				$periodo = "AND LGF0220005 >= '".$fecha_mod." 00:00:00' AND LGF0220005 <= '".$fecha_actual." 23:59:59'";
			}
			if ($opcion == 3) { // por usuarios
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = " AND t1.LGF0010038 = ".$institucion;
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = " AND t1.LGF0010038 in (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = $cliente)";
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t1.LGF0010038 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($institucion == "") {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$ids = $result[$i]['LGF0270001'];
						} else {
							$ids.= ",".$result[$i]['LGF0270001'];
						}
					}
					$condicion = " AND t1.LGF0010038 in (".$ids.")";
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
				}
				// echo "Mi condicion\n\n".$condicion."\n\n";
				$this->query = "SELECT t1.LGF0010001 AS ID, t2.LGF0220001 AS evaluacion, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004,
				(SELECT t2.LGF0290002 FROM lg00029 t2 WHERE t2.LGF0290001 = t1.LGF0010039 ) AS grupo,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 2 $periodo) AS vocabulary,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 1 $periodo) AS grammar,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 3 $periodo) AS reading,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 4 $periodo) AS listening,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 5 $periodo) AS speaking
				FROM lg00001 t1 LEFT JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010007 = 2 AND t1.LGF0010008 = 1 $condicion GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010002 ASC";
				// echo $this->query;
			} else if ($opcion == 2) { // por grupo
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = "WHERE t1.LGF0290004 = ".$institucion;
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = "WHERE t1.LGF0290004 IN (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = $cliente)";
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = "AND t1.LGF0290004 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($institucion == "") {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$ids = $result[$i]['LGF0270001'];
						} else {
							$ids.= ",".$result[$i]['LGF0270001'];
						}
					}
					$condicion.= " AND t1.LGF0290004 in(".$ids.")";
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " t1.LGF0290001 = ".$result[0]['idgrupo'];
				}

				$this->query = "SELECT t1.LGF0290001 AS id_grupo, t1.LGF0290002 AS nombre, (SELECT count(*) FROM lg00001 u WHERE u.LGF0010039 = t1.LGF0290001 AND u.LGF0010007 = 2) as totalAlumnos,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF(t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010039 = t1.LGF0290001 AND t5.LGF0200010 = 2 $periodo) AS vocabulary,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF(t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010039 = t1.LGF0290001 AND t5.LGF0200010 = 1 $periodo) AS grammar,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF(t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010039 = t1.LGF0290001 AND t5.LGF0200010 = 3 $periodo) AS reading,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF(t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010039 = t1.LGF0290001 AND t5.LGF0200010 = 4 $periodo) AS listening,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF(t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010039 = t1.LGF0290001 AND t5.LGF0200010 = 5 $periodo) AS speaking
				FROM lg00029 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010039 = t1.LGF0290001 WHERE t1.LGF0290003 = 1 $condicion GROUP BY t1.LGF0290001 ORDER BY t2.LGF0010002 ASC";
			} else { // por institucion
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = " AND t1.LGF0270021 = ".$cliente;
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = " AND t1.LGF0270001 = ".$institucion;
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t1.LGF0270001 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($cliente == "" && empty($institucion)) {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else if ($cliente == "" && $institucion != "") {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = " AND t1.LGF0270001 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t1.LGF0270001 = ".$result[$i]['LGF0270001'];
						}
					}
				}
				$this->query = "SELECT t1.LGF0270001 AS instituciin_id, t1.LGF0270002 AS nombre, (SELECT COUNT(*) FROM lg00001 t WHERE t.LGF0010007 = 2 AND t.LGF0010038 = t1.LGF0270001) AS totalAlumnos,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002
						INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010038 = t1.LGF0270001 AND t5.LGF0200010 = 2 $periodo) AS vocabulary,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010038 = t1.LGF0270001 AND t5.LGF0200010 = 1 $periodo) AS grammar,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002
						INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010038 = t1.LGF0270001 AND t5.LGF0200010 = 3 $periodo) AS reading,
					(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t6.LGF0010038 = t1.LGF0270001 AND t5.LGF0200010 = 4 $periodo) AS listening
				FROM lg00027 t1 LEFT JOIN lg00001 t2 ON t2.LGF0010038 = t1.LGF0270001 WHERE t1.LGF0270012 = 1 $condicion GROUP BY t1.LGF0270001 ORDER BY nombre ASC";
			}
			// echo $this->query.";\n\n\n";
			return $this->doSelect();
		}

		public function obtener_lecciones() {
			$this->query = "SELECT t1.LGF0150001 as id, t1.LGF0150002 as modulo, COUNT(t2.LGF0160004) as totalmodulos FROM lg00015 t1 LEFT JOIN lg00016 t2 ON t2.LGF0160004 = t1.LGF0150001
			WHERE t2.LGF0160005 = 1 GROUP BY t1.LGF0150001";
			return $this->doSelect();
		}

		public function lecciones($id) {
			$this->query = "SELECT t1.LGF0160001 as ids FROM lg00016 t1 WHERE t1.LGF0160004 = ".$id;
			return $this->doSelect();
		}

		public function avance_modulo($id) {
			$this->query = "SELECT t3.LGF0220001 as evaluacion_id, t2.LGF0190006 AS modulo_id, t2.LGF0190007 AS leccion FROM lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t2.LGF0190006 = 1 AND t3.LGF0220002 = ".$id." GROUP BY t2.LGF0190007";
			$resmodulo1 = $this->doSelect();

			foreach ($resmodulo1 as $m1) {
				$porcentaje = $this->porcentaje_leccion_alumno($id, $m1['leccion'], $m1['modulo_id']);
				$modulo1[] = array(
					'evaluacion_id' => $m1['evaluacion_id'],
					'modulo_id' => $m1['modulo_id'],
					'leccion' => $m1['leccion'],
					'porcentaje' => round($porcentaje[0]['porcentaje'])
				);
			}

			$this->query = "SELECT t3.LGF0220001 as evaluacion_id, t2.LGF0190006 AS modulo_id, t2.LGF0190007 AS leccion FROM lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t2.LGF0190006 = 2 AND t3.LGF0220002 = ".$id." GROUP BY t2.LGF0190007";
			$resmodulo2 = $this->doSelect();

			foreach ($resmodulo2 as $m2) {
				$porcentaje = $this->porcentaje_leccion_alumno($id, $m2['leccion'], $m2['modulo_id']);
				$modulo2[] = array(
					'evaluacion_id' => $m2['evaluacion_id'],
					'modulo_id' => $m2['modulo_id'],
					'leccion' => $m2['leccion'],
					'porcentaje' => round($porcentaje[0]['porcentaje'])
				);
			}

			$this->query = "SELECT t3.LGF0220001 as evaluacion_id, t2.LGF0190006 AS modulo_id, t2.LGF0190007 AS leccion FROM lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t2.LGF0190006 = 3 AND t3.LGF0220002 = ".$id." GROUP BY t2.LGF0190007";
			$resmodulo3 = $this->doSelect();

			foreach ($resmodulo3 as $m3) {
				$porcentaje = $this->porcentaje_leccion_alumno($id, $m3['leccion'], $m3['modulo_id']);
				$modulo3[] = array(
					'evaluacion_id' => $m3['evaluacion_id'],
					'modulo_id' => $m3['modulo_id'],
					'leccion' => $m3['leccion'],
					'porcentaje' => round($porcentaje[0]['porcentaje'])
				);
			}

			$this->query = "SELECT t3.LGF0220001 as evaluacion_id, t2.LGF0190006 AS modulo_id, t2.LGF0190007 AS leccion FROM lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t2.LGF0190006 = 4 AND t3.LGF0220002 = ".$id." GROUP BY t2.LGF0190007";
			$resmodulo4 = $this->doSelect();

			foreach ($resmodulo4 as $m4) {
				$porcentaje = $this->porcentaje_leccion_alumno($id, $m4['leccion'], $m4['modulo_id']);
				$modulo4[] = array(
					'evaluacion_id' => $m4['evaluacion_id'],
					'modulo_id' => $m4['modulo_id'],
					'leccion' => $m4['leccion'],
					'porcentaje' => round($porcentaje[0]['porcentaje'])
				);
			}

			$this->query = "SELECT t3.LGF0220001 as evaluacion_id, t2.LGF0190006 AS modulo_id, t2.LGF0190007 AS leccion FROM lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 WHERE t2.LGF0190006 = 5 AND t3.LGF0220002 = ".$id." GROUP BY t2.LGF0190007";
			$resmodulo5 = $this->doSelect();

			foreach ($resmodulo5 as $m5) {
				$porcentaje = $this->porcentaje_leccion_alumno($id, $m5['leccion'], $m5['modulo_id']);
				$modulo5[] = array(
					'evaluacion_id' => $m5['evaluacion_id'],
					'modulo_id' => $m5['modulo_id'],
					'leccion' => $m5['leccion'],
					'porcentaje' => round($porcentaje[0]['porcentaje'])
				);
			}

			return array("modulo1"=>$modulo1,"modulo2"=>$modulo2,"modulo3"=>$modulo3,"modulo4"=>$modulo4,"modulo5"=>$modulo5);
		}

		public function obtener_usuario($id) {
			$this->query = "SELECT t1.LGF0010002, t1.LGF0010003, t1.LGF0010004, t2.LGF0290002 as grupo, t1.LGF0010009 as foto, t1.LGF0010039 FROM lg00001 t1 LEFT JOIN lg00029 t2 ON t2.LGF0290001 = t1.LGF0010039 WHERE t1.LGF0010001 = ".$id;
			return $this->doSelect();
		}

		public function habilidades_alumno($id) {
			$this->query = "SELECT t1.LGF0010001 AS ID, t2.LGF0220001 AS evaluacion, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004,
				(SELECT t2.LGF0290002 FROM lg00029 t2 WHERE t2.LGF0290001 = t1.LGF0010039 ) AS grupo, t1.LGF0010009 as foto,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 2) AS vocabulary,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 1) AS grammar,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 3 ) AS reading,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 4 ) AS listening,
				(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 5 ) AS speaking
				FROM lg00001 t1 LEFT JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010007 = 2 AND t1.LGF0010001 = $id GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010002 ASC";
			return $this->doSelect();
		}

		public function porcentaje_leccion_alumno($usuario, $leccion, $modulo) {
			$this->query = "SELECT SUM(t3.LGF0220003) / COUNT(t3.LGF0220006) as porcentaje FROM lg00022 t3 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006 
				WHERE t3.LGF0220002 = $usuario AND t2.LGF0190006 = $modulo AND t2.LGF0190007 = $leccion";
			// echo $this->query."<br>";
			return $this->doSelect();
		}

		public function obtener_calificacion_id($modulo) {
			$this->query = "SELECT
				t3.LGF0220003 as calificacion,
			t3.LGF0220001 as id
			FROM
				lg00022 t3
			INNER JOIN lg00019 t2 ON t2.LGF0190001 = t3.LGF0220006
			INNER JOIN lg00001 t4 ON t4.LGF0010001 = t3.LGF0220002
			WHERE
			t2.LGF0190006 = 1
			AND t3.LGF0220003 < (SELECT MAX(t4.LGF0220003) FROM lg00022 t4  WHERE t4.LGF0220002 = t4.LGF0010001)";
			$result = $this->doSelect();
			foreach ($result as $id) {
				$this->query = "DELETE FROM lg00022 t1 WHERE t1.LGF0220001 = ".$id['id'];
				$respuesta = $this->doSelect();
			}
		}

        public function obtener_docentes_desde_institucion($institucion){
            $this->query = "SELECT 
                LGF0010001 as id, 
                CONCAT(LGF0010002,' ', LGF0010003, ' ', LGF0010004) as nombre 
                FROM lg00001
                WHERE LGF0010007 = 6 AND LGF0010038 = ".$institucion;

            return $this->doSelect();
        }

		public function obtener_docentes($usuario) {
			if ($_SESSION['perfil'] == 1) { // Administrador
				if (empty($usuario)) {
					$condicion = "";
				} else {
					$condicion = " AND t1.LGF0010001 = ".$usuario;
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = " AND t1.LGF0010038 = ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
				$result = $this->doSelect();
				for ($i=0; $i < count($result); $i++) { 
					if ($i == 0) {
						$condicion = " AND t1.LGF0010038 = ".$result[$i]['LGF0270001'];
					} else {
						$condicion.= "  OR t1.LGF0010038 = ".$result[$i]['LGF0270001'];
					}
				}
			} else if ($_SESSION['perfil'] == 6) {
				$this->query = "SELECT LGF0010001, LGF0010038 FROM lg00001 WHERE LGF0010001 = ".$usuario;
				$result = $this->doSelect();
				$condicion = " AND t1.LGF0010038 = ".$result[0]['LGF0010038'];
			}

			$this->query = "SELECT  t1.LGF0010001 as clave, 
                                    t1.LGF0010002, 
                                    t1.LGF0010003, 
                                    t1.LGF0010004, 
                                    t2.LGF0270002 AS nombreInstitucion, 
                                    t2.LGF0270028 AS cctInstitucion, 
                                    t1.LGF0010038 as idInstitucion, 
                                    t3.LGF0290002 as grupo, 
                                    t3.LGF0290001 as idgrupo 
                                FROM lg00001 t1 LEFT JOIN lg00027 t2 ON t2.LGF0270001 = t1.LGF0010038 
                                                LEFT JOIN lg00029 t3 ON t3.LGF0290006 = t1.LGF0010001 
                                    WHERE t1.LGF0010007 = 6 ".$condicion." 
                                    GROUP BY clave 
                                    ORDER BY LGF0010002";
			// echo $this->query;
			return $this->doSelect();
			/*if (empty($usuario)) {
				$this->query = "SELECT t1.LGF0010001 as clave, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004 FROM lg00001 t1 WHERE t1.LGF0010007 = 6";
			} else {
				$this->query = "SELECT t2.LGF0270002 AS nombreInstitucion, t1.LGF0010038 as idInstitucion, t3.LGF0290002 as grupo, t3.LGF0290001 as idgrupo FROM lg00001 t1 INNER JOIN lg00027 t2 ON t2.LGF0270001 = t1.LGF0010038 INNER JOIN lg00029 t3 ON t3.LGF0290006 = t1.LGF0010001 WHERE t1.LGF0010007 = 6  AND t1.LGF0010001 = ".$usuario;
			}
			return $this->doSelect();*/
		}

		public function modulos($id = "") {
			if ($id != "") {
				$campo = ", t1.LGF0150004 as nivel";
				$sql = "WHERE t1.LGF0150001 = ".$id;
			}
			$this->query = "SELECT t1.LGF0150001 as id, t1.LGF0150002 as nombre $campo FROM lg00015 t1 ".$sql;
			return $this->doSelect();
		}

		public function leccion_modulo($modulo) {
			$this->query = "SELECT t1.LGF0160001 as id, t1.LGF0160002 as nombre FROM lg00016 t1 WHERE t1.LGF0160004 = ".$modulo;
			return $this->doSelect();
		}

		public function mostrarEvaluaciones($modulo, $leccion) {
			if (empty($modulo) && empty($leccion)) {
				$condicion = "";
			} else if (!empty($modulo) && empty($leccion)) {
				$condicion = "WHERE t1.LGF0190006 = $modulo";
			} else {
				$condicion = "WHERE t1.LGF0190006 = $modulo AND t1.LGF0190007 = $leccion";
			}
			/*$this->query = "SELECT t1.LGF0190001 AS idEvaluacion, t1.LGF0190002 AS nombre_evaluacion, t2.LGF0150002 AS modulo, t3.LGF0160002 AS leccion, t1.LGF0190011 AS numero_preguntas, DATE_FORMAT(t1.LGF0190014, '%d %m %Y') AS fecha, t1.LGF0190010 AS estatus FROM lg00019 t1 INNER JOIN lg00015 t2 ON t2.LGF0150001 = t1.LGF0190006 INNER JOIN lg00016 t3 ON t3.LGF0160001 = t1.LGF0190007 $condicion ORDER BY t1.LGF0190002 ASC";*/
			$this->query = "SELECT t1.LGF0190001 AS idEvaluacion, t1.LGF0190002 AS nombre_evaluacion, t2.LGF0150002 AS modulo, t3.LGF0160002 AS leccion, 
			(SELECT COUNT(*) FROM lg00020 t4 WHERE t4.LGF0200009 = t1.LGF0190001 ) AS numero_preguntas, DATE_FORMAT(t1.LGF0190014, '%d %m %Y') AS fecha, t1.LGF0190010 AS estatus FROM lg00019 t1 INNER JOIN lg00015 t2 ON t2.LGF0150001 = t1.LGF0190006 INNER JOIN lg00016 t3 ON t3.LGF0160001 = t1.LGF0190007 $condicion ORDER BY t1.LGF0190002 ASC";
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function obtener_nivel_modulo($modulo_id) {
			$this->query = "SELECT LGF0150004 as nivel FROM lg00015 t1 WHERE t1.LGF0150001 = ".$modulo_id;
			return $this->doSelect();
		}

		public function preguntas_evaluacion($pregunta_id) {
			$this->query = "SELECT t1.LGF0190001 AS evaluacion_id, t4.LGF0200001 AS pregunta_id, t1.LGF0190002 AS evaluacion, t1.LGF0190011 AS total, t4.LGF0200002 AS pregunta, t5.LGF0250002 AS categoria, t4.LGF0200004 AS tipo,
			(SELECT COUNT(*) FROM lg00022 t2 INNER JOIN lg00023 t3 ON t3.LGF0230002 = t2.LGF0220001 WHERE t3.LGF0230005 = 1 AND t2.LGF0220006 = t4.LGF0200009 AND t3.LGF0230003 = t4.LGF0200001 ) AS aciertos,
			(SELECT COUNT(*) FROM lg00022 t2 INNER JOIN lg00023 t3 ON t3.LGF0230002 = t2.LGF0220001 WHERE t3.LGF0230005 = 0 AND t2.LGF0220006 = t4.LGF0200009 AND t3.LGF0230003 = t4.LGF0200001 ) AS errores
			FROM lg00019 t1 LEFT JOIN lg00020 t4 ON t4.LGF0200009 = t1.LGF0190001 LEFT JOIN lg00025 t5 ON t5.LGF0250001 = t4.LGF0200010 WHERE t1.LGF0190001 = ".$pregunta_id;
			return $this->doSelect();
		}

		public function informacion_evaluacion($evaluacion_id) {
			$this->query = "SELECT COUNT(*) as evaluados, (SELECT  COUNT(*) FROM lg00022 t2  WHERE t2.LGF0220006 = t1.LGF0220006 AND t2.LGF0220003 >= 60 ) as aprobados FROM lg00022 t1 WHERE t1.LGF0220006 = ".$evaluacion_id;
			return $this->doSelect();
		}

		public function obtener_ids_respuestas($evaluacion_id) {
			$this->query = "SELECT LGF0210001 as id, LGF0210004 as imagen FROM lg00021 WHERE LGF0210002 = ".$evaluacion_id;
			return $this->doSelect();
		}

		public function lista_categorias() {
			$this->query = "SELECT LGF0250001 as clave, LGF0250002 as nombre FROM lg00025 ORDER BY nombre ASC";
			return $this->doSelect();
		}

		public function obtener_pregunta($pregunta_id) {
			$this->query = "SELECT t2.LGF0190002 as evaluacion, t2.LGF0190001 as id_evaluacion, t1.LGF0200001 AS id_pregunta, t1.LGF0200002 AS texto, t1.LGF0200003 AS imagen, t1.LGF0200004 AS tipo_pregunta, t1.LGF0200010 AS categoria FROM lg00020 t1 INNER JOIN lg00019 t2 ON t2.LGF0190001 = t1.LGF0200009 WHERE t1.LGF0200001 = ".$pregunta_id;
			return $this->doSelect();
		}

		public function obtener_respuestas($pregunta_id) {
			$this->query = "SELECT t1.LGF0210001 as id_respuesta, t1.LGF0210003 as texto_respuesta, t1.LGF0210004 as imagen_respuesta, t1.LGF0210005 as acierto FROM lg00021 t1 WHERE t1.LGF0210002 = ".$pregunta_id;
			return $this->doSelect();
		}

		public function check_evaluacion($modulo, $leccion) {
			$this->query = "SELECT t1.LGF0190001 AS id, t1.LGF0190002 as nombre FROM lg00019 t1 WHERE t1.LGF0190006 = $modulo AND t1.LGF0190007 = $leccion";
			return $this->doSelect();
		}

		public function check_preguntas($evaluacion_id) {
			$this->query = "SELECT COUNT(*) as total FROM lg00019 t1  JOIN lg00020 t2 ON t2.LGF0200009 = t1.LGF0190001 WHERE t1.LGF0190001 = ".$evaluacion_id;
			return $this->doSelect();
		}

		public function mostrarObjetos($modulo, $leccion) {
            #Para formar el url de visualizacion en admin/objeto desde AjaxAdminController@mostrarObjetos
            #var URL_for_iframe = navegar/nivelid_moduloid_leccionid_orden
			$this->query = "SELECT t1.LGF0180001 AS id, 
                                   t4.LGF0170002 AS nombre, 
                                   t2.LGF0150004 AS nivelid, 
                                   t2.LGF0150001 AS moduloid, 
                                   t2.LGF0150002 AS modulo, 
                                   t3.LGF0160001 AS leccionid, 
                                   t3.LGF0160002 AS leccion, 
                                   t4.LGF0170002 AS seccion, 
                                   t4.LGF0170001 AS seccionid,
                                   t1.LGF0180007 AS directorio, 
                                   t1.LGF0180006 AS orden, 
                                   t1.LGF0180008 AS estatus, 
                                   DATE_FORMAT(t1.LGF0180009,'%d %m %Y') as fecha, 
                                   t2.LGF0150004 as nivel 
                                   FROM lg00018 t1 
                                       INNER JOIN lg00015 t2 ON t2.LGF0150001 = t1.LGF0180003 
                                       INNER JOIN lg00016 t3 ON t3.LGF0160001 = t1.LGF0180004 
                                       INNER JOIN lg00017 t4 ON t4.LGF0170001 = t1.LGF0180005  
                                   WHERE t1.LGF0180003 = $modulo AND 
                                         t1.LGF0180004 = $leccion 
                                   ORDER BY orden ASC";
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function secciones() {
			$this->query = "SELECT t1.LGF0170001 as id, t1.LGF0170002 as nombre FROM lg00017 t1";
			return $this->doSelect();
		}

		/**
		 * Se obtiene el orden de la evalucion solicitada en HomeController:navegar
		 */
		public function orden_evaluacion($modulo, $leccion) {
			$this->query = "SELECT a.LGF0180001 as id, a.LGF0180006 as orden FROM lg00018 a WHERE a.LGF0180003 = $modulo AND a.LGF0180004 = $leccion AND a.LGF0180007 = ''";
			// echo $this->query."<br>";
			return $this->doSelect();
		}

		public function ultima_seccion($modulo, $leccion, $origen) {
			if ($origen == 1) {

				$this->query = "SELECT a.LGF0180002 as nivel, a.LGF0180003 as modulo, a.LGF0180004 as leccion, a.LGF0180006 as seccion FROM lg00018 a WHERE a.LGF0180004 = (SELECT LGF0160001 FROM lg00016 WHERE LGF0160004 = $modulo AND LGF0160001 =$leccion) AND a.LGF0180008 = 1 ORDER BY a.LGF0180006 DESC LIMIT 1";
			} else if ($origen == 2) {
				$this->query = "SELECT a.LGF0180002 as nivel, a.LGF0180003 as modulo, a.LGF0180004 as leccion, a.LGF0180006 as seccion FROM lg00018 a WHERE a.LGF0180004 = (SELECT LGF0160001 FROM lg00016 WHERE LGF0160004 = $modulo AND LGF0160007 =$leccion) AND a.LGF0180008 = 1 ORDER BY a.LGF0180006 LIMIT 1";
			} else if ($origen == 3) {
				$this->query = "SELECT LGF0160007 FROM lg00016 WHERE LGF0160004 = $modulo AND LGF0160001 = $leccion";
			}
			// echo $this->query.";<br>";
			return $this->doSelect();
		}

		/**
		 * Nuevas funciones de reportes
		 */

		public function obtenerMaxLecciones($query = "") {
			if ($query != "") {
				$this->query = "SELECT MAX(LGF0160007) num FROM lg00016 ".$query;
			} else {
				$this->query = "SELECT MAX(LGF0160007) num FROM lg00016";
			}
			
			return $this->doSelect();
		}

		public function reporte_habilidades($usuario, $modulo) {
			if ($_SESSION['perfil'] == 1) { // Administrador
				if (empty($institucion)) {
					$condicion = "";
				} else {
					$condicion = " AND t1.LGF0010038 = ".$institucion;
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = " AND t1.LGF0010038 = ".$institucion;
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				if (empty($institucion)) {
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = " AND t1.LGF0010038 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t1.LGF0010038 = ".$result[$i]['LGF0270001'];
						}
					}
				} else {
					$condicion = " AND t1.LGF0010038 = ".$institucion;
				}
			} else if ($_SESSION['perfil'] == 6) {
				$result = $this->obtener_docentes($_SESSION['idUsuario']);
				$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
			}
			// echo "Mi condicion\n\n".$condicion."\n\n";
			$this->query = "SELECT t1.LGF0010001 AS ID,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 2 AND t7.LGF0190006 = $modulo) AS vocabulary, 
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 1 AND t7.LGF0190006 = $modulo) AS grammar,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 3 AND t7.LGF0190006 = $modulo) AS reading,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 4 AND t7.LGF0190006 = $modulo) AS listening,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 5 AND t7.LGF0190006 = $modulo) AS speaking
			FROM lg00001 t1 LEFT JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010001 = $usuario GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010002 ASC;";
			// echo $this->query."\n\n";
			return $this->doSelect();
		}

		public function reporte_evaluaciones($usuario, $lecciones, $modulo) {
			if ($_SESSION['perfil'] == 1) { // Administrador
				if (empty($institucion)) {
					$condicion = "";
				} else {
					$condicion = "AND  t1.LGF0010038 = ".$institucion;
				}
			} else if ($_SESSION['perfil'] == 4) { // Institucion
				$condicion = "AND  t1.LGF0010038 = ".$institucion;
			} else if ($_SESSION['perfil'] == 3) { // Cliente
				if (empty($institucion)) {
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'];
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$condicion = "AND  t1.LGF0010038 = ".$result[$i]['LGF0270001'];
						} else {
							$condicion.= "  OR t1.LGF0010038 = ".$result[$i]['LGF0270001'];
						}
					}
				} else {
					$condicion = "AND  t1.LGF0010038 = ".$institucion;
				}
			} else if ($_SESSION['perfil'] == 6) {
				$result = $this->obtener_docentes($_SESSION['idUsuario']);
				$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
			}

			for ($i=1; $i <= $lecciones; $i++) { 
				if ($i == 1) {
					$sub = "(SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t1.LGF0010001 AND LGF0220006 = (SELECT t2.LGF0190001 FROM lg00019 t2 WHERE t2.LGF0190006 = $modulo AND t2.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = $modulo))) AS promL$i";
				} else {
					$sub.= ",(SELECT LGF0220003 FROM lg00022 WHERE LGF0220002 = t1.LGF0010001 AND LGF0220006 = (SELECT t2.LGF0190001 FROM lg00019 t2 WHERE t2.LGF0190006 = $modulo AND t2.LGF0190007 = (SELECT t3.LGF0160001 FROM lg00016 t3 WHERE t3.LGF0160007 = $i AND t3.LGF0160004 = $modulo))) AS promL$i";
				}
			}
			$this->query = "SELECT $modulo as id, (SELECT MAX(LGF0160007) FROM lg00016 WHERE LGF0160004 = $modulo) as numL, (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = $modulo) AS modulo, (SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 = $modulo) AS nivel, 
				$sub
				FROM lg00001 t1 WHERE t1.LGF0010001 = $usuario ORDER BY t1.LGF0010002 ASC";
			// echo $this->query.";<br>\n\n";
			return $this->doSelect();
		}

		public function obtenerGuias($leccion, $condicion = "") {
			if ($condicion == "") {
				$where = "AND a.LGF0310006 = 1";
			}
			$this->query = "SELECT (SELECT LGF0160003 FROM lg00016 WHERE LGF0160001 = LGF0310004) as icono, a.LGF0310007 as archivo, (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0310004) as leccion, LGF0310005 as orden, LGF0310003 AS modulo, LGF0310001 as id, LGF0310004 AS leccionid, LGF0310006 AS estatus, LGF0310009 AS tipoG FROM lg00031 a WHERE a.LGF0310003 = $leccion $where ORDER BY orden ASC";
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function obtenerGuias1($leccion, $condicion) {
			if ($condicion == 0) {
				$where = " AND a.LGF0310005 <> 0";
			} else {
				$where = " AND a.LGF0310005 <> 0 AND a.LGF0310009 = ".$condicion;
			}
			$this->query = "SELECT (SELECT LGF0160003 FROM lg00016 WHERE LGF0160001 = LGF0310004) as icono, a.LGF0310007 as archivo, (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0310004) as leccion, LGF0310005 as orden, LGF0310003 AS modulo, LGF0310001 as id, LGF0310004 AS leccionid, LGF0310006 AS estatus, LGF0310009 AS tipoG FROM lg00031 a WHERE a.LGF0310003 = $leccion AND a.LGF0310006 = 1 $where ORDER BY orden ASC";
			// echo $this->query."\n<br>";
			return $this->doSelect();
		}

		public function obtenerRecursos($leccion, $tipoR) {
			if ($tipoR == 0) {
				$complemento = "";
			} else {
				$complemento = "AND a.LGF0320012 = ".$tipoR;
			}
			$this->query = "SELECT 
                a.LGF0320005 AS orden, 
                (SELECT LGF0160003 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS icono, 
                a.LGF0320008 AS recurso1, 
                a.LGF0320009 AS recurso2, 
                a.LGF0320010 AS recurso3, 
                a.LGF0320011 AS recurso4, 
                a.LGF0320013 AS recurso5, 
                (SELECT LGF0140001 FROM lg00014 WHERE LGF0140001 = LGF0320002) AS nivel, 
                (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS leccion, 
                (SELECT LGF0160004 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS modulo, 
                a.LGF0320012 AS tipoR 
                    FROM lg00032 a 
                    WHERE a.LGF0320003 = $leccion AND 
                          a.LGF0320006 = 1 $complemento 
                    ORDER BY orden ASC";
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function obtenerLeccion($modulo) {
			$this->query = "SELECT LGF0160001 as leccion, (SELECT LGF0150004 AS nivel FROM lg00015 WHERE LGF0150001 = LGF0160004) as nivel FROM lg00016 WHERE LGF0160007 = 1 AND LGF0160004 = ".$modulo;
			// echo $this->query."\n";
			return $this->doSelect();
		}

		public function informacionUsuario($usuario) {
			$this->query = "SELECT a.LGF0010002, a.LGF0010003, a.LGF0010004, (SELECT b.LGF0270002 FROM lg00027 b WHERE b.LGF0270001 = a.LGF0010038) as institucion FROM lg00001 a WHERE a.LGF0010001 = $usuario";
			return $this->doSelect();
		}

		public function informacionCliente($usuario) {
			$this->query = "SELECT b.LGF0280002 as cliente FROM lg00027 a INNER JOIN lg00028 b ON b.LGF0280001 = a.LGF0270021 WHERE a.LGF0270001 = (SELECT LGF0010038 FROM lg00001 WHERE LGF0010001 = $usuario)";
			return $this->doSelect();
		}

		public function obtener_niveles() {
			$this->query = "SELECT MAX(LGF0140001) as nivel, (SELECT MAX(LGF0150001) FROM lg00015) as modulo, (SELECT MAX(LGF0160001) FROM lg00016) as leccion FROM lg00014 ";
			return $this->doSelect();
		}

		public function informacion_nivel() {
			$this->query = "SELECT LGF0140005 as color FROM lg00014";
			return $this->doSelect();
		}

		/**
		 * funciones del docente
		 */
		public function docente_grupos($usuario = "") {

			$complemento = "";
			if ($usuario != "") {
				if ($_SESSION['perfil'] == 3){
					$where = "WHERE a.LGF0290004 IN (".$usuario.")";
				} else {
					$where = "WHERE a.LGF0290006 = ".$usuario;
				}
			} else {
				if ($_SESSION['perfil'] == 3){
					$where = "WHERE a.LGF0290004 IN (".$usuario.")";
				} else if ($_SESSION['perfil'] == 4){
					$where = "WHERE a.LGF0290004 = ".$_SESSION['idUsuario'];
				}
			}
			$this->query = "SELECT a.LGF0290001 AS id, a.LGF0290005 as modulo, a.LGF0290002 AS grupo,
				(SELECT CONCAT(v.LGF0010002, ' ', v.LGF0010003, ' ', v.LGF0010004) FROM lg00001 v WHERE v.LGF0010001 =  a.LGF0290006) as docente,
				(SELECT v.LGF0010001 FROM lg00001 v WHERE v.LGF0010001 =  a.LGF0290006) as docenteid,
				(SELECT count(*) FROM lg00001 WHERE LGF0010039 IN (LGF0290001) AND LGF0010007 = 2) as alumnos,
				(SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 IN (modulo)) as nivelid,
				(SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 IN (LGF0290005)) as nivel,
				(SELECT count(LGF0160007) FROM lg00016 WHERE LGF0160004 IN (LGF0290005) AND LGF0160005 = 1) as lecciones
			FROM lg00029 a ".$where;
            // $this->query."\n\n";

			return $this->doSelect();
		}

		public function grupos($id) {
			$this->query = "SELECT * FROM lg00029 WHERE LGF0290001 = ".$id;
			return $this->doSelect();
		}

		public function registro_evaluaciones($usuario, $lecciones, $modulo) {
			$this->query = "SELECT t1.LGF0010001 as id, t1.LGF0010002 as nombre, t1.LGF0010003 as apepat, t1.LGF0010004 as apemat,
				(SELECT MAX(LGF0160007) FROM lg00016 WHERE LGF0160004 = $modulo) as numL,
				(SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = $modulo) AS modulo,
				(SELECT LGF0150004 FROM lg00015 WHERE LGF0150001 = $modulo) AS nivel
				FROM lg00001 t1 WHERE t1.LGF0010001 in ($usuario) ORDER BY t1.LGF0010002 ASC";
			// echo $this->query.";\n\n";
			return $this->doSelect();
		}

		public function registro_habilidades($usuarios, $modulo, $fecha) {
			if ($fecha != "" || $fecha != null) {
				$fecha_actual = date("Y-m-d");
				if (is_numeric($fecha)) {
					if ($fecha == 1) { // bimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 2 month"));
					} else if ($fecha == 2) { // trimestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 3 month"));
					} else if ($fecha == 3) { // semestral
						$fecha_mod = date("Y-m-d",strtotime($fecha_actual."- 6 month"));
					}
				} else {
					$aux = explode("*", $fecha);
					$inicia = explode("/", $aux[0]);
					$termina = explode("/", $aux[1]);

					$fecha_mod = $inicia[2]."-".$inicia[1]."-".$inicia[0];
					$fecha_actual = $termina[2]."-".$termina[1]."-".$termina[0];
				}

				// $periodo = "AND LGF0220005 BETWEEN '".$fecha_mod." 00:00:00' AND '".$fecha_actual." 23:59:59'";
				$periodo = "AND LGF0220005 >= '".$fecha_mod." 00:00:00' AND LGF0220005 <= '".$fecha_actual." 23:59:59'";
			}
			$this->query = "SELECT t1.LGF0010002 AS nombre, t1.LGF0010003 AS apepat, t1.LGF0010004 AS apemat,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 2 $periodo) AS vocabulary, 
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 1 $periodo) AS grammar,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 3 $periodo) AS reading,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 4 $periodo) AS listening,
			(SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL)) * 100) / IF (t7.LGF0190010 = 1,COUNT(t4.LGF0230002),0) FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009 WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = t1.LGF0010001 AND t5.LGF0200010 = 5 $periodo) AS speaking
			FROM lg00001 t1 LEFT JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010007 = 2 AND t1.LGF0010008 = 1 AND t1.LGF0010001 in ($usuarios) GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010002 ASC;";
			// echo $this->query.";\n\n";
			return $this->doSelect();
		}

		public function relacion_tutor_alumno($usuario) {
			$this->query = "SELECT LGF0340002 as id, CONCAT(LGF0010002,' ',LGF0010003,' ',LGF0010004) as alumno, LGF0010024 as grado, (SELECT LGF0140005 FROM lg00014 WHERE LGF0140001 = LGF0010023) as color, LGF0010039 as grupo, LGF0010023 as nivel, LGF0010009 as img, LGF0010021 as genero FROM lg00034 INNER JOIN lg00001 ON LGF0010001 = LGF0340002 WHERE LGF0340001 = ".$usuario;
			return $this->doSelect();
		}

		public function checkPassUser($usuario, $perfil) {
			$this->query = "SELECT *FROM lg00033 WHERE LGF0330001 = $usuario AND LGF0330003 = $perfil";
			return $this->doSelect();
		}

		public function institucion_cliente($cliente) {
			$this->query = "SELECT *FROM lg00027 WHERE LGF0270021 = ".$cliente;
			return $this->doSelect();
		}

		public function docentes() {
			if ($_SESSION['perfil'] == 3) {
				$condicion = "AND LGF0010038 in (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'].")";
			} else if ($_SESSION['perfil'] == 4) {
				$condicion = "AND LGF0010038 = ".$_SESSION['idUsuario']."";
			}
			$this->query = "SELECT  CONCAT(LGF0270002, ' <br>', LGF0270028) as nombre_institucion, 
                                    LGF0010001 AS usuarioid, 
                                    CONCAT(LGF0010002,' ',LGF0010003,' ',LGF0010004) AS nombre, 
                                    LGF0010038 AS institucionid, 
                                    LGF0290001 as grupoid, 
                                    LGF0290002 AS gruponame,
                                    (
                                        SELECT COUNT(*) 
                                        FROM lg00001 t 
                                        WHERE t.LGF0010039 = t2.LGF0290001 AND 
                                              t.LGF0010007 = 2
                                    ) as alumnos, 
                                    (
                                        SELECT LGF0150004 
                                        FROM lg00015 
                                        WHERE LGF0150001 = t2.LGF0290005
                                    ) as nivel, 
                                    t2.LGF0290005 as moduloid 
                                    FROM lg00001 t1 LEFT JOIN lg00029 t2 
                                                    ON LGF0290006 = LGF0010001
                                        LEFT JOIN lg00027 t3 
                                                    ON LGF0270001 = LGF0010038
                                    WHERE LGF0010007 = 6 $condicion 
                                    ORDER BY LGF0010001";
			// echo $this->query;
			return $this->doSelect();
		}

		public function cliclo_escolar() {
			$this->query = "SELECT *FROM lg00035";
			return $this->doSelect();
		}

		public function informacion() {
			if ($_SESSION['perfil'] == 3) {
				$this->query="SELECT *FROM lg00028 WHERE LGF0280001 = ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 4) {
				$this->query="SELECT *FROM lg00027 WHERE LGF0270001 = ".$_SESSION['idUsuario'];
			} else {
				$this->query="SELECT *FROM lg00001 WHERE LGF0010001 = ".$_SESSION['idUsuario'];
			}
			// echo $this->query;
			return $this->doSelect();
		}

		public function check_matricula($matricula) {
			$this->query = "SELECT * FROM lg00001 WHERE LGF0010040 = '$matricula';";
			return $this->doSelect();
		}

		public function mostrarLecciones($leccion = "", $solo_activas = 0) {
			if ($leccion != "") {
				$leccion = "WHERE LGF0160004 in (".$leccion.")";
			}
            if($solo_activas){
                $leccion .= " and LGF0160005 = 1 ";
            }

			$this->query = "SELECT * FROM lg00016 $leccion ORDER by LGF0160007";
			// echo $this->query.";\n";
			return $this->doSelect();
		}

		public function informacionLeccion($leccion) {
			$this->query = "SELECT *FROM lg00016 WHERE LGF0160001 in (".$leccion.")";
			// echo $this->query;
			return $this->doSelect();
		}

		public function obtener_evaluaciones($where) {
			$this->query = "SELECT *FROM lg00018 ".$where." ORDER BY LGF0180004,LGF0180006";
			// echo $this->query;
			return $this->doSelect();
		}

		public function guias($modulo, $lecciones, $opc) {
			if ($opc == 1) {
				$from = "*";
				$condicion = "WHERE LGF0310003 = $modulo AND LGF0310004 in($lecciones)";
			} else if ($opc == 2) {
				$from = "MAX(LGF0310005) as num";
				$condicion = "WHERE LGF0310003 = $modulo";
			} else if ($opc == 3) {
				$from = "*";
				$condicion = "WHERE LGF0310003 = $modulo AND LGF0310005 <> 0";
			}
			$this->query = "SELECT $from FROM lg00031 $condicion  ORDER BY LGF0310005";
			// echo $this->query.";<br>";
			return $this->doSelect();
		}

		public function recursos($modulo, $lecciones, $opc) {
			if ($opc == 1) {
				$from = "*";
				$condicion = "WHERE LGF0320003 = $modulo AND LGF0320004 in ($lecciones)";
			} else if ($opc == 2) {
				$from = "MAX(LGF0320005) num";
				$condicion = "WHERE LGF0320003 = $modulo";
			} else if ($opc == 3) {
				$from = "*";
				$condicion = "WHERE LGF0320003 = $modulo";
			}
			$this->query = "SELECT $from FROM lg00032 $condicion ORDER BY LGF0320005";
			// echo $this->query.";<br>";
			return $this->doSelect();
		}

		public function obtener_evaluacion($leccion) {
			$this->query = "SELECT *FROM lg00019 WHERE LGF0190007 in (".$leccion.")";
			return $this->doSelect();
		}

		public function check_logregistros($usuario, $tipo) {
			if ($tipo == 1) {
				$this->query = "SELECT *FROM lg00036 WHERE LGF0360002 = $usuario AND LGF0360003 = 1 AND LGF0360005 IS NULL";
			} else {
				$this->query = "SELECT *FROM lg00036 WHERE LGF0360001 = $usuario";
			}
			// echo $this->query;
			return $this->doSelect();
		}

		public function logregistros($usuario, $tipo, $fechaI, $fechaF) {
			if ($tipo == 2) {
				$complemento = ", (SELECT LGF0140002 FROM lg00014 WHERE LGF0140001 = LGF0360006) as nivel, (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = LGF0360007) as modulo, (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0360008) as leccion";
			}
			$this->query = "SELECT * $complemento FROM lg00036 WHERE LGF0360002 in ($usuario) AND LGF0360003 = $tipo";
			// echo $this->query.";\n\n";
			return $this->doSelect();
		}

        public function listar_alumnos_grupo($id) {

            $this->query = "SELECT 
                    LGF0010001 AS id, 
                    CONCAT(LGF0010002,' ', LGF0010003, ' ', LGF0010004) as nombre,
                    LGF0010040 AS curp, 
                    LGF0270002 AS institucion, 
                    LGF0270028 AS CCT    
                    FROM lg00001, lg00027  
                    WHERE LGF0010007 = 2  
                      AND LGF0010008 = 1
                      AND LGF0270001 = LGF0010038                     
                      AND LGF0010039 = ".$id;

            return $this->doSelect();
        }

		public function listarUsuarios($opcion) {
			if ($opcion != "") {
				$complemento = "AND LGF0010038 =".$opcion;
			}
			$this->query = "SELECT 
                    LGF0010001 AS id, 
                    LGF0010002, 
                    LGF0010003, 
                    LGF0010004, 
                    LGF0010040 AS curp, 
                    ( SELECT LGF0270002 FROM lg00027 WHERE LGF0270001 = LGF0010038 ) AS ins, 
                    ( SELECT LGF0270028 FROM lg00027 WHERE LGF0270001 = LGF0010038 ) AS cct, 
                    LGF0360004 as inicio, 
                    LGF0360005 as fin  
                    FROM lg00001 INNER JOIN lg00036 ON LGF0360002 = LGF0010001 
                    WHERE LGF0010007 = 2  
                      AND LGF0010008 = 1 
                      AND LGF0360003 = 1 
                      AND LGF0360005 is NOT null $complemento";

			return $this->doSelect();
		}

		public function validarAccesos() {
			if ($_SESSION['perfil'] == 3) {
				$this->query = "SELECT LGF0300003 as modulo FROM lg00030 WHERE LGF0300002 in (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = ".$_SESSION['idUsuario'].")";
			} else if ($_SESSION['perfil'] == 4) {
				$this->query = "SELECT LGF0300003 as modulo FROM lg00030 WHERE LGF0300002 in (".$_SESSION['idUsuario'].")";
			} else if ($_SESSION['perfil'] == 6) {
				$this->query = "SELECT LGF0300003 as modulo FROM lg00030 WHERE LGF0300002 in (SELECT LGF0010038 FROM lg00001 WHERE LGF0010001 = ".$_SESSION['idUsuario'].");";
			} else if ($_SESSION['perfil'] == 2) {
				$this->query = "SELECT LGF0300003 as modulo FROM lg00030 WHERE LGF0300002 in (SELECT LGF0010038 FROM lg00001 WHERE LGF0010001 = ".$_SESSION['idUsuario'].");";
			}
			// echo $this->query;

			return $this->doSelect();
		}

		public function check_nombre_usuario($usuario) {
			if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2 || $_SESSION['perfil'] == 6) {
				$this->query = "SELECT count(*) as total FROM lg00001 WHERE LGF0010005 = '$usuario' AND LGF0010001 <> ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 4) {
				$this->query = "SELECT count(*) as total FROM lg00027 WHERE LGF0270024 = '$usuario' AND LGF0270001 <> ".$_SESSION['idUsuario'];
			} else if ($_SESSION['perfil'] == 3) {
				$this->query = "SELECT count(*) as total FROM lg00028 WHERE LGF0280019 = '$usuario' AND LGF0280001 <> ".$_SESSION['idUsuario'];
			}
			return $this->doSelect();
		}

		public function obtener_orden_leccion($modulo, $leccion) {
			$this->query = "SELECT * FROM lg00016 INNER JOIN lg00015 ON LGF0160004 = LGF0150001 WHERE LGF0160004 = $modulo AND LGF0160001 = $leccion";
			// echo $this->query;
			return $this->doSelect();
		}

		public function mostrar_guias($modulo) {
			if ($modulo != "") {
				$where = "WHERE a.LGF0310003 = $modulo";
			}
			$this->query = "SELECT 
                (SELECT LGF0160003 FROM lg00016 WHERE LGF0160001 = LGF0310004) as icono, 
                a.LGF0310007 as archivo, 
                (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0310004) as leccion, 
                ( SELECT LGF0160001 FROM lg00016 WHERE LGF0160001 = LGF0310004 ) AS leccionid,
                LGF0310005 as orden, 
                LGF0310003 AS modulo, 
                (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = LGF0310003) AS moduloname, 
                LGF0310002 AS nivel, 
                LGF0310009 AS tipo, 
                LGF0310001 AS id, 
                LGF0310006 AS estatus 
                    FROM lg00031 a $where 
                    ORDER BY id DESC";
                    /*ORDER BY orden ASC";*/
			return $this->doSelect();
		}

		public function obtener_nivel_leccion($modulo, $leccion) {
			if ($leccion != "") {
				$where = "AND LGF0160001 = $leccion";
			}
			$this->query = "SELECT LGF0160001 AS leccion, ( SELECT LGF0150004 AS nivel FROM lg00015 WHERE LGF0150001 = LGF0160004 ) AS nivel, LGF0160007 AS orden FROM lg00016  WHERE LGF0160004 = $modulo $where";
			// echo $this->query;
			return $this->doSelect();
		}

		public function mostrar_recursos($modulo) {
			if ($modulo != "") {
				$where = "WHERE a.LGF0320003 = ".$modulo;
			}
			$this->query = "SELECT 
                a.LGF0320001 AS id, 
                (SELECT LGF0140001 FROM lg00014 WHERE LGF0140001 = LGF0320002) AS nivel, 
                (SELECT LGF0160004 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS modulo, 
                (SELECT LGF0150002 FROM lg00015 WHERE LGF0150001 = LGF0320003) AS moduloname, 
                (SELECT LGF0160001 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS leccionid, 
                (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = LGF0320004) AS leccion, 
                a.LGF0320005 AS orden, 
                a.LGF0320006 AS estatus, 
                ( SELECT LGF0160003 FROM lg00016 WHERE LGF0160001 = LGF0320004 ) AS icono, 
                a.LGF0320008 AS recurso1, 
                a.LGF0320009 AS recurso2, 
                a.LGF0320010 AS recurso3, 
                a.LGF0320011 AS recurso4, 
                a.LGF0320013 AS recurso5, 
                a.LGF0320012 AS tipo 
                    FROM lg00032 a 
                    $where 
                    ORDER BY id desc";
                    /*ORDER BY nivel, modulo, leccionid, orden ASC";*/
			return $this->doSelect();
		}

		public function obtenerClientes($cliente) {
			$this->query = "SELECT *, (SELECT COUNT(*) FROM lg00001 t3 WHERE t3.LGF0010007 = 2 AND t3.LGF0010038 = t2.LGF0270001) as alumnos FROM lg00027 t2 WHERE t2.LGF0270021 in ($cliente)";
			return $this->doSelect();
		}

		public function listado() {
			$this->query = "SELECT ( SELECT T1.LGF0270028 FROM lg00027 T1 WHERE LGF0270001 = LGF0010038 ) AS CCT ,( SELECT T1.LGF0270002 FROM lg00027 T1 WHERE LGF0270001 = LGF0010038 ) AS INST,LGF0010002,LGF0010003,LGF0010004,LGF0010040,LGF0010005,LGF0010038,LGF0010007 FROM lg00001 WHERE LGF0010040 IN ()";
			return $this->doSelect();
		}

		public function obtenClientes() {
			$this->query = "SELECT LGF0280001, LGF0280002, LGF0280017, LGF0280019, (SELECT COUNT(*) FROM lg00027 WHERE LGF0270021 = LGF0280001) as totalInst, LGF0280011 FROM lg00028";
			// echo $this->query;
			return $this->doSelect();
		}

		public function demostrativo() {
			// $this->query = "SELECT LGF0010001, LGF0010002, LGF0010003, LGF0010004, LGF0010005, LGF0010007, LGF0010040 FROM lg00001 t1 WHERE LGF0010007 = 2 ORDER BY LGF0010040";
			$this->query = "SELECT LGF0270001, LGF0270002, LGF0270028, LGF0270028, (SELECT count(*) FROM lg00029 WHERE LGF0290004 = LGF0270001 ) AS grupos, (SELECT COUNT(*) FROM lg00001 WHERE LGF0010007 = 2 AND LGF0010038 = LGF0270001 ) AS alumnos, (SELECT COUNT(*) FROM lg00001 WHERE LGF0010007 = 6 AND LGF0010038 = LGF0270001 ) AS docentes FROM lg00027 ORDER BY LGF0270002";
			return $this->doSelect();
		}

		public function obtenerMenuNavegacion($nivel, $modulo, $leccion, $limite = 0) {
            $limit_sql = '';
            if($limite != 0){
                $limit_sql = " LIMIT ".$limite;
            }
			$this->query = "SELECT *,
                ( SELECT LGF0170002 FROM lg00017 WHERE LGF0170001 = LGF0180005) AS nombre, 
                ( SELECT LGF0170003 FROM lg00017 WHERE LGF0170001 = LGF0180005 ) AS imagen 
                FROM lg00018 
                WHERE LGF0180008 = 1 AND 
                      LGF0180002 = $nivel AND 
                      LGF0180003 = $modulo AND 
                      LGF0180004 = $leccion 
                        GROUP BY LGF0180005  
                        ORDER BY LGF0180006 ".$limit_sql;
			return $this->doSelect();
		}

		public function ultimoAvance($modulo, $leccion) {
			$this->query = "SELECT LGF0150002, (SELECT LGF0140002 FROM lg00014 WHERE LGF0140001 = LGF0150004) as nivel, (SELECT LGF0160002 FROM lg00016 WHERE LGF0160001 = $leccion) as leccion FROM lg00015 WHERE LGF0150001 = $modulo";
			return $this->doSelect();
		}

		public function lecciones_docente_grupos($modulo, $grupo, $docente) {
			$this->query = "SELECT *,(SELECT LGF0370005 FROM lg00037 WHERE LGF0370002 = $docente AND LGF0370003 = $grupo AND LGF0370004 = $modulo AND LGF0370005 = LGF0160001) AS dato FROM lg00016 WHERE LGF0160004 = $modulo AND LGF0160005 = 1;";
			// echo $this->query;
			return $this->doSelect();
		}

		public function obtener_accesos_grupos($docente, $grupo, $lecciones, $modulo, $opc = 0) {
			if ($opc == 1) {
				$complemento = " AND LGF0370005 in ($lecciones)";
			} else if ($opc == 2) {
				$complemento = " AND LGF0370005 not in ($lecciones)";
			}
			$this->query = "SELECT * FROM lg00037 WHERE LGF0370002 = $docente AND LGF0370003 = $grupo AND LGF0370004 = $modulo $complemento";
			// echo $this->query."<br>";
			return $this->doSelect();
		}

		public function test($sql) {
			$this->query = $sql;
			return $this->doSelect();
		}

		public function evaluacion_alumno($opcion, $institucion, $cliente) {
			if ($opcion == 3) {
				if ($_SESSION['perfil'] == 1) { // Administrador
					if (empty($institucion) && empty($cliente)) {
						$condicion = "";
					} else if (!empty($institucion) && empty($cliente)) {
						$condicion = " AND t1.LGF0010038 = ".$institucion;
					} else if (empty($institucion) && !empty($cliente)) {
						$condicion = " AND t1.LGF0010038 in (SELECT LGF0270001 FROM lg00027 WHERE LGF0270021 = $cliente)";
					}
				} else if ($_SESSION['perfil'] == 4) { // Institucion
					$condicion = " AND t1.LGF0010038 = ".$_SESSION['idUsuario'];
				} else if ($_SESSION['perfil'] == 3) { // Cliente
					if ($institucion == "") {
						$buscar = "LGF0270021 = ".$_SESSION['idUsuario'];
					} else {
						$buscar = "LGF0270001 = ".$institucion;
					}
					$this->query = "SELECT LGF0270001, LGF0270002 FROM lg00027 WHERE ".$buscar;
					$result = $this->doSelect();
					for ($i=0; $i < count($result); $i++) { 
						if ($i == 0) {
							$ids = $result[$i]['LGF0270001'];
						} else {
							$ids.= ",".$result[$i]['LGF0270001'];
						}
					}
					$condicion = " AND t1.LGF0010038 in (".$ids.")";
				} else if ($_SESSION['perfil'] == 6) {
					$result = $this->obtener_docentes($_SESSION['idUsuario']);
					$condicion = " AND  t1.LGF0010039 = ".$result[0]['idgrupo'];
				}
			}
			// echo "Mi condicion\n\n".$condicion."\n\n";
			$this->query = "SELECT t1.LGF0010001 AS ID, t2.LGF0220001 AS evaluacion, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004, t1.LGF0010039 FROM lg00001 t1 inner JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010007 = 2 $condicion AND t1.LGF0010008 = 1 GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010002 ASC";
			return $this->doSelect();
		}

		public function complemento_habilidades($usuario, $tipo) {
			// $this->query = "SELECT (COUNT(IF(t4.LGF0230005 = 1, 1, NULL )) * 100 ) / IF (t7.LGF0190010 = 1, COUNT( t4.LGF0230002 ), 0) as complemento FROM lg00022 t3 INNER JOIN lg00023 t4 ON t4.LGF0230002 = t3.LGF0220001 INNER JOIN lg00020 t5 ON t5.LGF0200001 = t4.LGF0230003 INNER JOIN lg00001 t6 ON t6.LGF0010001 = t3.LGF0220002 INNER JOIN lg00019 t7 ON t7.LGF0190001 = t5.LGF0200009  WHERE t4.LGF0230002 = t3.LGF0220001 AND t3.LGF0220002 = $usuario AND t5.LGF0200010 = $tipo";
			$this->query = "SELECT ((SELECT COUNT(*) FROM lg00020 WHERE LGF0200001 IN (SELECT LGF0230003 FROM lg00023 WHERE LGF0230002 IN ( SELECT LGF0220001 FROM lg00022 WHERE LGF0220002 = $usuario AND LGF0230005 = 1)) AND LGF0200010 = 2) / COUNT(*)) * 100 as aciertos FROM lg00020 WHERE LGF0200001 IN (SELECT LGF0230003 FROM lg00023 WHERE LGF0230002 IN ( SELECT LGF0220001 FROM lg00022 WHERE LGF0220002 = $usuario )) AND LGF0200010 = $tipo;";
			// return $this->query."<br><br>******<br><br>";
			return $this->doSelect();
		}

		public function obtener_usuarios() {
			$this->query = "SELECT t1.LGF0010001 AS ID, t2.LGF0220001 AS evaluacion, t1.LGF0010002, t1.LGF0010003, t1.LGF0010004 FROM lg00001 t1 INNER JOIN lg00022 t2 ON t2.LGF0220002 = t1.LGF0010001 WHERE t1.LGF0010007 = 2 AND t1.LGF0010008 = 1 GROUP BY t1.LGF0010001 ORDER BY t1.LGF0010001 ASC;";
			return $this->doSelect();
		}
	}