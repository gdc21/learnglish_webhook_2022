<?php

class EstadisticasSistema extends UniversalDatabase
{
    public function minutosEmpleandoSistema($tipo = '', $id = 0){
        $tablasAdicionales = '';
        $inTipoUsuario     = ' (2) ';



        if($tipo == 'semanaPorDia'){
            $seleccionTipo = " DATE_FORMAT(log_session.lgf0360004,'%W %d') AS diaSemana, ";

            $condicionYAgrupacion = " AND week(log_session.lgf0360004) = week(now()) AND YEAR(log_session.lgf0360004) = YEAR(now()) 
                GROUP BY DAYOFWEEK(log_session.lgf0360004) ";

        }
        elseif($tipo == 'semanaSoloMinutos'){
            $seleccionTipo = "";

            $condicionYAgrupacion = "AND week(log_session.lgf0360004) = week(now()) AND YEAR(log_session.lgf0360004) = YEAR(now())";
        }
        elseif($tipo == 'mesPorDia'){
            $seleccionTipo = " DATE_FORMAT(log_session.lgf0360004,'%W %d') AS diaMes, ";

            $condicionYAgrupacion = " AND MONTH(log_session.lgf0360004) = month(now()) AND YEAR(log_session.lgf0360004) = YEAR(now())  
                GROUP BY DAY(log_session.lgf0360004);";
        }
        elseif($tipo == 'mesSoloMinutos'){
            $seleccionTipo = "";
            $condicionYAgrupacion = " AND MONTH(log_session.lgf0360004) = month(now()) AND YEAR(log_session.lgf0360004) = YEAR(now())";
        }
        elseif ($tipo == 'tiempoTotalGeneral'){
            $seleccionTipo = "";
            $condicionYAgrupacion = " AND LGF0360006 != 0 and LGF0360007 != 0 and LGF0360008 != 0";
        }
        elseif ($tipo == 'tiempoTotalPorNiveles'){
            $seleccionTipo = " niveles.LGF0140002 as nivel, ";
            $condicionYAgrupacion = " and log_session.LGF0360006 = niveles.LGF0140001 
                GROUP BY niveles.LGF0140001;";
            $tablasAdicionales = ", lg00014 AS niveles";
        }

        elseif ($tipo == 'tiempoTotalPorModulos'){
            $seleccionTipo = " modulos.LGF0150002 AS modulo, ";
            $condicionYAgrupacion = " and log_session.LGF0360007 = modulos.LGF0150001 
                GROUP BY log_session.LGF0360007;";
            $tablasAdicionales = ", lg00015 AS modulos";
        }
        elseif ($tipo == 'tiempoTotalPorModulosDeInstitucion'){
            $seleccionTipo = " modulos.LGF0150002 AS modulo, ";
            $condicionYAgrupacion = " and log_session.LGF0360007 = modulos.LGF0150001 
                AND modulos.LGF0150001 in (".join(',', $id).")  
                GROUP BY log_session.LGF0360007;";
            $tablasAdicionales = ", lg00015 AS modulos";
        }
        elseif($tipo == 'PreescolarInstitucion'){
            $seleccionTipo = " modulos.LGF0150002 AS modulo, ";
            $condicionYAgrupacion = " and log_session.LGF0360007 = modulos.LGF0150001
                AND modulos.LGF0150004 = 1 
                GROUP BY log_session.LGF0360007;";
            $tablasAdicionales = ", lg00015 AS modulos";
            $inTipoUsuario     = ' (2) AND usuarios.LGF0010038 = '.$id;
        }
        elseif($tipo == 'PrimariaInstitucion' ){
            $seleccionTipo = " modulos.LGF0150002 AS modulo, ";
            $condicionYAgrupacion = " and log_session.LGF0360007 = modulos.LGF0150001
                AND modulos.LGF0150004 = 2 
                GROUP BY log_session.LGF0360007;";
            $tablasAdicionales = ", lg00015 AS modulos";
            $inTipoUsuario     = ' (2) AND usuarios.LGF0010038 = '.$id;
        }
        elseif( $tipo == 'SecundariaInstitucion'){
            $seleccionTipo = " modulos.LGF0150002 AS modulo, ";
            $condicionYAgrupacion = " and log_session.LGF0360007 = modulos.LGF0150001
                AND modulos.LGF0150004 = 3 
                GROUP BY log_session.LGF0360007;";
            $tablasAdicionales = ", lg00015 AS modulos";
            $inTipoUsuario     = ' (2) AND usuarios.LGF0010038 = '.$id;
        }

        elseif ($tipo == 'tiempoTotalPorDocentes'){
            $seleccionTipo = "";
            $condicionYAgrupacion = "";
            $inTipoUsuario     = ' (6) ';
        }
        elseif ($tipo == 'tiempoTotalPorAdmins'){
            $seleccionTipo = "";
            $condicionYAgrupacion = "";
            $inTipoUsuario     = ' (1) ';
        }



        $this->query = "SELECT ".
            $seleccionTipo.
            "(SUM(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo 
            FROM lg00036 AS log_session ".$tablasAdicionales.
            " WHERE log_session.LGF0360002 
            IN (
                SELECT LGF0010001 AS id
                FROM lg00001 AS usuarios 
                where usuarios.LGF0010007 in ".$inTipoUsuario." 
            )".$condicionYAgrupacion;

        #echo ($this->query)."<br>";
        #echo md5($this->query)."<hr>";

        return $this->doSelect();
    }


    public function obtenerEstadisticasPorAlumno($idUsuarios = []){
        $sql = '';
        if($idUsuarios != []){
            $sql = " AND usuarios.LGF0360001 IN (".join(', ', $idUsuarios).") ";
        }

        $this->query = "SELECT 
            log_session.LGF0360002 AS id_usuario,
            log_session.LGF0360006 as nivel,
            log_session.LGF0360007 as modulo,
            log_session.LGF0360008 as leccion, 
            DATE_FORMAT(log_session.lgf0360004,'%W %d de %M %Y') AS dia,
            (SUM(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo
            from lg00036 AS log_session  
            WHERE log_session.LGF0360002 
            IN (
               SELECT LGF0010001 AS id
               FROM lg00001 AS usuarios 
               where usuarios.LGF0010007 IN (2)
                ".$sql."
            )
            
            GROUP BY log_session.LGF0360001 
            ORDER BY log_session.LGF0360001 desc;";
        #echo $this->query;
        return $this->doSelect();
    }

    /** Sumamos el tiempo total empleado el sistema de acuerdo al tipo de consulta
     * @return array|false
     */
    public function obtenerHorasTotalesUsoSistema($tipo = '', $id = 0){
        $this->query = "SELECT 
            sum(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005)) AS tiempo
            FROM lg00036 AS log_session
            WHERE log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios 
                WHERE usuarios.LGF0010007 IN (2) 
            )";

        /**Si el tipo de consulta cambia se obtiene estadisticas de acuerdo al caso
         */
        if($tipo == 'docentesGeneral'){
            $this->query .= " AND LGF0360002 
                in (SELECT usuarios.LGF0010001 FROM lg00001 AS usuarios WHERE LGF0010007 = 6)";
        }
        /** Si hay cliente especificado obtiene las instituciones del mismo, luego los id de usuarios
         * que pertenecen a esa institucion (tabla usuarios) y finalmente obtiene los registros
         * segun los id de usuarios que posee la institucion
         */
        elseif($tipo == 'clienteEspecifico'){
            /*Where id_usuario*/
            $this->query .= " AND log_session.LGF0360002 ".
                /*in select id usuarios cuando pertenezcan a la institucion y sean docentes y alumnos*/
                "IN (SELECT usuarios.LGF0010001 
                    FROM lg00001 AS usuarios 
                    WHERE usuarios.LGF0010007 IN (2, 6)
		            AND usuarios.LGF0010038 ".
                /*in select instituciones del cliente con id especificado*/
                "IN (
                        SELECT instituciones.LGF0270001  
                        FROM lg00027 AS instituciones 
                        WHERE instituciones.LGF0270021 = ".$id."
                    )
                )";
        }
        /** Selecciona a los usuarios cuando el id este relacionado a la institucion inidacada
         */
        elseif($tipo == 'institucionEspecifica'){
            $this->query .= " AND log_session.LGF0360002 
                IN (
                    SELECT usuarios.LGF0010001
                    FROM lg00001 AS usuarios
                    WHERE usuarios.LGF0010038 = ".$id."
                )";
        }
        /** Selecciona a los usuarios cuando su id este relacionado a un grupo especificado
         */
        elseif($tipo == 'grupoEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios 
                WHERE usuarios.LGF0010039 = ".$id.
                ")";
        }
        /** Selecciona a los usuarios cuando su id este relacionado a un docente especificado
         */
        elseif($tipo == 'docenteEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios, lg00029 AS grupos 
                where grupos.LGF0290006 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010001
            )";
        }
        /** Indicando si es un nivel especifico solo devuelve datos del mismo nivel
         */
        elseif($tipo == 'nivelEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios
                WHERE usuarios.LGF0010023 = ".$id."
            )";
        }


        return $this->doSelect ();
    }


    /**Obtiene mes, año y tiempo total de uso del sistema
     * @return array|false
     */
    public function obtenerMesAnioTiempoDeUsoSistema($tipo = '', $id = 0){
        #sec_to_time(SUM(TIMESTAMPDIFF(SECOND, log_session.lgf0360004, log_session.lgf0360005))) as tiempo
        $this->query = "SELECT 
                distinct(MONTH(log_session.lgf0360004)) as mes,
                (YEAR(log_session.lgf0360004)) as anio,
                (SUM(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo
            FROM lg00036 AS log_session 
            WHERE log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios 
                WHERE usuarios.LGF0010007 IN (2) 
            )";

        /**Si el tipo de consulta cambia se obtiene estadisticas de acuerdo al caso
         */
        if($tipo == 'docentesGeneral'){
            $this->query .= " AND LGF0360002 
                IN (SELECT usuarios.LGF0010001 FROM lg00001 AS usuarios WHERE usuarios.LGF0010007 = 6)";
        }

        /** Si hay cliente especificado obtiene las instituciones del mismo, luego los id de usuarios
         * que pertenecen a esa institucion (tabla usuarios) y finalmente obtiene los registros
         * segun los id de usuarios que posee la institucion
         */
        elseif($tipo == 'clienteEspecifico'){
            /*Where id_usuario*/
            $this->query .= " AND log_session.LGF0360002 ".
                /*in select id usuarios cuando pertenezcan a la institucion y sean docentes y alumnos*/
                "IN (SELECT usuarios.LGF0010001 
                    FROM lg00001 AS usuarios 
                    WHERE usuarios.LGF0010007 IN (2, 6)
		            AND usuarios.LGF0010038 ".
                /*in select instituciones del cliente con id especificado*/
                "IN (
                        SELECT instituciones.LGF0270001  
                        FROM lg00027 AS instituciones 
                        WHERE instituciones.LGF0270021 = ".$id."
                    )
                )";
        }
        /** Selecciona a los usuarios cuando el id este relacionado a la institucion inidacada
         */
        elseif($tipo == 'institucionEspecifica'){
            $this->query .= " AND log_session.LGF0360002 
                IN (
                    SELECT usuarios.LGF0010001
                    FROM lg00001 AS usuarios
                    WHERE usuarios.LGF0010038 = ".$id."
                )";
        }
        /** Selecciona a los usuarios cuando su id este relacionado a un grupo especificado
         */
        elseif($tipo == 'grupoEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios 
                WHERE usuarios.LGF0010039 = ".$id.
                ")";
        }
        /** Selecciona a los usuarios cuando su id este relacionado a un docente especificado
         */
        elseif($tipo == 'docenteEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios, lg00029 AS grupos 
                where grupos.LGF0290006 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010001
            )";
        }
        /** Indicando si es un nivel especifico solo devuelve datos del mismo nivel
         */
        elseif($tipo == 'nivelEspecifico'){
            $this->query .= " AND log_session.LGF0360002 
            IN (
                SELECT usuarios.LGF0010001 
                FROM lg00001 AS usuarios
                WHERE usuarios.LGF0010023 = ".$id."
            )";
        }

        /**Agregamos el restante de la consulta
         */
        $this->query .=
            " GROUP BY YEAR(log_session.lgf0360004),MONTH(log_session.lgf0360004)
                ORDER BY YEAR(log_session.lgf0360004),MONTH(log_session.lgf0360004);";

        return $this->doSelect ();
    }


    /** Trae a los alumnos de un determinado id de docente
     * @param $id ID del docente
     * @return array|false
     */
    public function obtenerEstadisticasAlumnosDesdeDocente($id = 0){
        #echo $id;
        $this->query = "SELECT 
            log_session.LGF0360002 AS id,
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre,
            DATE_FORMAT(log_session.lgf0360004,'%W %d de %M %Y') AS fecha,
            (SUM(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo 
            FROM lg00036 AS log_session, lg00001 as usuarios 
            where usuarios.LGF0010001=log_session.LGF0360002
            and  log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos  
                where usuarios.LGF0010007 = 2
                and grupos.LGF0290006 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010039 
            )
            GROUP BY day(log_session.lgf0360004), id  order by id ";
        #echo $this->query;
        return $this->doSelect();
    }

    public function obtenerIDSEstadisticasAlumnosDesdeDocente($id = 0){
        $this->query = "SELECT 
            distinct (log_session.LGF0360002) AS id,
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre 
            FROM lg00036 AS log_session, lg00001 as usuarios 
            where  log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos  
                where usuarios.LGF0010007 = 2
                and grupos.LGF0290006 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010039 
            )
            and usuarios.LGF0010001 = log_session.LGF0360002 
            GROUP BY day(log_session.lgf0360004), id  order by id ";
        #echo $this->query;
        return $this->doSelect();
    }


    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @param int $id Id docente
     * @param string $tipo Tipo de consulta a realizar
     * @return array|false
     */
    public function obtenerAlumnos($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0010001 as id,
                concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre,
                'alumnos' as tipoElemento,
                LGF0010021 as sexo
            FROM lg00001 where LGF0010007 = 2";

        /** Cuando pertenezcan al DOCENTE con el id buscando la relacion grupos y usuarios para obtenerlos
         */
        if($id != 0){
            $this->query = "SELECT  
                usuarios.LGF0010001 as id,
                concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre,
                'alumnos' as tipoElemento,
                LGF0010005 as usuarioDeSistema,
                LGF0010021 as sexo 
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos  
                where usuarios.LGF0010007 = 2 
                and grupos.LGF0290006 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010039;";
        }
        if($tipo == 'consultaNombre'){
            $this->query = "SELECT concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre FROM lg00001 where LGF0010001 = ".$id.";";
        }
        elseif($tipo == 'alumnosDelGrupo'){
            $this->query = "SELECT  
                usuarios.LGF0010001 as id,
                concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre,
                'alumnos' as tipoElemento,
                LGF0010005 as usuarioDeSistema,
                LGF0010021 as sexo 
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos  
                where usuarios.LGF0010007 = 2 
                and usuarios.LGF0010039 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010039;";
        }
        elseif($tipo == 'alumnosDeInstitucion'){
            $this->query = "SELECT  
                usuarios.LGF0010001 as id,
                concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre,
                'alumnos' as tipoElemento,
                LGF0010005 as usuarioDeSistema,
                LGF0010021 as sexo 
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos  
                where usuarios.LGF0010007 = 2 
                and usuarios.LGF0010038 = ".$id." 
                and grupos.LGF0290001 = usuarios.LGF0010039;";
        }

        return $this->doSelect ();
    }

    public function obtenerAlumnosNoHanUsadoElSistema($id = 0, $ids = [], $tipo = ''){
        $ids = array_unique($ids);

        $campoBusqueda = " and usuarios.LGF0010039 = ".$id;
        if($tipo == "deInstitucion"){
            $campoBusqueda = " and usuarios.LGF0010038 = ".$id;
        }elseif($tipo == "ninguno"){
            $campoBusqueda = "";
        }
        $this->query = "SELECT  
                usuarios.LGF0010001 as id,
                concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre,
                'alumnos' as tipoElemento,
                LGF0010005 as usuarioDeSistema,
                LGF0010021 as sexo 
                FROM 
                     lg00001 AS usuarios, 
                     lg00029 as grupos
                
                where usuarios.LGF0010007 = 2 
                AND usuarios.LGF0010001 not in (".join(',',$ids).")
                ".$campoBusqueda. "
                and grupos.LGF0290001 = usuarios.LGF0010039;";

        #echo $this->query;
        return $this->doSelect();
    }


    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @return array|false
     */
    public function obtenerInstituciones($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0270001 as id,
                LGF0270002 as nombre,
                'instituciones' as tipoElemento
            FROM lg00027";

        /** Cuando pertenezcan al cliente con el id
         */
        if($id != 0){
            $this->query .= " where LGF0270021 = ".$id.";";
        }

        if($tipo == 'consultaNombre'){
            $this->query = "SELECT LGF0270002 as nombre FROM lg00027 where LGF0270001 = ".$id.";";
        }
        return $this->doSelect ();
    }

    public function obtenerEstadisticasAlumnosDesdeInstitucion($id = 0){
        $this->query = "SELECT log_session.LGF0360002 AS id, 
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre, 
            DATE_FORMAT(log_session.lgf0360004,'%W %d de %M %Y') AS fecha, 
            (sum(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo 
            FROM lg00036 AS log_session, lg00001 as usuarios 
            where usuarios.LGF0010001=log_session.LGF0360002 
            and log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id 
                FROM lg00001 AS usuarios 
                where usuarios.LGF0010038 = ".$id." 
                and usuarios.LGF0010007 = 2 
            ) 
            GROUP BY day(log_session.lgf0360004), id order by id";

        #echo $this->query;
        return $this->doSelect();
    }

    public function obtenerIDSEstadisticasAlumnosDesdeInstitucion($id = 0){
        $this->query = "SELECT 
            DISTINCT (log_session.LGF0360002) AS id,
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre 
            FROM lg00036 AS log_session, lg00001 AS usuarios
            WHERE usuarios.LGF0010001 = log_session.LGF0360002

            and  log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id
                FROM 
                     lg00001 AS usuarios 
                where usuarios.LGF0010038 = ".$id." 
                and usuarios.LGF0010007 = 2 
            )
            GROUP BY day(log_session.lgf0360004), id  order by id ";

        return $this->doSelect();
    }


    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @param int $id Id del cliente a buscar
     * @param string $tipo Determina si se consultada en general o se hara una consulta de nombre especifica a partir de id
     * @return array|false
     */
    public function obtenerClientes($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0280001 as id,
                LGF0280002 as nombre,
                'clientes' as tipoElemento
            FROM lg00028";

        if($id != 0){
            $this->query .= " where LGF0280001 = ".$id.";";
        }
        if($tipo == 'consultaNombre'){
            $this->query = "SELECT LGF0280002 as nombre FROM lg00028 where LGF0280001 = ".$id.";";
        }
        return $this->doSelect ();
    }

    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @param int $id Id del cliente a buscar
     * @param string $tipo Determina si se consultada en general o se hara una consulta de nombre especifica a partir de id
     * @return array|false
     */
    public function obtenerNiveles($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0140001 as id,
                LGF0140002 as nombre,
                'niveles' as tipoElemento
            FROM lg00014";

        if($id != 0){
            $this->query .= " where LGF0140001 = ".$id.";";
        }
        if($tipo == 'consultaNombre'){
            $this->query = "SELECT LGF0140002 as nombre FROM lg00014 where LGF0140001 = ".$id.";";
        }
        return $this->doSelect ();
    }

    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @param int $id Id del cliente a buscar
     * @param string $tipo Determina si se consultada en general o se hara una consulta de nombre especifica a partir de id
     * @return array|false
     */
    public function obtenerModulos($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0150001 as id,
                LGF0150002 as nombre,
                'niveles' as tipoElemento
            FROM lg00015";

        if($id != 0){
            $this->query .= " where LGF0150001 = ".$id.";";
        }
        if($tipo == 'consultaNombre'){
            $this->query = "SELECT LGF0150002 as nombre FROM lg00015 where LGF0150001 = ".$id.";";
        }
        return $this->doSelect ();
    }

    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @return array|false
     */
    public function obtenerGrupos($id = 0, $tipo = ''){
        $this->query = "SELECT 
                LGF0290001 as id,
                CONCAT(LGF0290002, '<br>(',COUNT(usuarios.LGF0010001), ' alumnos)' ) as nombre, 
                'grupos' as tipoElemento,
                'alumnosDeGrupo' as rutaParaVerAlumnosDeGrupo 
            FROM lg00029 as grupos, lg00001 as usuarios 
            where (usuarios.LGF0010039 = grupos.LGF0290001 and usuarios.LGF0010007 = 2) ";
        /** Cuando pertenezcan a la institucion con el id
         */
        if($id == 0){
            $this->query .= " GROUP BY grupos.LGF0290001";
        }
        if($id != 0 && $tipo != 'nivelEspecifico'){
            $this->query = "SELECT 
                LGF0290001 as id,
                LGF0290002 as nombre,
                'grupos' as tipoElemento,
                'alumnosDeGrupo' as rutaParaVerAlumnosDeGrupo 
            FROM lg00029 where LGF0290004 = ".$id." ;";
        }

        if($tipo == 'consultaNombre'){
            $this->query = "SELECT LGF0290002 as nombre FROM lg00029 where LGF0290001 = ".$id.";";
        }
        elseif($tipo == 'nivelEspecifico'){
            $this->query .= " AND LGF0290005 IN (
                SELECT LGF0150001 as id_modulo from lg00015 as modulos where modulos.LGF0150004 = ".$id." 
            ) GROUP BY grupos.LGF0290001";
        }
        #echo $this->query;
        return $this->doSelect ();
    }

    public function obtenerEstadisticasAlumnosDesdeGrupo($id = 0){
        $this->query = "SELECT log_session.LGF0360002 AS id, 
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre, 
            DATE_FORMAT(log_session.lgf0360004,'%W %d de %M %Y') AS fecha, 
            (sum(TIMESTAMPDIFF(MINUTE, log_session.lgf0360004, log_session.lgf0360005))) as tiempo 
            FROM lg00036 AS log_session, lg00001 as usuarios 
            where usuarios.LGF0010001=log_session.LGF0360002 
            and log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id 
                FROM lg00001 AS usuarios 
                where usuarios.LGF0010039 = ".$id." 
            ) 
            GROUP BY day(log_session.lgf0360004), month(log_session.lgf0360004), year(log_session.lgf0360004), id 
            order by log_session.LGF0360001 desc";

        #echo $this->query;
        return $this->doSelect();
    }

    public function obtenerIDSEstadisticasAlumnosDesdeGrupo($id = 0){
        $this->query = "SELECT 
            DISTINCT (log_session.LGF0360002) AS id,
            concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) AS nombre 
            FROM lg00036 AS log_session, lg00001 AS usuarios
            WHERE usuarios.LGF0010001 = log_session.LGF0360002

            and  log_session.LGF0360002 
            IN ( 
                SELECT LGF0010001 as id
                FROM 
                     lg00001 AS usuarios 
                where usuarios.LGF0010039 = ".$id." 
                and usuarios.LGF0010007 = 2 
            )
            GROUP BY day(log_session.lgf0360004), id  order by id ";

        return $this->doSelect();
    }

    /** Obtiene los clientes de la base de datos para mostrar en estadisticasElemento
     * @return array|false
     */
    public function obtenerDocentes($id = 0, $tipo = ''){
        $this->query = "SELECT 
                usuarios.LGF0010001 as id,
                concat_ws(' ', usuarios.LGF0010002, usuarios.LGF0010003, usuarios.LGF0010004) as nombre,
                'docentes' as tipoElemento
            FROM lg00001 as usuarios where usuarios.LGF0010007 = 6 ";

        if($tipo == 'nivelEspecifico'){
            $this->query .= "AND usuarios.LGF0010023 = ".$id;
        }
        /** Cuando pertenezcan al grupo con el id
         */
        elseif($id != 0 && $tipo != 'docentesInstitucion'){
            #echo "si";
            #$this->query .= " and LGF0010039 = ".$id.";";
            $this->query .= " and usuarios.LGF0010001 IN (
                SELECT grupos.LGF0290006 FROM lg00029 AS grupos WHERE grupos.LGF0290001 = ".$id."
            ) ";
        }
        if($tipo == 'consultaNombre'){
            $this->query = "SELECT concat_ws(' ', LGF0010002, LGF0010003, LGF0010004) as nombre FROM lg00001 where LGF0010001 = ".$id.";";
        }elseif($tipo == 'docentesInstitucion'){
            $this->query .= "AND lg00001.LGF0010038 = ".$id;
        }
        #echo "Here> ".$this->query;
        return $this->doSelect ();
    }

    /**Obtiene los meses del año
     *
     * @return string[]
     */
    public function obtenerMesesDelAnio()
    {
        return [
            'Adicional saltando indice 0',
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];
    }

    public function obtenerMesDesdeNumero($mes){

        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
        return $meses[$mes];
    }



}